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
   */
  protected function getInitialSet() {
    return $this->discovery->findPluginImplementations(...$this->definitions);
  }

}
