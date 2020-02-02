<?php


namespace Drupal\extended_container_example_autoconfigure\Car;


use Drupal\extended_container_example_autoconfigure\CarInterface;

class Audi implements CarInterface {

  public function __toString() {
    return 'Audi';
  }

}
