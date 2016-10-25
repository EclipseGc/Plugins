<?php

namespace EclipseGc\Plugin\Derivative;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * An interface to implement for plugin definitions providing derivatives.
 *
 * Plugin definitions can be iterated over via a deriver to create multiple
 * instances of the same plugin with different plugin definitions. A deriver
 * class provides this capability and must be documented in the plugin
 * definition.
 */
interface PluginDefinitionDerivativeInterface extends PluginDefinitionInterface {

  /**
   * Get the deriver class or string representation for this plugin definition.
   *
   * @return string
   *   A class or string to be resolved as a plugin deriver.
   */
  public function getDeriver() : string;

  /**
   * Set the deriver to be used for a plugin definition.
   *
   * @param string $deriver
   *   The string representing the plugin deriver to be used.
   */
  public function setDeriver(string $deriver);

}
