<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Derivative\PluginDeriverResolverInterface.
 */

namespace EclipseGc\Plugin\Derivative;

interface PluginDeriverResolverInterface {

  /**
   * Resolves a deriver class string into a PluginDeriverInterface object.
   *
   * @param string $resolverClass
   *
   * @return \EclipseGc\Plugin\Derivative\PluginDeriverInterface
   *
   */
  public function getDeriverInstance(string $resolverClass) : PluginDeriverInterface ;

}
