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
   * @var int
   */
  protected $pointer = 0;

  /**
   * {@inheritdoc}
   */
  public function current() {
    return $this->definitions[array_keys($this->definitions)[$this->pointer]];
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
    $keys = array_keys($this->definitions);
    return !empty($keys[$this->pointer]);
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
    foreach ($this->mutators as $mutator) {
      $this->definitions = $mutator->mutate(...array_values($this->definitions));
    }
    return $this->definitions;
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
