<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Traits\PluginDiscoveryTrait.
 */

namespace EclipseGc\Plugin\Traits;
use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\PluginInterface;

/**
 * @see \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
 */

trait PluginDictionaryTrait {

  /**
   * The plugin type.
   *
   * @var string
   */
  protected $plugin_type;

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
  protected $factory_class;

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
   * {@inheritdoc}
   */
  public function getPluginType() : string {
    return $this->plugin_type;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() : PluginDefinitionSet {
    if (is_null($this->set) && !is_null($this->discovery)) {
      $set = $this->discovery->findPluginImplementations();
      foreach ($this->mutators as $mutator) {
        $set->applyMutator($mutator);
      }
      $this->set = $set;
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
   */
  protected function resolveFactory(string $factory_class) {
    // If the plugin's factory class is the same as the default.
    if (!empty($this->factory_class) && $this->factory_class == $factory_class) {
      // Check to see if we've previously instantiated the default.
      if (!is_null($this->factory)) {
        $this->factory = $this->factoryResolver->getFactoryInstance($this->factory_class);
      }
      return $this->factory;
    }
    // If the factory is specific to the plugin.
    else {
      return $this->factoryResolver->getFactoryInstance($factory_class);
    }
  }
}
