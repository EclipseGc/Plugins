<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDefinitionFilterINterface.
 */

namespace EclipseGc\Plugin\Discovery;

interface PluginDefinitionFilterInterface extends PluginDiscoveryInterface {

  /**
   * Filters available plugins in the plugin discovery object.
   *
   * @param \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface $pluginDiscovery
   */
  public function filter(PluginDiscoveryInterface $pluginDiscovery);

}
