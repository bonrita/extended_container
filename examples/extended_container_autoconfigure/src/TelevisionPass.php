<?php


namespace Drupal\extended_container_autoconfigure;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TelevisionPass.
 *
 * @package Drupal\extended_container_autoconfigure
 */
class TelevisionPass implements CompilerPassInterface {

  /**
   * @inheritDoc
   */
  public function process(ContainerBuilder $container) {

    if (!$container->has(TelevisionCollection::class)) {
      return;
    }

    $definition = $container->findDefinition(TelevisionCollection::class);

    // Find all service IDs with the 'television.model' tag.
    $taggedServices = $container->findTaggedServiceIds('television.model');

    foreach ($taggedServices as $id => $tags) {
      $definition->addMethodCall('addTelevisionModel', array(new Reference($id)));
    }

  }

}
