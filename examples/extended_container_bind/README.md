# Example: Binding in service definitions

When you define a bind in the defaults, that bind must be  
used by at-least one service in the application.

This is the reason am making the controller a service so that the container
can notice that this bind is used by atleast one service.

Otherwise a runtime exception will be thrown when trying
to compile the services.