<?php

namespace Drupal\extended_container_instanceof\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_instanceof\CarCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CarCollectionController.
 *
 * @package Drupal\extended_container_instanceof\Controller
 */
class CarCollectionController extends ControllerBase {

  /**
   * The list of a car collection.
   *
   * @var \Drupal\extended_container_instanceof\CarCollection
   */
  private $carCollection;

  /**
   * CarCollectionController constructor.
   *
   * @param \Drupal\extended_container_instanceof\CarCollection $carCollection
   *   Car collection.
   */
  public function __construct(CarCollection $carCollection) {
    $this->carCollection = $carCollection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('Drupal\extended_container_instanceof\CarCollection')
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
      '#markup' => 'Car collection: ' . implode(', ', $this->carCollection->getCarModels()),
    ];

    return $build;
  }

}
