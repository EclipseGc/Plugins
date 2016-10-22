<?php

namespace EclipseGc\Plugin\Filter;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * An interface for determining what plugins belong in a filtered set.
 */
interface PluginDefinitionFilterInterface {

  /**
   * Filters available plugins in the plugin discovery object.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   *   The current plugin definition being evaluated.
   *
   * @return bool
   *   Boolean return to indicate inclusion or exclusion of the definition.
   */
  public function filter(PluginDefinitionInterface $definition) : bool;

}
