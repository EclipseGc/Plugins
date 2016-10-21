<?php

namespace EclipseGc\Plugin\Factory;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * An interface responsible for instantiating plugins from a definition.
 */
interface FactoryInterface {


  /**
   * Creates a new instance of a specific plugin.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   *   The plugin definition of the plugin to instantiate.
   *
   * @param array ...$constructors
   *   A variadic parameter which holds constructor parameters for the plugin.
   *
   * @return mixed
   */
  public function createInstance(PluginDefinitionInterface $definition, ...$constructors);

}