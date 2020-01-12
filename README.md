# Extended container
Enhance or upgrade the Drupal 8/9 Container with new functionality

## Service Subscribers
Added functionality for service subscribers.
For more information about service subscribers [read](https://symfony.com/doc/3.4/service_container/service_subscribers_locators.html) 

## Use
Tag the service with the tag: 'container.drupal_service_subscriber'

## Patch core
For this module to work you need to patch core with the patches below.
https://github.com/bonrita/drupal_core_patches/blob/master/drupal8/drupal-8-dependency-injection-service-closure-argument.patch


