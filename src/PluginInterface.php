<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\PluginInterface.
 */

namespace EclipseGc\Plugin;

interface PluginInterface {

  /**
   * Gets the name of the plugin.
   *
   * @return string
   */
  public function getPluginId() : string ;

  /**
   * Gets the definition of the plugin.
   *
   * @return PluginDefinitionInterface
   */
  public function getPluginDefinition() : PluginDefinitionInterface ;

}
