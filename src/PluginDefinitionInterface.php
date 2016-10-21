<?php

namespace EclipseGc\Plugin;

/**
 * The base interface for defining plugin definitions.
 */
interface PluginDefinitionInterface {

  /**
   * Gets an array of properties on the plugin definition by key value pair.
   *
   * @return array
   *   An array of available properties on the definition.
   */
  public function getProperties() : array;

  /**
   * Gets the value of a key in the plugin definition.
   *
   * @param string $name
   *   The name of the property value to retrieve.
   *
   * @return mixed
   *   The value of the requested property.
   *
   * @throws \EclipseGc\Plugin\Exception\NonExistentPluginDefinitionPropertyException
   */
  public function getProperty($name);

  /**
   * Gets the plugin definition's id.
   *
   * @return string
   *   The plugin id of this definition.
   */
  public function getPluginId() : string;

  /**
   * Gets the class name of the plugin.
   *
   * The returned class must implement \EclipseGc\Plugin\PluginInterface.
   *
   * @return string
   *   The class name for the plugin represented by this definition.
   */
  public function getClass() : string;

  /**
   * Gets the class name of the factory.
   *
   * The returned class must implement \EclipseGc\Plugin\Factory\FactoryInterface.
   *
   * @return string
   *   The class of the factory to instantiate the plugin. Can be empty string.
   */
  public function getFactory() : string;

}
