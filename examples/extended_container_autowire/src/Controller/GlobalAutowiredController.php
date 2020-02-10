<?php

namespace Drupal\extended_container_autowire\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Theme\ThemeManagerInterface;

/**
 * The Global autowired controller class.
 *
 * @package Drupal\extended_container_autowire\Controller
 */
class GlobalAutowiredController extends ControllerBase {

  /**
   * The theme manager.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  private $themeManager;

  /**
   * GlobalAutowiredController constructor.
   *
   * @param \Drupal\Core\Theme\ThemeManagerInterface $themeManager
   *   The theme manager.
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   *   The language manager.
   */
  public function __construct(
    ThemeManagerInterface $themeManager,
    LanguageManagerInterface $languageManager
  ) {
    $this->themeManager = $themeManager;
    $this->languageManager = $languageManager;
  }

  /**
   * The page.
   *
   * @return array
   *   The render array.
   */
  public function page() {
    $build['content'] = [
      '#markup' => 'Current theme name: ' . $this->themeManager->getActiveTheme(
      )->getName(
      ) . ', current language site: ' . $this->languageManager->getCurrentLanguage(
      )->getName(),
    ];

    return $build;
  }

}
