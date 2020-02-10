<?php

namespace Drupal\extended_container_resource\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_resource\MobileCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MobileCollectionController.
 *
 * @package Drupal\extended_container_resource\Controller
 */
class MobileCollectionController extends ControllerBase {

  /**
   * The collection.
   *
   * @var \Drupal\extended_container_resource\MobileCollection
   */
  private $mobileCollection;

  /**
   * MobileCollectionController constructor.
   *
   * @param \Drupal\extended_container_resource\MobileCollection $mobileCollection
   *   Mobile collection.
   */
  public function __construct(MobileCollection $mobileCollection) {
    $this->mobileCollection = $mobileCollection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('Drupal\extended_container_resource\MobileCollection')
    );
  }

  /**
   * The page.
   *
   * @return array
   *   The render array.
   */
  public function page() {
    $build['content'] = [
      '#markup' => 'Mobile collection: ' . implode(', ', $this->mobileCollection->getMobileModels()),
    ];

    return $build;
  }

}
