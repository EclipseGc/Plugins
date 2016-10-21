<?php

namespace EclipseGc\Plugin\Discovery;

use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * Provides a set of plugin definitions.
 */
class PluginDefinitionSet implements \Iterator, \Countable {

  /**
   * The set of plugin definitions.
   *
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $set;

  /**
   * The current iterator pointer.
   *
   * @var int
   */
  protected $pointer = 0;

  /**
   * PluginDefinitionSet constructor.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions
   *   An array of plugin definitions to initially populate the set.
   */
  public function __construct(PluginDefinitionInterface ...$definitions) {
    foreach ($definitions as $definition) {
      $this->set[$definition->getPluginId()] = $definition;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function current() {
    return $this->set[array_keys($this->set)[$this->pointer]];
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
    $keys = array_keys($this->set);
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
  public function count() {
    return count($this->set);
  }

  /**
   * Gets a particular plugin definition from this set.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface
   *   The chosen plugin definition.
   */
  public function getDefinition($pluginId) : PluginDefinitionInterface {
    return $this->hasDefinition($pluginId) ? $this->set[$pluginId] : NULL;
  }

  /**
   * Determines if a particular plugin definition is in this discovery object.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return bool
   *   Boolean value representing the presences of a plugin.
   */
  public function hasDefinition(string $pluginId) : bool {
    return isset($this->set[$pluginId]);
  }

  /**
   * Provides the sets list of plugin ids as an array.
   *
   * @return array
   *   The set of definitions array keys.
   */
  public function getKeys() : array {
    return array_keys($this->set);
  }

  /**
   * Applies a mutator object to the current set of definitions.
   *
   * @param \EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface $mutator
   *   A mutator to apply.
   */
  public function applyMutator(PluginDefinitionMutatorInterface $mutator) {
    $this->set = $mutator->mutate(...array_values($this->set));
  }

  /**
   * Filters the set of definitions and returns a new set.
   *
   * @param \EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface[] $filters
   *   The list of filter to apply.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   The set of plugin definitions.
   */
  public function getFilteredSet(PluginDefinitionFilterInterface ...$filters) : PluginDefinitionSet {
    $set = $this->set;
    foreach ($filters as $filter) {
      $set = array_filter($set, [$filter, 'filter']);
    }
    $new_set = new PluginDefinitionSet(...array_values($set));
    return $new_set;
  }

}
