# Example: Autowire

This example demonstrates how easily all services in this module can be automatically autowired
through the defaults key in MODULE_NAME.services.yml file.


## What has been fixed?
Autowiring is already part of Drupal core however it can only be done by
independently autowiring services.

In this module that limitation has been overcome as shown in this example.

The use of the fully qualified name of a class as a service ID has been added.
This fixes the limitation of Drupal core that only allows autowiring of concrete classes.