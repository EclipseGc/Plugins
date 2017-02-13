<?php

namespace EclipseGc\Plugin\Discovery;

use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\Traits\PluginDictionaryTrait;

/**
 * A plugin dictionary that allows arbitrary plugin definitions to be added.
 */
class StaticPluginDictionary implements StaticPluginDictionaryInterface {

  use PluginDictionaryTrait;

  /**
   * The array of added plugin definitions.
   *
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions = [];

  /**
   * {@inheritdoc}
   */
  public function addPluginDefinition(PluginDefinitionInterface $definition) : StaticPluginDictionaryInterface {
    $this->definitions[] = $definition;
    // Reset the set and cache of definitions to pick up this new definition.
    if ($this->set && $this->cache) {
      $this->cache->invalidate();
    }
    $this->set = NULL;
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Overridden to pass $this->definitions to the discovery object.
   */
  public function getDefinitions() : PluginDefinitionSet {
    if (is_null($this->set) && $this->cache) {
      $values = $this->cache->get();
      $this->set = $values->count() ? $values : NULL;
    }
    if (is_null($this->set) && !is_null($this->discovery)) {
      $set = $this->discovery->findPluginImplementations(...$this->definitions);
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

}
