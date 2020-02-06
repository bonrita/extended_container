<?php


namespace Drupal\extended_container_php_constants;


class PhpConstService {

  /**
   * @var string
   */
  private $gameName;

  private $continentCount;

  private $phpOs;

  public function __construct(string $game_name, $continent_count, $php_os) {
    $this->gameName = $game_name;
    $this->continentCount = $continent_count;
    $this->phpOs = $php_os;
  }

  /**
   * @return mixed
   */
  public function getPhpOs() {
    return $this->phpOs;
  }

  /**
   * @return mixed
   */
  public function getContinentCount() {
    return $this->continentCount;
  }

  /**
   * @return string
   */
  public function getGameName(): string {
    return $this->gameName;
  }

}