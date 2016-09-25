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
   * @return string
   */
  public function getDeriver() : string ;

}
