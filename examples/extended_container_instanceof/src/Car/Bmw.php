<?php


namespace Drupal\extended_container_instanceof\Car;


use Drupal\extended_container_instanceof\CarInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_instanceof\Car
 */
class Bmw implements CarInterface {

  public function __toString() {
    return 'Bmw';
  }

}
