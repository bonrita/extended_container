<?php

namespace Drupal\extended_container_instanceof\Car;

use Drupal\extended_container_instanceof\CarInterface;

/**
 * Class Audi.
 *
 * @package Drupal\extended_container_instanceof\Car
 */
class Audi implements CarInterface {

  /**
   * Brand name.
   */
  public function __toString() {
    return 'Audi';
  }

}
