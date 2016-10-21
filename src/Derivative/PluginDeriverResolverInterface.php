<?php

namespace EclipseGc\Plugin\Derivative;

/**
 * An interface that abstracts the instantiation of plugin derivers.
 *
 * Plugin derivers often have dependencies external to the greater plugin
 * system and might require any number of different tactics for instantiation
 * like using a dependency injection container or some sort of static factory.
 * In order to not introduce the logic in some plugin discovery adapter, this
 * interface provides a simple mechanism by which to satisfy this requirement
 * as a base level assumption of the plugin deriver mechanism.
 */
interface PluginDeriverResolverInterface {

  /**
   * Resolves a string or class name as a PluginDeriverInterface object.
   *
   * @param string $resolverClass
   *   A string representing a class or the class name itself.
   *
   * @return \EclipseGc\Plugin\Derivative\PluginDeriverInterface
   *   The plugin resolver.
   */
  public function getDeriverInstance(string $resolverClass) : PluginDeriverInterface;

}
