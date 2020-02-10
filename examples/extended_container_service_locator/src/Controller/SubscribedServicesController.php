<?php

namespace Drupal\extended_container_service_locator\Controller;

use Drupal\Component\Utility\EmailValidator;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Theme\ThemeManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

/**
 * Class SubscribedServicesController.
 *
 * @package Drupal\extended_container_service_locator\Controller
 */
class SubscribedServicesController extends ControllerBase implements ServiceSubscriberInterface {

  /**
   * The locator.
   *
   * @var \Psr\Container\ContainerInterface
   */
  private $locator;

  /**
   * SubscribedServicesController constructor.
   *
   * @param \Psr\Container\ContainerInterface $locator
   *   The locator.
   */
  public function __construct(ContainerInterface $locator) {
    $this->locator = $locator;
  }

  /**
   * The page.
   *
   * @return array
   *   The build array.
   */
  public function page() {
    $build['content'] = [
      '#markup' => 'Current theme name: ' . $this->locator->get('theme.manager')
        ->getActiveTheme()
        ->getName(),
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedServices() {
    return [
      'email.validator' => EmailValidator::class,
      'theme.manager' => ThemeManager::class,
      'entity_type.manager' => EntityTypeManager::class,
    ];
  }

}
