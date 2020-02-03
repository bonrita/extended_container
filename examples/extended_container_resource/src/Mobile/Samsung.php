<?php


namespace Drupal\extended_container_resource\Mobile;


use Drupal\extended_container_resource\MobileInterface;

/**
 * Class Audi.
 *
 * @package Drupal\extended_container_resource\Mobile
 */
class Samsung implements MobileInterface {

  public function __toString() {
    return 'Samsung';
  }

}
