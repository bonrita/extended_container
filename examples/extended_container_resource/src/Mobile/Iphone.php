<?php


namespace Drupal\extended_container_resource\Mobile;


use Drupal\extended_container_resource\MobileInterface;

/**
 * Class Bmw.
 *
 * @package Drupal\extended_container_resource\Mobile
 */
class Iphone implements MobileInterface {

  public function __toString() {
    return 'Iphone';
  }

}
