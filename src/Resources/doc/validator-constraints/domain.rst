Domain Validator Constraint
===========================

- ``BlacklistedDomain`` checks if a domain or a subdomain is blocked (if the value isn't null or blank).

Basic Usage
-----------

Annotations:

.. code-block:: php

    // src/AppBundle/Entity/Link.php
    namespace AppBundle\Entity;

    use EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedDomain;

    class Link
    {
        /**
         * @BlacklistedDomain
         */
         protected $host;
    }

YAML:

.. code-block:: yaml

    # src/AppBundle/Resources/config/validation.yml
    AppBundle\Entity\Link:
        properties:
            host:
                - EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedDomain: ~

XML:

.. code-block:: xml

    <!-- src/AppBundle/Resources/config/validation.xml -->
    <?xml version="1.0" encoding="UTF-8" ?>
    <constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/constraint-mapping/constraint-mapping-1.0.xsd">

        <class name="AppBundle\Entity\Link">
            <property name="host">
                <constraint name="EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedDomain" />
            </property>
        </class>
    </constraint-mapping>

PHP:

.. code-block:: php

    // src/AppBundle/Entity/Link.php
    namespace AppBundle\Entity;

    use Symfony\Component\Validator\Mapping\ClassMetadata;
    use EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedDomain;

    class Link
    {
        public static function loadValidatorMetadata(ClassMetadata $metadata)
        {
            $metadata->addPropertyConstraint('host', new BlacklistedDomain());
        }
    }

Options
-------

message
~~~~~~~

**type**: ``string`` **default**: ``This value is blacklisted (category "%category%").``

This message is shown if the domain is blacklisted.
