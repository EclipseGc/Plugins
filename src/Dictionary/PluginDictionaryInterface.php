<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface.
 */

namespace EclipseGc\Plugin\Dictionary;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

interface PluginDictionaryInterface {

  /**
   * Gets the string name of the associated plugin type.
   *
   * @return string
   */
  public function getPluginType() : string;

  /**
   * Gets the plugin definitions in this discovery object.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   */
  public function getDefinitions() : PluginDefinitionSet;

  /**
   * Gets a particular plugin definition from this dictionary.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface|NULL mixed
   */
  public function getDefinition(string $pluginId) : PluginDefinitionInterface;

  /**
   * Determines if a particular plugin definition is in this dictionary.
   *
   * @param string $pluginId
   *   The plugin id.
   *
   * @return boolean
   */
  public function hasDefinition(string $pluginId) : bool;

  /**
   * Generates a new discovery object with a filtered list of definitions.
   *
   * @param \EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface[] $filters
   *   The list of filters to apply in order of application.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   The filtered plugin definition set.
   */
  public function getFilteredDefinitions(PluginDefinitionFilterInterface ...$filters) : PluginDefinitionSet;

}
