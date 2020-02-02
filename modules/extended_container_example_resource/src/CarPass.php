<?php


namespace Drupal\extended_container_example_resource;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CarPass.
 *
 * @package Drupal\extended_container_example_resource
 */
class CarPass implements CompilerPassInterface {

  /**
   * @inheritDoc
   */
  public function process(ContainerBuilder $container) {

    if (!$container->has(CarCollection::class)) {
      return;
    }

    $definition = $container->findDefinition(CarCollection::class);

    // find all service IDs with the 'car.model' tag.
    $taggedServices = $container->findTaggedServiceIds('car.model');

    foreach ($taggedServices as $id => $tags) {
      // add the transport service to the ChainTransport service
      $definition->addMethodCall('addCarModel', array(new Reference($id)));
    }

  }

}
