<?php

namespace EclipseGc\Plugin\Traits;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Factory\FactoryInterface;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\PluginInterface;

/**
 * A trait which implements all the methods of the PluginDiscoveryInterface.
 *
 * @see \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
 */
trait PluginDictionaryTrait {

  /**
   * The plugin type.
   *
   * @var string
   */
  protected $pluginType;

  /**
   * The discovery object to use for this dictionary.
   *
   * @var \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface
   */
  protected $discovery;

  /**
   * A list of mutators to apply to the PluginDefinitionSet.
   *
   * @var \EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface[]
   */
  protected $mutators = [];

  /**
   * A PluginDefinitionSet with all the PluginDefinitionInterface objects.
   *
   * @var \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   */
  protected $set = NULL;

  /**
   * A class name which implements \EclipseGc\Plugin\Factory\FactoryInterface.
   *
   * @var string
   */
  protected $factoryClass;

  /**
   * The default plugin factory.
   *
   * This is used when a plugin definition does not specify its own factory.
   *
   * @var \EclipseGc\Plugin\Factory\FactoryInterface
   */
  protected $factory;

  /**
   * The factory resolver.
   *
   * This class resolves factory_class strings into FactoryInterface objects.
   *
   * @var \EclipseGc\Plugin\Factory\FactoryResolverInterface
   */
  protected $factoryResolver;

  /**
   * The cache backend object.
   *
   * @var \EclipseGc\Plugin\Cache\CacheInterface
   */
  protected $cache;

  /**
   * {@inheritdoc}
   */
  public function getPluginType() : string {
    return $this->pluginType;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() : PluginDefinitionSet {
    if (is_null($this->set) && $this->cache) {
      $values = $this->cache->get();
      $this->set = $values->count() ? $values : NULL;
    }
    if (is_null($this->set) && !is_null($this->discovery)) {
      $set = $this->discovery->findPluginImplementations();
      foreach ($this->mutators as $mutator) {
        $set->applyMutator($mutator);
      }
      $this->set = $set;
      if ($this->cache) {
        $this->cache->set($set);
      }
    }
    return $this->set;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinition(string $pluginId) : PluginDefinitionInterface {
    $set = $this->getDefinitions();
    return $set->getDefinition($pluginId);
  }

  /**
   * {@inheritdoc}
   */
  public function hasDefinition(string $pluginId) : bool {
    $set = $this->getDefinitions();
    return $set->hasDefinition($pluginId);
  }

  /**
   * {@inheritdoc}
   */
  public function getFilteredDefinitions(PluginDefinitionFilterInterface ...$filters) : PluginDefinitionSet {
    $set = $this->getDefinitions();
    return $set->getFilteredSet(...$filters);
  }

  /**
   * {@inheritdoc}
   */
  public function createInstance(string $pluginId, ...$constructors) : PluginInterface {
    $definition = $this->getDefinition($pluginId);
    $factory_class = $definition->getFactory();
    if (!$factory_class) {
      $factory_class = $this->factoryClass;
    }
    $factory = $this->resolveFactory($factory_class);
    return $factory->createInstance($definition, ...$constructors);
  }

  /**
   * Resolves the factory class string into a FactoryInterface object.
   *
   * @param string $factory_class
   *   The factory class string from the plugin definition.
   *
   * @return \EclipseGc\Plugin\Factory\FactoryInterface
   *   The instantiated factory.
   */
  protected function resolveFactory(string $factory_class) : FactoryInterface {
    // If the requested factory is the default.
    if ($this->factoryClass == $factory_class) {
      // If we've not yet instantiated the default.
      if (empty($this->factory)) {
        $this->factory = $this->factoryResolver->getFactoryInstance($this->factoryClass);
      }
      // Return the default.
      return $this->factory;
    }
    // If the requested factory is NOT the default.
    return $this->factoryResolver->getFactoryInstance($factory_class);
  }

  /**
   * {@inheritdoc}
   */
  public function invalidateCache() {
    if ($this->cache) {
      $this->cache->invalidate();
    }
  }

}
