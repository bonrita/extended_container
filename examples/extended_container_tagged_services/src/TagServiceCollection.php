<?php

namespace Drupal\extended_container_tagged_services;

/**
 * Class TagServiceCollection.
 *
 * @package Drupal\extended_container_tagged_services
 */
class TagServiceCollection implements \IteratorAggregate {

  /**
   * The collection.
   *
   * @var iterable
   */
  protected $handlers;

  /**
   * TagServiceCollection constructor.
   *
   * @param iterable $handlers
   *   The collection.
   */
  public function __construct(iterable $handlers) {
    $this->handlers = $handlers;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->handlers);
  }

}
