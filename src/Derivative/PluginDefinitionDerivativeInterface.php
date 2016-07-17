<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface.
 */

namespace EclipseGc\Plugin\Derivative;

use EclipseGc\Plugin\PluginDefinitionInterface;

interface PluginDefinitionDerivativeInterface extends PluginDefinitionInterface{

  /**
   * Get the deriver class for this plugin definition.
   *
   * @return \EclipseGc\Plugin\Derivative\PluginDeriverInterface
   */
  public function getDeriver();

  /**
   * Get the array of dependencies for the deriver class.
   *
   * @return array mixed
   */
  public function getDeriverDependencies();

}
