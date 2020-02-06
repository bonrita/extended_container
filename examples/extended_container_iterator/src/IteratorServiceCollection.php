<?php


namespace Drupal\extended_container_iterator;

use Exception;
use Traversable;

/**
 * Class IteratorServiceCollection
 *
 * @package Drupal\extended_container_iterator
 */
class IteratorServiceCollection implements \IteratorAggregate {

  /**
   * @var array
   */
  private $services;

  public function __construct(array $services) {
    $this->services = $services;
  }

  /**
   * @inheritDoc
   */
  public function getIterator() {
   return new \ArrayIterator($this->services);
  }

}
