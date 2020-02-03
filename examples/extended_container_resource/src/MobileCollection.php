<?php


namespace Drupal\extended_container_resource;

/**
 * Class MobileCollection.
 *
 * @package Drupal\extended_container_resource
 */
class MobileCollection {

  /**
   * A list of mobile models.
   *
   * @var array
   */
  private $mobileModels = [];


  /**
   * Add a mobile model.
   *
   * @param \Drupal\extended_container_resource\MobileInterface $mobile
   *   The mobile model.
   */
  public function addMobileModel(MobileInterface $mobile) {
    $this->mobileModels[] = $mobile;
  }

  /**
   * Get mobile models.
   *
   * @return array
   */
  public function getMobileModels(): array {
    return $this->mobileModels;
  }

}
