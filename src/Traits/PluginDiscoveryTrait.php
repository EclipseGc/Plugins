<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Traits\PluginDiscoveryTrait.
 */

namespace EclipseGc\Plugin\Traits;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;

/**
 * @see \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
 */

trait PluginDiscoveryTrait {

  /**
   * @var string
   */
  protected $plugin_type;

  /**
   * @var \EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface[]
   */
  protected $mutators = [];

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions;

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $keyedDefinitions;

  /**
   * @var int
   */
  protected $pointer = 0;

  /**
   * {@inheritdoc}
   */
  public function current() {
    return $this->definitions[$this->pointer];
  }

  /**
   * {@inheritdoc}
   */
  public function next() {
    $this->pointer++;
  }

  /**
   * {@inheritdoc}
   */
  public function key() {
    return $this->pointer;
  }

  /**
   * {@inheritdoc}
   */
  public function valid() {
    return isset($this->definitions[$this->pointer]);
  }

  /**
   * {@inheritdoc}
   */
  public function rewind() {
    $this->pointer = 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginType() {
    return $this->plugin_type;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    if (is_null($this->keyedDefinitions) || count($this->keyedDefinitions) != count($this->definitions)) {
      $this->keyedDefinitions = NULL;
      foreach ($this->mutators as $mutator) {
        $this->definitions = $mutator->mutate(...$this->definitions);
      }
      foreach ($this->definitions as $definition) {
        $this->keyedDefinitions[$definition->getPluginId()] = $definition;
      }
    }
    return $this->keyedDefinitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinition($plugin_id) {
    $definitions = $this->getDefinitions();
    return !empty($definitions[$plugin_id]) ? $definitions[$plugin_id] : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function hasDefinition($plugin_id) {
    $definitions = $this->getDefinitions();
    return !empty($definitions[$plugin_id]);
  }

  /**
   * {@inheritdoc}
   */
  public function getFilteredDefinitions(PluginDefinitionFilterInterface ...$filters) {
    $new_definitions = $this->getDefinitions();
    foreach ($filters as $filter) {
      $new_definitions = array_filter($new_definitions, [$filter, 'filter']);
    }
    return $new_definitions;
  }

}
