# Example: Autoconfigure

This option adds some default configurations depending on the class implemented by the service.

## What is demostrated in this example.

* Auto configuring services
* Using the fully qualified name of a class as a service ID
* Autowiring all services defined in this module.

### About the example.
Let's suppose that you want to tag all classes that implement the 'TelevisionInterface' with the 'television.model'
tag automatically:

Add the autoconfigure option in your service definition and the rest will be taken care of by the code
in the service provider.
So where ever you implement the 'TelevisionInterface' anywhere in your application that class will be automatically
tagged with the 'television.model' tag.

