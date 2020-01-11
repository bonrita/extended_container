<?php

declare(strict_types=1);

namespace Drupal\extended_container;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\extended_container\DependencyInjection\Compiler\RegisterServiceSubscribersPass;


/**
 * Class ExtendedContainerServiceProvider
 *
 * @package Drupal\extended_container\
 */
class ExtendedContainerServiceProvider extends ServiceProviderBase {

  public function register(ContainerBuilder $container) {
    parent::register($container);

    $container->addCompilerPass(new RegisterServiceSubscribersPass());
  }

}
