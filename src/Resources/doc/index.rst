Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: terminal

    $ composer require emanueleminotto/url-blacklist-bundle

This command requires you to have Composer installed globally, as explained
in the `installation chapter`_ of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new EmanueleMinotto\UrlBlacklistBundle\UrlBlacklistBundle(),
            );

            // ...
        }

        // ...
    }

Step 3: Configuration
---------------------

This bundle doesn't need a configuration, but it provides two new entities, so you
need to update your schema with:

.. code-block:: terminal

    $ php bin/console doctrine:schema:update

or even better, write and execute a new migration with:

.. code-block:: terminal

    $ php bin/console doctrine:migrations:diff
    $ php bin/console doctrine:migrations:migrate

Usage
-----

Two validator constraints are provided:

-  `Domain Validator Constraint`_
-  `URL Validator Constraint`_


.. _`installation chapter`: https://getcomposer.org/doc/00-intro.md
.. _`Domain Validator Constraint`: https://github.com/EmanueleMinotto/url-blacklist-bundle/tree/master/src/Resources/doc/validator-constraints/domain.rst
.. _`URL Validator Constraint`: https://github.com/EmanueleMinotto/url-blacklist-bundle/tree/master/src/Resources/doc/validator-constraints/url.rst
