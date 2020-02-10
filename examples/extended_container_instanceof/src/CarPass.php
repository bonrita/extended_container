<?php

namespace Drupal\extended_container_instanceof;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CarPass.
 *
 * @package Drupal\extended_container_instanceof
 */
class CarPass implements CompilerPassInterface {

  /**
   * {@inheritdoc}
   */
  public function process(ContainerBuilder $container) {

    if (!$container->has(CarCollection::class)) {
      return;
    }

    $definition = $container->findDefinition(CarCollection::class);

    // Find all service IDs with the 'car.model' tag.
    $taggedServices = $container->findTaggedServiceIds('car.model');

    foreach ($taggedServices as $id => $tags) {
      // Add the transport service to the ChainTransport service.
      $definition->addMethodCall('addCarModel', [new Reference($id)]);
    }

  }

}
