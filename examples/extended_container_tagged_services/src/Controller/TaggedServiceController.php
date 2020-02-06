<?php


namespace Drupal\extended_container_tagged_services\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_tagged_services\TagServiceCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TaggedServiceController.
 *
 * @package Drupal\extended_container_tagged_services\Controller
 */
class TaggedServiceController extends ControllerBase {

  /**
   * @var \Drupal\extended_container_tagged_services\TagServiceCollection
   */
  private $tagServiceCollection;

  /**
   * TaggedServiceController constructor.
   *
   * @param \Drupal\extended_container_tagged_services\TagServiceCollection $tagServiceCollection
   */
  public function __construct(TagServiceCollection $tagServiceCollection) {
    $this->tagServiceCollection = $tagServiceCollection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extended_container_tagged_services.collection')
    );
  }

  /**
   * The page.
   *
   * @return array
   *   The build array.
   */
  public function page() {
    $links = [];
    foreach ($this->tagServiceCollection as $item) {
      $links[] = $item;
    }

    $build['content'] = [
      '#theme' => 'item_list',
      '#items' => $links,
      '#title' => $this->t('Tagged services.'),
    ];

    return $build;
  }

}
