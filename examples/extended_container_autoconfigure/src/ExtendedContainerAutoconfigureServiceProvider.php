<?php


namespace Drupal\extended_container_autoconfigure;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Class ExtendedContainerExampleAutoconfigureServiceProvider
 *
 * @package Drupal\extended_container_autoconfigure
 */
class ExtendedContainerAutoconfigureServiceProvider extends ServiceProviderBase {

  /**
   * @inheritDoc
   */
  public function register(ContainerBuilder $container) {
    $container->registerForAutoconfiguration(TelevisionInterface::class)->addTag('television.model');

    $container->addCompilerPass(new TelevisionPass());
  }


}