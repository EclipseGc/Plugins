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

}
