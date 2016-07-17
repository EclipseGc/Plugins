<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Derivative\PluginDeriverInterface.
 */

namespace EclipseGc\Plugin\Derivative;

interface PluginDeriverInterface {

  /**
   * Get definitions derived from the parent definition.
   *
   * @param \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface $definition
   *   The definition from which to derive new definitions.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  public function getDerivativeDefinitions(PluginDefinitionDerivativeInterface $definition);

}
