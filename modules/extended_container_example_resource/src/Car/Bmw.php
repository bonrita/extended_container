<?php


namespace Drupal\extended_container_example_resource\Car;


use Drupal\extended_container_example_resource\CarInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_example_resource\Car
 */
class Bmw implements CarInterface {

  public function __toString() {
    return 'Bmw';
  }

}
