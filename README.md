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
  
***Example***

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


public function __construct(ContainerInterface $locator)
```
It is required to type hint the constructor locator argument with the Psr **ContainerInterface** interface as shown.

### Autowiring
Improved greatly on the autowiring feature. Below is what was improved.
* Enable autowiring for all services of a module by default i.e if enabled for that particular module. [Automatic Service Loading in services.yaml](https://symfony.com/doc/current/service_container.html#creating-configuring-services-in-the-container)
* Enable autowiring of interfaces. [More info](https://symfony.com/doc/3.4/service_container/autowiring.html)
* Add the ability to autowire dependencies on controller methods.

### Local service binding
Read more about it [here](https://symfony.com/blog/new-in-symfony-3-4-local-service-binding)

## Patch core
For this module to work certain core files are patched automatically if you are using composer to download the module. 
Look into the composer.json file for all of the links to the patches.


