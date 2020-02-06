<?php


namespace Drupal\extended_container_iterator\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_iterator\IteratorServiceCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class IteratorController extends ControllerBase {

  /**
   * @var \Drupal\extended_container_iterator\IteratorServiceCollection
   */
  private $collection;

  /**
   * IteratorController constructor.
   *
   * @param \Drupal\extended_container_iterator\IteratorServiceCollection $collection
   */
  public function __construct(IteratorServiceCollection $collection) {
    $this->collection = $collection;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extended_container_iterator.iterator_service')
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
    foreach ($this->collection as $item) {
      $reflection = new \ReflectionClass($item);
      $links[] = $reflection->getName();
    }

    $build['content'] = [
      '#theme' => 'item_list',
      '#items' => $links,
      '#title' => $this->t('Iterator services.'),
    ];

    return $build;
  }

}