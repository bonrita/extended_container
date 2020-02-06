<?php


namespace Drupal\extended_container_bind\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_bind\BoxInterface;

/**
 * Class BindController
 *
 * @package Drupal\extended_container_bind\Controller
 */
class BindController extends ControllerBase {

  /**
   * @var \Drupal\extended_container_bind\BoxInterface
   */
  private $box;

  /**
   * BindController constructor.
   *
   * @param \Drupal\extended_container_bind\BoxInterface $box
   */
  public function __construct(BoxInterface $box) {
    $this->box = $box;
  }

  /**
   * The page.
   *
   * @return array
   *   The render array.
   */
  public function page() {
    $build['content'] = [
      '#markup' => 'Bind: ' . $this->box,
    ];

    return $build;
  }

}