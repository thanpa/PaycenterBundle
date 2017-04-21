# PaycenterBundle
Piraeus bank paycenter bundle

[![Build Status](https://travis-ci.org/george-thanpa/PaycenterBundle.svg?branch=master)](https://travis-ci.org/george-thanpa/PaycenterBundle)

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require thanpa/paycenter-bundle "1.1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Thanpa\PaycenterBundle\ThanpaPaycenterBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Configuration
-------------
* Add following to your ```app/config/parameters.yml.dist``` without changing its values
* Add following to your ```app/config/parameters.yml```, replace placeholder values to bank provided values.

```
    thanpa_paycenter.acquirerId: placeholder-value-change-me
    thanpa_paycenter.merchantId: placeholder-value-change-me
    thanpa_paycenter.posId: placeholder-value-change-me
    thanpa_paycenter.username: placeholder-value-change-me
    thanpa_paycenter.password: placeholder-value-change-me
    thanpa_paycenter.param_back_link: "" # its contents used as a query string in the URL returned to the user when the "Cancel" button is pressed.
```

Add following code to your ```app/config/routing.yml```:

```
# app/config/routing.yml
redirectToBank:
    path:      /order/redirectToBank
    defaults:  { _controller: ThanpaPaycenterBundle:RedirectionPay:redirectToBank }
```

Step 4: Update database
-----------------------
This bundle supports [Doctrine](http://symfony.com/doc/current/book/doctrine.html), please run the following command:
```
# bin/console for Symfony3
$ app/console doctrine:schema:update --force
```

If you're using [DoctrineMigrationsBundle](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html) run:
```
# bin/console for Symfony3
$ app/console doctrine:migrations:diff
$ app/console doctrine:migrations:migrate
```

## Parameters:
* ```thanpa_paycenter.acquirerId```: your Acquirer Id (provided by bank)
* ```thanpa_paycenter.merchantId```: Your Merchant Id (provided by bank)
* ```thanpa_paycenter.posId```: Your Pos Id (provided by bank)
* ```thanpa_paycenter.username```: Your API username (provided by bank)
* ```thanpa_paycenter.password```: Your API password (provided by bank)
* ```thanpa_paycenter.param_back_link```: use ```""``` for no parameters, or add your parameters: ```p1=v1&p2=v2```. Make sure not to include ? as first character.

Payment Success / Failure Pages:
--------------------------------

*Please note you need to inform your bank of your payment success/fail urls. Let them know you'd like API responses to be ```POST```ed back to your site.*

* Create a new controller in your application named ```PaymentController.php```.
* You need to implement methods defined in ```PaymentResponseInterface```.

Your code should look like this:

## Payment Success Page
```php
    public function successAction()
    {
        $service = $this->get('thanpa_paycenter.payment_response');
        $paymentResponse = $service->extract($request);
        
        // your logic here: set order as 'paid', notify customer etc
        
        $this->addFlash('success', $service->getDisplayMessage($paymentResponse));
        // redirect where you need to redirect
    }
```

## Payment Failed Page
```php
    public function failAction()
    {
        $service = $this->get('thanpa_paycenter.payment_response');
        $paymentResponse = $service->extract($request);

        // your logic here: set order as 'payment failed', email customer etc
        
        $this->addFlash('error', $service->getDisplayMessage($paymentResponse));
        // redirect where you need to redirect
    }
```

## Back Link Page
```php
    public function backlinkAction()
    {
        $service = $this->get('thanpa_paycenter.payment_response');
        $paymentResponse = $service->extract($request);

        // your logic here: actually probably nothing
                
        $this->addFlash('warning', $this->get('translator')->trans('You clicked cancel!'));
        // redirect where you need to redirect
    }
```

```Thanpa\PaycenterBundle\Entity\PaymentResponse``` class has access methods you can use to get response information.

**NOTE:**
* bank requires you to persist the response in your system for future reference (saved in table thanpa_payment_response)
* for success calls the extract method of the payment_response service will also calculate the hash to ensure this is a valid response from the bank.

Add the following to your ```app/config/routing.yml``` (adjust the paths, and controller path to match your application):

```
payment_success:
    path:      /order/payment/success
    defaults:  { _controller: AppBundle:PaymentController:success }
    methods:   [POST]

payment_fail:
    path:      /order/payment/fail
    defaults:  { _controller: AppBundle:PaymentController:fail }
    methods:   [POST]
    
payment_backlink:
    path:      /order/payment/backlink
    defaults:  { _controller: AppBundle:PaymentController:backlink }
    methods:   [POST]
```

How to use this bundle:
-----------------------
In your application, when there's a new order created, you should have a unique identifier used as order reference (usually a 5 characters string).
You can also use order id if you don't have an order reference.

### Step 1: Save order object in database

When your order is created, it should be saved as "payment pending".

### Step 2: Get a new ticket from bank's API

This is when you should call the ticket mechanism.

```php

// ...

// get ticket issuer service
$issuer = $this->get('thanpa_paycenter.ticket_issuer');
$issuer->setMerchantReference($orderReference); // your unique order identifier

$ticket = $issuer->getTicket();

```

If request to bank's API succeeded you should now have a new ticket in ```$ticket```, and saved in your database.

### Step 3: Redirect user to secure payment environment

In your controller, redirect user to ```redirectToBank``` route (as defined previously):

```php
        return $this->redirect(
            $this->generateUrl(
                'redirectToBank', 
                [
                    'languageCode' => 'el-GR',
                    'merchantReference' => $orderReference, // or your unique order/payment identifier 
                ]
            )
        );
```

This should show a form with hidden fields and will be submitted automatically (requires user to have Javascript enabled).
After the form is submitted, user is redirected to bank's secure environment to complete the payment.

### Step 4: User is redirected to your site after payment is completed successfully/failed/cancelled
* If user does not complete payment and clicks "Cancel" he/she is redirected to the specified url you provided to bank (this is not configurable in the bundle).
* If payment is successfully completed, user is redirected to your ```payment_success``` route.
* If payment has failed, user is redirected to your ```payment_fail``` route.
* If user clicked "cancel" then user is redirected to your ```payment_backlink``` route.

**NOTE:** I strongly suggest you read bank's API manual to fully understand how it works.

How to run tests
----------------

You need phpunit installed on your system.

```
$ phpunit --testsuite PaycenterBundle
```

You can modify ```phpunit.xml.dist``` to match your needs. By default a code coverage log will be generated in ```build/``` directory.
