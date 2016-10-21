<?php

namespace EclipseGc\Plugin\Dictionary;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\PluginInterface;

/**
 * An interface for inspecting and instantiating multiple plugin definitions.
 */
interface PluginDictionaryInterface {

  /**
   * Gets the string name of the associated plugin type.
   *
   * @return string
   *   The plugin type.
   */
  public function getPluginType() : string;

  /**
   * Gets the plugin definitions in this discovery object.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   A set of plugin definitions.
   */
  public function getDefinitions() : PluginDefinitionSet;

  /**
   * Gets a particular plugin definition from this dictionary.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface|NULL
   *   The plugin definition if available, otherwise NULL.
   */
  public function getDefinition(string $pluginId) : PluginDefinitionInterface;

  /**
   * Determines if a particular plugin definition is in this dictionary.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return bool
   *   Whether or not a given definition exists in the dictionary.
   */
  public function hasDefinition(string $pluginId) : bool;

  /**
   * Generates a new discovery object with a filtered list of definitions.
   *
   * @param \EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface ...$filters
   *   The list of filters to apply in order of application.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   The filtered plugin definition set.
   */
  public function getFilteredDefinitions(PluginDefinitionFilterInterface ...$filters) : PluginDefinitionSet;

  /**
   * Creates a new instance of the specified plugin.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @param ...$constructors
   *   A variadic parameter for plugin constructor parameters.
   *
   * @return \EclipseGc\Plugin\PluginInterface
   *   A fully instantiated plugin.
   */
  public function createInstance(string $pluginId, ...$constructors) : PluginInterface;

}
