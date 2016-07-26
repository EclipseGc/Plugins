<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Traits\PluginDiscoveryTrait.
 */

namespace EclipseGc\Plugin\Traits;
use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

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

}
