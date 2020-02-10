<?php

namespace Drupal\Tests\extended_container\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\extended_container\DependencyInjection\Compiler\RegisterServiceSubscribersPass;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\Compiler\ResolveServiceSubscribersPass;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterServiceSubscribersPassTest.
 *
 * @package Drupal\Tests\extended_container\Unit
 * @coversDefaultClass \Drupal\extended_container\DependencyInjection\Compiler\RegisterServiceSubscribersPass
 */
class RegisterServiceSubscribersPassTest extends UnitTestCase {

  /**
   * @covers ::process
   * @expectedException \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
   * @expectedExceptionMessage Service "foo" must implement interface "Symfony\Component\DependencyInjection\ServiceSubscriberInterface".
   */
  public function testInvalidClass() {
    $container = new ContainerBuilder();

    $container->register('foo', CustomDefinition::class)
      ->addTag('container.drupal_service_subscriber');

    (new RegisterServiceSubscribersPass())->process($container);
    (new ResolveServiceSubscribersPass())->process($container);
  }

}
/**
 * Custom definition class.
 */
class CustomDefinition extends Definition {
}
