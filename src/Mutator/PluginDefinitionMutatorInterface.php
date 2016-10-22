<?php

namespace EclipseGc\Plugin\Mutator;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * An interface for mutating plugin definitions as necessary during discovery.
 *
 * Plugin definitions may be mutated in any number of ways before being added
 * to a set of definitions. This means a set of plugin definitions can be
 * altered to include new definitions, exclude existing definition, expand one
 * definition into many or any other sort of changes to the group of
 * definitions which would affect all subsystems using the plugin type.
 */
interface PluginDefinitionMutatorInterface {

  /**
   * Mutates plugin definitions by altering or expanding them.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface ...$definitions
   *   The plugin definitions to mutate.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   *   The mutated plugin definitions.
   */
  public function mutate(PluginDefinitionInterface ...$definitions) : array;

}
