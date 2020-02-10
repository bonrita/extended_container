<?php
// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Drupal\extended_container\DependencyInjection;

use Drupal\Core\DependencyInjection\Container;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

/**
 * This class adds the service locator functionality.
 *
 * This class is 98% a duplicate of
 * \Symfony\Component\DependencyInjection\ServiceLocator.
 *
 * @package Drupal\extended_container\DependencyInjection
 */
class ServiceLocator implements PsrContainerInterface {
  private $factories;
  private $loading = [];
  private $externalId;
  private $container;

  /**
   * @param callable[] $factories
   */
  public function __construct(array $factories) {
    $this->factories = $factories;
  }

  /**
   * {@inheritdoc}
   */
  public function has($id) {
    return isset($this->factories[$id]);
  }

  /**
   * {@inheritdoc}
   */
  public function get($id) {
    if (!isset($this->factories[$id])) {
      throw new ServiceNotFoundException($id, end($this->loading) ?: NULL, NULL, [], $this->createServiceNotFoundMessage($id));
    }

    if (isset($this->loading[$id])) {
      $ids = array_values($this->loading);
      $ids = \array_slice($this->loading, array_search($id, $ids));
      $ids[] = $id;

      throw new ServiceCircularReferenceException($id, $ids);
    }

    $this->loading[$id] = $id;
    try {
      return is_callable($this->factories[$id]) ? $this->factories[$id]() : $this->factories[$id];
    } finally {
      unset($this->loading[$id]);
    }
  }

  /**
   *
   */
  public function __invoke($id) {
    return isset($this->factories[$id]) ? $this->get($id) : NULL;
  }

  /**
   * @internal
   */
  public function withContext($externalId, Container $container) {
    $locator = clone $this;
    $locator->externalId = $externalId;
    $locator->container = $container;

    return $locator;
  }

  /**
   *
   */
  private function createServiceNotFoundMessage($id) {
    if ($this->loading) {
      return sprintf('The service "%s" has a dependency on a non-existent service "%s". This locator %s', end($this->loading), $id, $this->formatAlternatives());
    }

    $class = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 3);
    $class = isset($class[2]['object']) ? \get_class($class[2]['object']) : NULL;
    $externalId = $this->externalId ?: $class;

    $msg = [];
    $msg[] = sprintf('Service "%s" not found:', $id);

    if (!$this->container) {
      $class = NULL;
    }
    elseif ($this->container->has($id) || (\method_exists($this->container, 'getRemovedIds') && isset($this->container->getRemovedIds()[$id]))) {
      $msg[] = 'even though it exists in the app\'s container,';
    }
    else {
      try {
        $this->container->get($id);
        $class = NULL;
      }
      catch (ServiceNotFoundException $e) {
        if ($e->getAlternatives()) {
          $msg[] = sprintf('did you mean %s? Anyway,', $this->formatAlternatives($e->getAlternatives(), 'or'));
        }
        else {
          $class = NULL;
        }
      }
    }
    if ($externalId) {
      $msg[] = sprintf('the container inside "%s" is a smaller service locator that %s', $externalId, $this->formatAlternatives());
    }
    else {
      $msg[] = sprintf('the current service locator %s', $this->formatAlternatives());
    }

    if (!$class) {
      // no-op.
    }
    elseif (is_subclass_of($class, ServiceSubscriberInterface::class)) {
      $msg[] = sprintf('Unless you need extra laziness, try using dependency injection instead. Otherwise, you need to declare it using "%s::getSubscribedServices()".', preg_replace('/([^\\\\]++\\\\)++/', '', $class));
    }
    else {
      $msg[] = 'Try using dependency injection instead.';
    }

    return implode(' ', $msg);
  }

  /**
   *
   */
  private function formatAlternatives(array $alternatives = NULL, $separator = 'and') {
    $format = '"%s"%s';
    if (NULL === $alternatives) {
      if (!$alternatives = array_keys($this->factories)) {
        return 'is empty...';
      }
      $format = sprintf('only knows about the %s service%s.', $format, 1 < \count($alternatives) ? 's' : '');
    }
    $last = array_pop($alternatives);

    return sprintf($format, $alternatives ? implode('", "', $alternatives) : $last, $alternatives ? sprintf(' %s "%s"', $separator, $last) : '');
  }

}
