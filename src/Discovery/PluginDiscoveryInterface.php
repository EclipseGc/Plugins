<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface.
 */

namespace EclipseGc\Plugin\Discovery;

interface PluginDiscoveryInterface extends \Iterator {

  /**
   * Gets the string name of the associated plugin type.
   *
   * @return string
   */
  public function getPluginType();

  /**
   * Gets the plugin definitions in this discovery object.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  public function getDefinitions();

  /**
   * Gets a particular plugin definition in this discovery object.
   *
   * @param string $plugin_id
   *   The plugin id.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface|NULL mixed
   */
  public function getDefinition($plugin_id);

  /**
   * Generates a new discovery object with a filtered list of definitions.
   *
   * @param \EclipseGc\Plugin\Discovery\PluginDefinitionFilterInterface[] $filters
   *   The list of filters to apply in order of application.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface A new instance of the current discovery class with filtered definitions.
   * A new instance of the current discovery class with filtered definitions.
   */
  public function getFilteredDiscovery(PluginDefinitionFilterInterface ...$filters);

}
