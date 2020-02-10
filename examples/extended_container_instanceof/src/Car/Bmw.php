<?php

namespace Drupal\extended_container_instanceof\Car;

use Drupal\extended_container_instanceof\CarInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_instanceof\Car
 */
class Bmw implements CarInterface {

  /**
   * Brand name.
   */
  public function __toString() {
    return 'Bmw';
  }

}
