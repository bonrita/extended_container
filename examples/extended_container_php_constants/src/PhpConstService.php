<?php

namespace Drupal\extended_container_php_constants;

/**
 * The PHP constant service example.
 */
class PhpConstService {

  /**
   * The game name.
   *
   * @var string
   */
  private $gameName;

  /**
   * The continent count.
   *
   * @var string
   */
  private $continentCount;

  /**
   * The OS.
   *
   * @var string
   */
  private $phpOs;

  /**
   * The constructor.
   *
   * @param string $game_name
   *   The game name.
   * @param string $continent_count
   *   The continent count.
   * @param string $php_os
   *   The OS.
   */
  public function __construct(string $game_name, $continent_count, $php_os) {
    $this->gameName = $game_name;
    $this->continentCount = $continent_count;
    $this->phpOs = $php_os;
  }

  /**
   * The OS.
   *
   * @return string
   *   The OS.
   */
  public function getPhpOs() {
    return $this->phpOs;
  }

  /**
   * The continent count.
   *
   * @return string
   *   The continent count.
   */
  public function getContinentCount() {
    return $this->continentCount;
  }

  /**
   * The game name.\.
   *
   * @return string
   *   The game name.
   */
  public function getGameName(): string {
    return $this->gameName;
  }

}
