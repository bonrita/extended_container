<?php


namespace Drupal\extended_container\DependencyInjection\Compiler;


use Drupal\extended_container\DependencyInjection\ServiceLocator;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\TypedReference;

/**
 * Class RegisterServiceSubscribersPass
 *
 * @package Drupal\extended_container\DependencyInjection\Compiler
 */
class RegisterServiceSubscribersPass extends AbstractRecursivePass {

  protected function processValue($value, $isRoot = FALSE) {

    if (!$value instanceof Definition || $value->isAbstract() || $value->isSynthetic() || !$value->hasTag('container.drupal_service_subscriber')) {
      return parent::processValue($value, $isRoot);
    }

    $serviceMap = [];
    $autowire = $value->isAutowired();

    $class = $value->getClass();

    if (!$r = $this->container->getReflectionClass($class)) {
      throw new InvalidArgumentException(sprintf('Class "%s" used for service "%s" cannot be found.', $class, $this->currentId));
    }
    if (!$r->isSubclassOf(ServiceSubscriberInterface::class)) {
      throw new InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $this->currentId, ServiceSubscriberInterface::class));
    }

    $class = $r->name;

    $subscriberMap = [];
    $declaringClass = (new \ReflectionMethod($class, 'getSubscribedServices'))->class;

    foreach ($class::getSubscribedServices() as $key => $type) {
      if (!\is_string($type) || !preg_match('/^\??[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*+(?:\\\\[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*+)*+$/', $type)) {
        throw new InvalidArgumentException(sprintf('"%s::getSubscribedServices()" must return valid PHP types for service "%s" key "%s", "%s" returned.', $class, $this->currentId, $key, \is_string($type) ? $type : \gettype($type)));
      }
      if ($optionalBehavior = '?' === $type[0]) {
        $type = substr($type, 1);
        $optionalBehavior = ContainerInterface::IGNORE_ON_INVALID_REFERENCE;
      }
      if (\is_int($key)) {
        $key = $type;
      }
      if (!isset($serviceMap[$key])) {
        if (!$autowire) {
          throw new InvalidArgumentException(sprintf('Service "%s" misses a "container.service_subscriber" tag with "key"/"id" attributes corresponding to entry "%s" as returned by "%s::getSubscribedServices()".', $this->currentId, $key, $class));
        }
        $serviceMap[$key] = new Reference($type);
      }

      $subscriberMap[$key] = new TypedReference($this->container->normalizeId($serviceMap[$key]), $type, $declaringClass, $optionalBehavior ?: ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE);
      unset($serviceMap[$key]);
    }

    if ($serviceMap = array_keys($serviceMap)) {
      $message = sprintf(1 < \count($serviceMap) ? 'keys "%s" do' : 'key "%s" does', str_replace('%', '%%', implode('", "', $serviceMap)));
      throw new InvalidArgumentException(sprintf('Service %s not exist in the map returned by "%s::getSubscribedServices()" for service "%s".', $message, $class, $this->currentId));
    }

    $value->addTag('container.service_subscriber.locator', ['id' => (string) $this->register($this->container, $subscriberMap, $this->currentId)]);

    return parent::processValue($value);
  }

  /**
   * @param Reference[] $refMap
   * @param string|null $callerId
   *
   * @return Reference
   */
  protected function register(ContainerBuilder $container, array $refMap, $callerId = null) {
    foreach ($refMap as $id => $ref) {
      if (!$ref instanceof Reference) {
        throw new InvalidArgumentException(sprintf('Invalid service locator definition: only services can be referenced, "%s" found for key "%s". Inject parameter values using constructors instead.', \is_object($ref) ? \get_class($ref) : \gettype($ref), $id));
      }
      $refMap[$id] = new ServiceClosureArgument($ref);
    }
    ksort($refMap);

    $locator = (new Definition(ServiceLocator::class))
      ->addArgument($refMap)
      ->setPublic(FALSE)
      ->addTag('container.service_locator');

    if (null !== $callerId && $container->hasDefinition($callerId)) {
      $locator->setBindings($container->getDefinition($callerId)->getBindings());
    }

    if (!$container->hasDefinition($id = 'service_locator.'.ContainerBuilder::hash($locator))) {
      $container->setDefinition($id, $locator);
    }

    if (null !== $callerId) {
      $locatorId = $id;
      // Locators are shared when they hold the exact same list of factories;
      // to have them specialized per consumer service, we use a cloning factory
      // to derivate customized instances from the prototype one.
      $container->register($id .= '.'.$callerId, ServiceLocator::class)
        ->setPublic(false)
        ->setFactory([new Reference($locatorId), 'withContext'])
        ->addArgument($callerId)
        ->addArgument(new Reference('service_container'));
    }

    return new Reference($id);
  }

}