# Example: Simpler injection of tagged services

In some Drupal applications is common to get all services tagged with a specific tag. 
The traditional solution is to create a compiler pass, 
find those services and iterate over them. 

However, this is overkill when you just need to get those tagged services. 
That's why in Symfony 3.4, there is a shortcut to achieve the same result
without having to create that compiler pass.

This example demonstrates how the above functionality can be achieved in Drupal.