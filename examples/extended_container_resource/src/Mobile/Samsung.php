<?php

namespace Drupal\extended_container_resource\Mobile;

use Drupal\extended_container_resource\MobileInterface;

/**
 * Mobile phone model.
 *
 * @package Drupal\extended_container_resource\Mobile
 */
class Samsung implements MobileInterface {

  /**
   * Model name.
   */
  public function __toString() {
    return 'Samsung';
  }

}
