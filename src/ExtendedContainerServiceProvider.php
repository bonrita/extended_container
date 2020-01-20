<?php

declare(strict_types=1);

namespace Drupal\extended_container;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\extended_container\DependencyInjection\Compiler\RegisterServiceSubscribersPass;
use Symfony\Component\HttpKernel\DependencyInjection\ControllerArgumentValueResolverPass;


/**
 * Class ExtendedContainerServiceProvider
 *
 * @package Drupal\extended_container\
 */
class ExtendedContainerServiceProvider extends ServiceProviderBase {

  public function register(ContainerBuilder $container) {
    parent::register($container);

    $container->addCompilerPass(new RegisterServiceSubscribersPass());

    // Add the ability to add argument resolvers using the original Symfony
    // argument resolver tag: 'controller.argument_value_resolver'
    $container->addCompilerPass(new ControllerArgumentValueResolverPass('http_kernel.controller.argument_resolver'));

  }

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $this->tagCoreArgumentResorvers($container);
  }

  /**
   * Tag core argument resolvers.
   *
   * @param \Drupal\Core\DependencyInjection\ContainerBuilder $container
   */
  private function tagCoreArgumentResorvers(ContainerBuilder $container) {
    $argument_resolver_services = [
      'argument_resolver.request_attribute' => 90,
      'argument_resolver.request' => 80,
      'argument_resolver.psr7_request' => 70,
      'argument_resolver.route_match' => 60,
      'argument_resolver.default' => 50,
    ];

    foreach ($argument_resolver_services as $service_id => $priority) {
      if ($container->hasDefinition($service_id)) {
        $container->getDefinition($service_id)->addTag('controller.argument_value_resolver', ['priority' => $priority]);
      }
    }
  }

}
