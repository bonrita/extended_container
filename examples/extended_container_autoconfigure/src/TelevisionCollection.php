<?php


namespace Drupal\extended_container_autoconfigure;

/**
 * Class TelevisionCollection.
 *
 * @package Drupal\extended_container_autoconfigure
 */
class TelevisionCollection {

  /**
   * A list of television models.
   *
   * @var array
   */
  private $televisionModels = [];


  /**
   * Add a television model.
   *
   * @param \Drupal\extended_container_autoconfigure\TelevisionInterface $television
   *   The television model.
   */
  public function addTelevisionModel(TelevisionInterface $television) {
    $this->televisionModels[] = $television;
  }

  /**
   * Get television models.
   *
   * @return array
   */
  public function getTelevisionModels(): array {
    return $this->televisionModels;
  }

}
