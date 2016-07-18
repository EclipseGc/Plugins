<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface.
 */

namespace EclipseGc\Plugin\Mutator;

use EclipseGc\Plugin\PluginDefinitionInterface;

interface PluginDefinitionMutatorInterface {

  /**
   * Mutates plugin definitions by altering or expanding them.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  public function mutate(PluginDefinitionInterface ...$definitions);
}
