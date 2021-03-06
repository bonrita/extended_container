# Extended container
Enhance or upgrade the Drupal 8 Container with new functionality

## Added functionality

### Service Subscribers
Added functionality for service subscribers.
For more information about service subscribers
[read](https://symfony.com/doc/3.4/service_container/service_subscribers_locators.html)

- Usage
  - It lazy loads services.

- How
  - Tag the service with the tag: **'container.drupal_service_subscriber'** instead of that one that is
   mentioned in the symfony docs.

***Example:***

Suppose you have a controller class: SubscribedServicesController that needs many dependencies.

Define the controller class as a service and tag it.

```
  extended_container_service_locator.subscribed_controllers:
    class: Drupal\extended_container_service_locator\Controller\SubscribedServicesController
    autowire: true
    tags:
      - { name: container.drupal_service_subscriber }
```

Implement the *Symfony\Component\DependencyInjection\ServiceSubscriberInterface* to add the services you wish to add.
```
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedServices() {
    return [
      'email.validator' => EmailValidator::class,
      'theme.manager' => ThemeManager::class
    ];
  }
```

**Note:**
[Optional Services](https://symfony.com/doc/current/service_container/service_subscribers_locators.html#optional-services)
are not supported.



Add the small container that will lazy load the services to the class constructor as below.
Note: Do not add the argument to your service definition as it will be added for you automatically when the container
is building the service.
```
use Psr\Container\ContainerInterface;


public function __construct(ContainerInterface $locator) {
 $this->locator = $locator;
}
```
It is required to type hint the constructor locator argument with the Psr **ContainerInterface** interface as shown.

Now, in the class methods access the defined services as below:
```
$this->locator->get('theme.manager')->getActiveTheme()->getName()
```

**Note:**

Service locators will only work if your controller is defined as a service.

### Global module configuration
Added the ability to globally define default configurations for all the services defined in the module in question.

Below are the configurations that can be globally configured for all services in the module in question.

- public
- tags
- autowire
- autoconfigure
- bind

***Example:***
```
services:
  _defaults:
    autowire: true
    autoconfigure: true
```

### Autowiring
Improved greatly on the autowiring feature. Below is what was improved.
* Enable autowiring for all services of a module by default i.e if enabled for that particular module.
 [Automatic Service Loading in services.yaml](https://symfony.com/doc/current/service_container.html#creating-configuring-services-in-the-container)
* Enable autowiring of interfaces. [More info](https://symfony.com/doc/3.4/service_container/autowiring.html)
* Add the ability to autowire dependencies on controller methods.

***Examples:***
Enable autowiring for all services defined in the module.
Note:

- This will only affect services defined in the module in question. This is a module based configuration.
- Add the **_default** key at the top of your services file as shown in the example.

```
services:
  _defaults:
    autowire: true
```
From this moment on you do not have to define arguments in your service definition as they will be automatically
added for you.

The example below should work without explicitly configuring the service arguments i.e if the default (_default)
autowiring (as shown above) was enabled .

Service definition:
```
  extended_container_service_locator.subscribed_service:
    class: Drupal\extended_container_service_locator\SubscribedServices
```
**Or** you may decide to enable or disable autowiring per service i.e
```
  extended_container_service_locator.subscribed_services:
    class: Drupal\extended_container_service_locator\SubscribedServicesController
    autowire: false
```
Class constructor:
```
public function page(ThemeManager $themeManager, EntityTypeManager $entityTypeManager) { }
```

Note that the constructor arguments are type coupled. Hence violating the D (dependency inversion) principle.

To fix that, you need to explicitly wire the interfaces with a particular service as shown below.

You have 3 ways to fix the above problem.

In service definition i.e in the MODULE_NAME.services.yml

***First solution:***

Use local service binding [for more info](https://symfony.com/blog/new-in-symfony-3-4-local-service-binding)
```
services:
  _defaults:
    bind:
      Drupal\Core\Theme\ThemeManagerInterface: '@theme.manager'
      Drupal\Core\Entity\EntityTypeManagerInterface: '@entity_type.manager'
```
The above will work for all classes (global in this module) that type hint the ***ThemeManagerInterface*** in this
module.

It will also work for all controller methods that type hint the above interfaces within this module.

***Second solution:***

Use binding arguments by name.
```
extended_container_service_locator.subscribed_service:
    class: Drupal\extended_container_service_locator\SubscribedServices
    arguments:
      $themeManager: '@theme.manager'
      $themeManager: '@entity_type.manager'
```
The above will only work for the class defined in this service definition. The arguments will not work on the
controller methods. The above arguments are only meant for the constructor method of the class in question.

***Third solution:***

Directly bind the interface to a service.

```
Drupal\Core\Theme\ThemeManagerInterface: '@theme.manager'
Drupal\Core\Entity\EntityTypeManagerInterface: '@entity_type.manager'
```
The above will work for all classes (globally) that type hint the ***ThemeManagerInterface*** in the whole application
i.e if they enabled autowiring on them.

It will also work for all controller methods in the entire application that type hint the above interface with or
without enabling autowiring on those controller classes.

### Local service binding
Read more about it [here](https://symfony.com/blog/new-in-symfony-3-4-local-service-binding)

For an example see the above example. Section:- ***First solution:*** "Use local service binding"

### Automatic Service Loading
Added the ability to automatically create services from all classes that are defined in your custom module.

***Example:***

Suppose you do have a module that defines a number of classes that you wish to be services.

Imagine a folder structure as shown below.

 my_module/src
 - controller
    - MyContoller1.php
    - MyController2.php
 - MyService1.php
 - MyService2.php
 - ExcludeService.php

 To automatically register all the above classes as services, in your my_module.services.yml add the lines below.
 ```
 services:
  _defaults:
    autowire: true

  Drupal\my_module\:
    resource: 'src/*'
    exclude: 'src/{Controller,ExcludeService.php}'
 ```

Note:

How the classes you do not want to automatically add as services are excluded i.e the whole **controller** folder is
excluded and also the class in the file **ExcludeService.php** will be excluded from automatically beeing registered
as a service.

Accessing the above generated services would be like:

```
\Drupal::service('Drupal\my_module\MyService');
```

Accessing the services in other locations of your application, in the services.yml file do
```
services:
  other_module.other_service:
    class: Drupal\other_module\OtherService
    arguments: ['@Drupal\my_module\MyService1']
```

Note:

- how you prefix the class name with the '@' symbol.
- The fully qualified class name becomes the service ID.

### Simpler injection of tagged services
Added the ability to automatically collect all tagged services and provide them to a manager without creating
a compiler pass.
[Read more](https://symfony.com/blog/new-in-symfony-3-4-simpler-injection-of-tagged-services) about it.


***Example:***

Suppose you do have 2 services that are tagged as 'module_name.tagged_service' and you do want to be collected
in one single place e.g in the manager 'module_name.manager'.

Simply add a manager service and use a type of argument called ***tagged*** pass in
the tag 'module_name.tagged_servic' whose classes or services you do want collected into the manager.
See example below.

In the MODULE_NAME.services.yml
```
services:
  module_name.tagged_1:
    class: Drupal\module_name\TaggedService1
    tags:
      - { name: module_name.tagged_service }

  module_name.tagged_2:
    class: Drupal\module_name\TaggedService2
    tags:
      - { name: module_name.tagged_service }

  module_name.manager:
    class: Drupal\module_name\TagServiceManager
    arguments:
      - !tagged module_name.tagged_service
```

The manager class whose contructor argument will be automatically filled with  a collection of all services
that are tagged with the 'module_name.tagged_service' tag

```
namespace Drupal\module_name;

class TagServiceManager implements \IteratorAggregate {
  protected $handlers;
  public function __construct(iterable $handlers)
  {
    $this->handlers = $handlers;
  }

  /**
   * @inheritDoc
   */
  public function getIterator() {
    return new \ArrayIterator($this->handlers);
  }

}
```

### Iterator type of argument.
Added the ability to add an iterator argument so that you can pass in a list of services in one single constructor
argument of the service in question.

***Example:***

In the MODULE_NAME.services.yml
```
services:

  module_name.iterator_service:
    class: Drupal\module_name\IteratorServiceCollection
    arguments:
      - !iterator ['@theme.manager', '@entity_type.manager']
```
 The class.

 ```
namespace Drupal\module_name;

class IteratorServiceCollection {
  // All the above mentioned services will be added to this property as a numeric indexed array.
  private $services;

  public function __construct(array $services) {
    $this->services = $services;
  }

}
 ```


## Patch core
For this module to work certain core files are patched automatically if you are using composer to download the module.
Look into the composer.json file for all of the links to the patches.

## FAQ
- **QN:** When l add a a global binding l get the error:
  ```
   Unused binding "Drupal\my_module\SomeCustomInterface" in service "Drupal\my_module\MyModuleServiceProvider".
  ```
  **Solution:** Remove the binding you defined. Symfony only allows to bind interfaces that are used as type hints
   somewhere in your custom module classes. That error is only thrown if the interface is not type hinted anywhere
   in your module classes.
- **QN:**



