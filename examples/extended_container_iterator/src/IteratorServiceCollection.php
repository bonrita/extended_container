<?php

namespace Drupal\extended_container_iterator;

/**
 * Class IteratorServiceCollection.
 *
 * @package Drupal\extended_container_iterator
 */
class IteratorServiceCollection implements \IteratorAggregate {

  /**
   * A list of services.
   *
   * @var array
   */
  private $services;

  /**
   * The constructor.
   *
   * @param array $services
   *   The services.
   */
  public function __construct(array $services) {
    $this->services = $services;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->services);
  }

}
