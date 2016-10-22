<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\AbstractPluginDictionary.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Dictionary\PluginDictionaryInterface;
use EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
use EclipseGc\Plugin\Factory\FactoryResolverInterface;
use EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface;
use EclipseGc\Plugin\Traits\PluginDictionaryTrait;

abstract class AbstractPluginDictionary implements PluginDictionaryInterface {

  use PluginDictionaryTrait;

  /**
   * Helpful setter for setting discovery during testing.
   *
   * @param \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface $discovery
   */
  public function setDiscovery(PluginDiscoveryInterface $discovery) {
    $this->discovery = $discovery;
  }

  /**
   * Helpful setting for setting mutators during testing.
   *
   * @param \EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface[] ...$mutators
   */
  public function setMutators(PluginDefinitionMutatorInterface ...$mutators) {
    $this->mutators = $mutators;
  }

  /**
   * Setter for factory class string.
   *
   * @param string $factoryClass
   */
  public function setFactoryClass(string $factoryClass) {
    $this->factoryClass = $factoryClass;
  }

  /**
   * Setter for factory resolver.
   *
   * @param \EclipseGc\Plugin\Factory\FactoryResolverInterface $factoryResolver
   */
  public function setFactoryResolver(FactoryResolverInterface $factoryResolver) {
    $this->factoryResolver = $factoryResolver;
  }

  /**
   * Reset the factory to NULL.
   */
  public function resetFactory() {
    $this->factory = NULL;
  }

}
