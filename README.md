# Extended container
Enhance or upgrade the Drupal 8 Container with new functionality

## Added functionality

### Service Subscribers
Added functionality for service subscribers.
For more information about service subscribers [read](https://symfony.com/doc/3.4/service_container/service_subscribers_locators.html) 

#### Use
Tag the service with the tag: 'container.drupal_service_subscriber'

### Autowiring
Improved greatly on the autowiring feature e.g
* Enable autowiring for all services of a module by default i.e if enabled for that particular module.
* Enable autowiring of interfaces


## Patch core
For this module to work certain core files are patched automatically if you are using composer to download the module. 
Look into the composer.json file for all of the links to the patches.


