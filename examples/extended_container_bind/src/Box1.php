<?php


namespace Drupal\extended_container_bind;


class Box1 implements BoxInterface {

  public function __toString() {
    return 'Box one';
  }

}