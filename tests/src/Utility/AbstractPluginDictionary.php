<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\AbstractPluginDictionary.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Dictionary\PluginDictionaryInterface;
use EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
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

}
