<?php

namespace EclipseGc\Plugin\Discovery;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * Interface for defining plugin discovery mechanisms.
 *
 * Plugin discovery consists of any pattern from which a set of plugin
 * definitions can be retrieved. This could include scanning files in specific
 * directory structures for certain criteria, loading a specific file when
 * present in namespaces and parsing it for data, or any other pattern by which
 * individual plugin classes and their corresponding definitions can be found.
 */
interface PluginDiscoveryInterface {

  /**
   * Finds plugins via a particular discovery pattern.
   *
   * Plugin discovery classes can provide a multitude of different options for
   * finding plugin implementations. This could be implemented via yaml files,
   * class annotations, php functions or numerous other solutions. Each
   * discovery class is different and will have different parameters for
   * finding plugins.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] ...$definitions
   *   A list of known definitions to add to the set.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   The set of found plugin definitions.
   */
  public function findPluginImplementations(PluginDefinitionInterface ...$definitions) : PluginDefinitionSet;

}
