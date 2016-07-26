<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\PluginDefinitionInterface.
 */

namespace EclipseGc\Plugin;

interface PluginDefinitionInterface {

  /**
   * Gets an array of properties on the plugin definition by key value pair.
   *
   * @return array
   */
  public function getProperties() : array ;

  /**
   * Gets the value of a key in the plugin definition.
   *
   * @param string $name
   *
   * @return mixed
   * @throws \EclipseGc\Plugin\Exception\NonExistentPluginDefinitionPropertyException
   */
  public function getProperty($name);

  /**
   * Gets the plugin definition's id.
   *
   * @return string
   */
  public function getPluginId() : string ;

}
