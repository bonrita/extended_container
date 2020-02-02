<?php


namespace Drupal\Tests\extended_container\Unit;

use Drupal\extended_container\DependencyInjection\ServiceLocator;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

/**
 * Class ServiceLocatorTest
 *
 * @package Drupal\Tests\extended_container\Unit
 *
 * @coversDefaultClass \Drupal\extended_container\DependencyInjection\ServiceLocator
 */
class ServiceLocatorTest extends UnitTestCase {

  /**
   * @covers ::withContext
   */
  public function testDrupalContainerUsed() {
    $errorHappened = FALSE;
    $container = new Container();
    $container->set('foo', new \stdClass());
    $subscriber = new SomeServiceSubscriber();

    $subscriber->container = new ServiceLocator(array('bar' => function () {}));

    try {
      $subscriber->container = $subscriber->container->withContext('caller', $container);

      $subscriber->getFoo();
    }
    catch (\Throwable $e) {
      $errorHappened = TRUE;
    }

    $this->assertTrue($errorHappened);

  }

}

class SomeServiceSubscriber implements ServiceSubscriberinterface {

  public $container;

  public function getFoo() {
    return $this->container->get('foo');
  }

  public static function getSubscribedServices() {
    return ['bar' => 'stdClass'];
  }

}
