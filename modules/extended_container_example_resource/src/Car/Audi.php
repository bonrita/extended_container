<?php


namespace Drupal\extended_container_example_resource\Car;


use Drupal\extended_container_example_resource\CarInterface;

/**
 * Class Audi.
 *
 * @package Drupal\extended_container_example_resource\Car
 */
class Audi implements CarInterface {

  public function __toString() {
    return 'Audi';
  }

}
