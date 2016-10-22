<?php

namespace EclipseGc\Plugin;

/**
 * The interface all plugins are expected to implement.
 */
interface PluginInterface {

  /**
   * Gets the name of the plugin.
   *
   * @return string
   *   The plugin id.
   */
  public function getPluginId() : string;

  /**
   * Gets the definition of the plugin.
   *
   * @return PluginDefinitionInterface
   *   The plugin definition.
   */
  public function getPluginDefinition() : PluginDefinitionInterface;

}
