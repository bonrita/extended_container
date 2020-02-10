<?php

namespace Drupal\extended_container_autoconfigure\Television;

use Drupal\extended_container_autoconfigure\TelevisionInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_autoconfigure\Television
 */
class Philips implements TelevisionInterface {

  /**
   * The brand name.
   *
   * @return string
   *   The brand name.
   */
  public function __toString() {
    return 'Philips';
  }

}
