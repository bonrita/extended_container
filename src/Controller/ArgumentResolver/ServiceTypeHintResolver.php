<?php


namespace Drupal\extended_container\Controller\ArgumentResolver;


use Drupal\Core\DependencyInjection\ClassResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * A class that resolves method arguments to services in the container.
 *
 * @package Drupal\extended_container\Controller\ArgumentResolver
 */
final class ServiceTypeHintResolver implements ArgumentValueResolverInterface {

  /**
   * @var \Drupal\Core\DependencyInjection\ClassResolverInterface
   */
  private $classResolver;

  /**
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  private $container;

  /**
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  private $cache;

  /**
   * ServiceTypeHintResolver constructor.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param \Drupal\Core\DependencyInjection\ClassResolverInterface $classResolver
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   */
  public function __construct(
    ContainerInterface $container,
    ClassResolverInterface $classResolver,
    CacheBackendInterface $cache
  ) {
    $this->classResolver = $classResolver;
    $this->container = $container;
    $this->cache = $cache;
  }

  /**
   * {@inheritdoc}
   */
  public function supports(Request $request, ArgumentMetadata $argument) {
    $class = $this->getFullyQualifiedClassName($argument);
    $service_id = empty($class) ? $argument->getType() : $class;
    if ($this->container->has($service_id) || class_exists($service_id)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(Request $request, ArgumentMetadata $argument) {
    yield $this->getService($argument);
  }

  /**
   * Get service and cache it.
   *
   * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
   *
   * @return object
   * @throws \ReflectionException
   */
  private function getService(ArgumentMetadata $argument) {

    $service = NULL;
    $id = '';
    $cid = 'extended_container_controller_arguments_' . $argument->getType();
    $data = $this->cache->get($cid);

    if (is_object($data) && !empty($data->data)) {
      $id = $data->data;
    }
    else {

      $class = $this->getFullyQualifiedClassName($argument);
      $service_id = empty($class) ? $argument->getType() : $class;

      $reflection_obj = new \ReflectionObject($this->container);
      $property = $reflection_obj->getProperty('serviceDefinitions');
      $property->setAccessible(TRUE);
      $service_definitions = $property->getValue($this->container);

      foreach ($service_definitions as $key => $serviceDefinition) {
        $definition = unserialize($serviceDefinition);
        if (isset($definition['class']) && $service_id === $definition['class']) {
          $id = $key;
          break;
        }
      }

      $this->cache->set($cid, $id);
    }

    if (!empty($id)) {
      $service = $this->classResolver->getInstanceFromDefinition($id);
    }
    elseif (empty($id) && $this->container->has($class)) {
      $service = $this->container->get($class);
    }

    return $service;
  }

  /**
   * Get the fully qualified name of the class.
   *
   * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
   *   The argument.
   *
   * @return null|string
   *   The class name.
   */
  private function getFullyQualifiedClassName(ArgumentMetadata $argument) {
    if (strpos($argument->getType(), '\\') === FALSE) {
      return NULL;
    }
    $class = '';
    $class_parts = explode('\\', $argument->getType());

    $i = 0;
    foreach ($class_parts as $classPart) {
      if ($i > 1) {
        $class .= '\\' . ucfirst($classPart);
      }
      elseif ($i === 0) {
        $class = $classPart;
      }
      else {
        $class .= '\\' . $classPart;
      }
      $i++;
    }

    return $class;
  }

}
