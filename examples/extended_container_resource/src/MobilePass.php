<?php


namespace Drupal\extended_container_resource;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MobilePass.
 *
 * @package Drupal\extended_container_resource
 */
class MobilePass implements CompilerPassInterface {

  /**
   * @inheritDoc
   */
  public function process(ContainerBuilder $container) {

    if (!$container->has(MobileCollection::class)) {
      return;
    }

    $definition = $container->findDefinition(MobileCollection::class);

    // find all service IDs with the 'mobile.model' tag.
    $taggedServices = $container->findTaggedServiceIds('mobile.model');

    foreach ($taggedServices as $id => $tags) {
      $definition->addMethodCall('addMobileModel', array(new Reference($id)));
    }

  }

}
