<?php

namespace EclipseGc\Plugin\Cache;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;

/**
 * An interface to define plugin cache objects.
 */
interface CacheInterface {

  /**
   * Gets the cached plugin definition set.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   *   The cached plugin definition set.
   */
  public function get();

  /**
   * Sets the plugin definition set to cache.
   *
   * @param \EclipseGc\Plugin\Discovery\PluginDefinitionSet $set
   *   The plugin definition set to cache.
   */
  public function set(PluginDefinitionSet $set);

  /**
   * Invalidates the cached plugin definition set.
   */
  public function invalidate();

}
