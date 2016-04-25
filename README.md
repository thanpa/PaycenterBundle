# PaycenterBundle
Piraeus bank paycenter bundle

[![Build Status](https://travis-ci.org/george-thanpa/PaycenterBundle.svg?branch=master)](https://travis-ci.org/george-thanpa/PaycenterBundle)

*NOTE:* Please note this bundle is under heavy development.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require thanpa/paycenter-bundle "dev-master"
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

Step 3: Update database
-----------------------
This bundle supports Doctrine, please run the following command:
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

Configuration
-------------

App following to your ```app/config/parameters.yml``` and replace placeholder values to the ones provided by your bank.

```
    # paycenter parameters
    thanpa_paycenter.acquirerId: placeholder-value-change-me
    thanpa_paycenter.merchantId: placeholder-value-change-me
    thanpa_paycenter.posId: placeholder-value-change-me
    thanpa_paycenter.username: placeholder-value-change-me
    thanpa_paycenter.password: placeholder-value-change-me
    thanpa_paycenter.param_back_link: "" # its contents used as a query string in the URL returned to the user when the "Cancel" button is pressed.

```

Add following code to your ```app/config/routing.yml```:

```
redirectToBank:
    path:      /order/redirectToBank/{languageCode}/{merchantReference}
    defaults:  { _controller: ThanpaPaycenterBundle:RedirectionPay:redirectToBank, languageCode: 'el-GR', merchantReference: '' }
    requirements:
        languageCode:  el-GR|en-US|ru-RU|de-DE
```

**NOTE:** Redirect to bank requires javascript to be enabled on client's browser.

Bank supports following ```languageCode``` values:
* el-GR
* en-US
* ru-RU
* de-DE

## Parameters:
* thanpa_paycenter.param_back_link: use "" for no parameters, or add your parameters: ```p1=v1&p2=v2```. Make sure not to include ? as first character.

How to run tests
----------------

You need phpunit installed on your system.

```
$ phpunit --testsuite PaycenterBundle
```

You can modify ```phpunit.xml.dist``` to match your needs. By default a code coverage log will be generated in ```build/``` directory.
