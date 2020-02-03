<?php


namespace Drupal\extended_container_resource;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Class ExtendedContainerExampleAutoconfigureServiceProvider.
 *
 * @package Drupal\extended_container_resource
 */
class ExtendedContainerResourceServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $container->registerForAutoconfiguration(MobileInterface::class)->addTag('mobile.model');

    $container->addCompilerPass(new MobilePass());
  }

}
