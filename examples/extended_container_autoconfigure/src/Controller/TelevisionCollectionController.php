<?php

namespace Drupal\extended_container_autoconfigure\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_autoconfigure\TelevisionCollection;

/**
 * Class TelevisionCollectionController.
 *
 * @package Drupal\extended_container_autoconfigure\Controller
 */
class TelevisionCollectionController extends ControllerBase {

  /**
   * The tv collection.
   *
   * @var \Drupal\extended_container_autoconfigure\TelevisionCollection
   */
  private $televisionCollection;

  /**
   * TelevisionCollectionController constructor.
   *
   * @param \Drupal\extended_container_autoconfigure\TelevisionCollection $televisionCollection
   *   Television collection.
   */
  public function __construct(TelevisionCollection $televisionCollection) {
    $this->televisionCollection = $televisionCollection;
  }

  /**
   * The page.
   *
   * @return array
   *   The render array.
   */
  public function page() {
    $build['content'] = [
      '#markup' => 'Television collection: ' . implode(', ', $this->televisionCollection->getTelevisionModels()),
    ];

    return $build;
  }

}
