<?php

namespace Drupal\extended_container_autoconfigure\Television;

use Drupal\extended_container_autoconfigure\TelevisionInterface;

/**
 * Class Sony.
 *
 * @package Drupal\extended_container_autoconfigure\Television
 */
class Sony implements TelevisionInterface {

  /**
   * The brand name.
   *
   * @return string
   *   The brand name.
   */
  public function __toString() {
    return 'Sony';
  }

}
