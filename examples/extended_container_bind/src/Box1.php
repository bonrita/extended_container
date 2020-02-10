<?php

namespace Drupal\extended_container_bind;

/**
 * The box.
 */
class Box1 implements BoxInterface {

  /**
   * Box name.
   */
  public function __toString() {
    return 'Box one';
  }

}
