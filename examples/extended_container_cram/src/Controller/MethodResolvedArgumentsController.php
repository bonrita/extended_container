<?php

namespace Drupal\extended_container_cram\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Theme\ThemeManagerInterface;
use Drupal\language\ConfigurableLanguageManagerInterface;

/**
 * Example of a controller method whose dependencies are automatically resolved.
 *
 * @package Drupal\extended_container_cram\Controller
 */
class MethodResolvedArgumentsController extends ControllerBase {

  /**
   * The page.
   *
   * @param string $step
   *   The step.
   * @param \Drupal\Core\Theme\ThemeManagerInterface $themeManager
   *   The theme manager.
   * @param \Drupal\language\ConfigurableLanguageManagerInterface $languageManager
   *   The language manager.
   *
   * @return array
   *   The render list.
   */
  public function page(
    $step,
    ThemeManagerInterface $themeManager,
    ConfigurableLanguageManagerInterface $languageManager
  ) {
    $build['content'] = [
      '#markup' => 'Current theme name: ' . $themeManager->getActiveTheme()
        ->getName(
      ) . ', current language site: ' . $languageManager->getCurrentLanguage(
      )->getName() . ', Step: ' . $step,
    ];

    return $build;
  }

}
