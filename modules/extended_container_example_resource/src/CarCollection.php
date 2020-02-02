<?php


namespace Drupal\extended_container_example_resource;

/**
 * Class CarCollection.
 *
 * @package Drupal\extended_container_example_resource
 */
class CarCollection {

  /**
   * A list of car models.
   *
   * @var array
   */
  private $carModels = [];


  /**
   * Add a car model.
   *
   * @param \Drupal\extended_container_example_resource\CarInterface $car
   *   The car model.
   */
  public function addCarModel(CarInterface $car) {
    $this->carModels[] = $car;
  }

  /**
   * Get car models.
   *
   * @return array
   */
  public function getCarModels(): array {
    return $this->carModels;
  }

}
