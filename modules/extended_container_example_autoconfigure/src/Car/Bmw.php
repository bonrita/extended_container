<?php


namespace Drupal\extended_container_example_autoconfigure\Car;


use Drupal\extended_container_example_autoconfigure\CarInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_example_autoconfigure\Car
 */
class Bmw implements CarInterface {

  public function __toString() {
    return 'Bmw';
  }

}
