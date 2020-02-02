<?php


namespace Drupal\extended_container_example_instanceof\Car;


use Drupal\extended_container_example_instanceof\CarInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_example_instanceof\Car
 */
class Bmw implements CarInterface {

  public function __toString() {
    return 'Bmw';
  }

}
