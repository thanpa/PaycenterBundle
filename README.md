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

```
