Layout Hints Magento 2 Module
=============================

[![Build Status](https://travis-ci.org/webgriffe/module-layout-hints.svg?branch=master)](https://travis-ci.org/webgriffe/module-layout-hints)

A Magento 2 module which shows layout hints useful for development.
It's the Magento 2 version of the [Webgriffe_TphPro](https://github.com/aleron75/Webgriffe_TphPro) Magento 1.x module.

Installation
------------

Please, use [Composer](https://getcomposer.org) and add `webgriffe/module-layout-hints` to your dependencies. Also add this repository to your `composer.json`.

	"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/webgriffe/module-layout-hints.git"
        }
    ]

Then enable the module and upgrade to be sure that DB install/upgrade runs (if any):

	$ php bin/magento module:enable Webgriffe_LayoutHints
	$ php bin/magento setup:upgrade
	
If you're using `production` or `default` Magento2 mode you need to run Dependency Injection compilation process:

	$ php bin/magento setup:di:compile
    
Usage
-----

Go to `Stores -> Configuration -> Advanced -> Developer -> Debug` and set `Layout Hints Enabled for Storefront` field to yes.
Then on storefont you'll see block hints as HTML comments. For example:

    <!-- [BLOCK BEGIN type="Magento\Customer\Block\Account\RegisterLink\Interceptor" name="register-link"] -->
    <li><a href="http://my-store.dev/customer/account/create/" >Create an Account</a></li>
    <!-- [BLOCK END type="Magento\Customer\Block\Account\RegisterLink\Interceptor" name="register-link"] -->
    
In this way block hints do not break page layout and you can leave it always enabled on your development environment.

To Do
-----

* Layout handles hints
* Hints as HTML block

Credits
-------

* Developed by [Webgriffe®](http://webgriffe.com)
