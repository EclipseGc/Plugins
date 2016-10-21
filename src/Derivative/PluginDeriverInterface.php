<?php

namespace EclipseGc\Plugin\Derivative;

/**
 * Derives new plugin definitions from a single definition by some criteria.
 *
 * Derivers take a single plugin definition and generate new plugin definitions
 * generally by looping over some other criteria.
 */
interface PluginDeriverInterface {

  /**
   * Get definitions derived from the parent definition.
   *
   * @param \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface $definition
   *   The definition from which to derive new definitions.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   *   An array of plugin definitions.
   */
  public function getDerivativeDefinitions(PluginDefinitionDerivativeInterface $definition);

}
