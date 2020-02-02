<?php


namespace Drupal\extended_container_example_resource\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_example_resource\CarCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CarCollectionController.
 *
 * @package Drupal\extended_container_example_resource\Controller
 */
class CarCollectionController extends ControllerBase {

  /**
   * @var \Drupal\extended_container_example_resource\CarCollection
   */
  private $carCollection;

  /**
   * CarCollectionController constructor.
   *
   * @param \Drupal\extended_container_example_resource\CarCollection $carCollection
   *   Car collection.
   */
  public function __construct(CarCollection $carCollection) {
    $this->carCollection = $carCollection;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('Drupal\extended_container_example_resource\CarCollection')
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