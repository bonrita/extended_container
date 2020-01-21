# Extended container
Enhance or upgrade the Drupal 8 Container with new functionality

## Added functionality

### Service Subscribers
Added functionality for service subscribers.
For more information about service subscribers [read](https://symfony.com/doc/3.4/service_container/service_subscribers_locators.html) 

- Usage
  - It lazy loads services.

- How
  - Tag the service with the tag: **'container.drupal_service_subscriber'** instead of that one that is mentioned in the symfony docs.
  
***Example:***

Suppose you have a controller class: SubscribedServicesController that needs many dependencies, implement the *Symfony\Component\DependencyInjection\ServiceSubscriberInterface* to add the services you wish to add.
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

Add the small container that will lazy load the services to the class constructor as below.
Note: Do not add the argument to your service definition as it will be added for you automatically when the container is building the service.
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

### Autowiring
Improved greatly on the autowiring feature. Below is what was improved.
* Enable autowiring for all services of a module by default i.e if enabled for that particular module. [Automatic Service Loading in services.yaml](https://symfony.com/doc/current/service_container.html#creating-configuring-services-in-the-container)
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
From this moment on you do not have to define arguments in your service definition as they will be automatically added for you.

The example below should work without explicitly configuring the service arguments i.e if the default (_default) autowiring (as shown above) was enabled .

Service definition:
```
  tricks.subscribed_service:
    class: Drupal\tricks\SubscribedServices
```
**Or** you may decide to enable or disable autowiring per service i.e
```
  tricks.subscribed_services:
    class: Drupal\tricks\SubscribedServicesController
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
The above will work for all classes (global in this module) that type hint the ***ThemeManagerInterface*** in this module.

It will also work for all controller methods that type hint the above interfaces within this module.

***Second solution:***

Use binding arguments by name.
```
tricks.subscribed_service:
    class: Drupal\tricks\SubscribedServices
    arguments:
      $themeManager: '@theme.manager'
      $themeManager: '@entity_type.manager'
```
The above will only work for the class defined in this service definition. The arguments will not work on the controller methods. The above arguments are only meant for the constructor method of the class in question.

***Third solution:***

Directly bind the interface to a service.

```
Drupal\Core\Theme\ThemeManagerInterface: '@theme.manager'
Drupal\Core\Entity\EntityTypeManagerInterface: '@entity_type.manager'
```
The above will work for all classes (globally) that type hint the ***ThemeManagerInterface*** in the whole application i.e if they enabled autowiring on them.

It will also work for all controller methods in the entire application that type hint the above interface with or without enabling autowiring on those controller classes.

### Local service binding
Read more about it [here](https://symfony.com/blog/new-in-symfony-3-4-local-service-binding)

For an example see the above examples.

## Patch core
For this module to work certain core files are patched automatically if you are using composer to download the module. 
Look into the composer.json file for all of the links to the patches.


