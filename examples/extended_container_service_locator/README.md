# Example: Service Subscribers & Locators

Sometimes, a service needs access to several other services without being 
sure that all of them will actually be used. In those cases, 
you may want the instantiation of the services to be lazy. 
However, that's not possible using the explicit dependency injection 
since services are not all meant to be lazy

This can typically be the case in your controllers, where you may inject 
several services in the constructor, but the action executed only uses some of them.

**Service Subscribers** are intended to solve this problem by giving access
to a set of predefined services while instantiating them only when actually
needed through a Service Locator, _a separate lazy-loaded container_.