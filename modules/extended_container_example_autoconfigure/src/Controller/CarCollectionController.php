<?php


namespace Drupal\extended_container_example_autoconfigure\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_example_autoconfigure\CarCollection;

/**
 * Class CarCollectionController.
 *
 * @package Drupal\extended_container_example_autoconfigure\Controller
 */
class CarCollectionController extends ControllerBase {

  /**
   * @var \Drupal\extended_container_example_autoconfigure\CarCollection
   */
  private $carCollection;

  /**
   * CarCollectionController constructor.
   *
   * @param \Drupal\extended_container_example_autoconfigure\CarCollection $carCollection
   *   Car collection.
   */
  public function __construct(CarCollection $carCollection) {
    $this->carCollection = $carCollection;
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