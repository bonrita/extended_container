<?php

namespace Drupal\extended_container_php_constants\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\extended_container_php_constants\PhpConstService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The PHP constant controller class.
 */
class PhpConstantsController extends ControllerBase {

  /**
   * The service.
   *
   * @var \Drupal\extended_container_php_constants\PhpConstService
   */
  private $phpConstService;

  /**
   * The constructor.
   *
   * @param \Drupal\extended_container_php_constants\PhpConstService $phpConstService
   *   The PHP constant service.
   */
  public function __construct(PhpConstService $phpConstService) {
    $this->phpConstService = $phpConstService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extended_container_php_constants.constants')
    );
  }

  /**
   * The page.
   *
   * @return array
   *   The build array.
   */
  public function page() {

    $build['content'] = [
      '#theme' => 'item_list',
      '#items' => [
        'Name of the game: ' . $this->phpConstService->getGameName(),
        'Number of continents: ' . $this->phpConstService->getContinentCount(),
        'OS family: ' . $this->phpConstService->getPhpOs(),
      ],
      '#title' => $this->t('PHP constants services.'),
    ];

    return $build;
  }

}
