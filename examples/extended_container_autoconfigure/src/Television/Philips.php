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
   * @return string
   */
  public function __toString() {
    return 'Philips';
  }

}
