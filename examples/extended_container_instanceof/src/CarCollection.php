<?php

namespace Drupal\extended_container_instanceof;

/**
 * Class CarCollection.
 *
 * @package Drupal\extended_container_instanceof
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
   * @param \Drupal\extended_container_instanceof\CarInterface $car
   *   The car model.
   */
  public function addCarModel(CarInterface $car) {
    $this->carModels[] = $car;
  }

  /**
   * Get car models.
   *
   * @return array
   *   List of car models.
   */
  public function getCarModels(): array {
    return $this->carModels;
  }

}
