<?php

namespace Drupal\extended_container_resource\Mobile;

use Drupal\extended_container_resource\MobileInterface;

/**
 * Mobile phone model.
 *
 * @package Drupal\extended_container_resource\Mobile
 */
class Iphone implements MobileInterface {

  /**
   * Model name.
   */
  public function __toString() {
    return 'Iphone';
  }

}
