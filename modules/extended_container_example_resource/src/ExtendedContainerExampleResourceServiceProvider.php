<?php


namespace Drupal\extended_container_example_resource;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Class ExtendedContainerExampleAutoconfigureServiceProvider.
 *
 * @package Drupal\extended_container_example_resource
 */
class ExtendedContainerExampleResourceServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $container->registerForAutoconfiguration(CarInterface::class)->addTag('car.model');

    $container->addCompilerPass(new CarPass());
  }

}
