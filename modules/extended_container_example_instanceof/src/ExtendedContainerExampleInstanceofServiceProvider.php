<?php


namespace Drupal\extended_container_example_instanceof;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Class ExtendedContainerExampleAutoconfigureServiceProvider.
 *
 * @package Drupal\extended_container_example_instanceof
 */
class ExtendedContainerExampleInstanceofServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $container->addCompilerPass(new CarPass());
  }

}
