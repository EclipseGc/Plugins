<?php

namespace EclipseGc\Plugin\Factory;

/**
 * An interface that abstracts the instantiation of plugins.
 *
 * Plugin often have dependencies external to the plugin system and might
 * require any number of different tactics for instantiation like using a
 * dependency injection container or some sort of static factory. In order to
 * not introduce the logic in some plugin factory adapter, this interface
 * provides a simple mechanism by which to satisfy this requirement as a base
 * assumption of the plugin instantiation mechanism.
 */
interface FactoryResolverInterface {

  /**
   * Resolves a factory class string into a FactoryInterface object.
   *
   * @param string $factoryClass
   *   A string representing the factory or a class name of the factory.
   *
   * @return FactoryInterface
   *   The instantiated factory class.
   */
  public function getFactoryInstance(string $factoryClass) : FactoryInterface;
}