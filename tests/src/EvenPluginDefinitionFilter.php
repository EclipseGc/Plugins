<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\EvenPluginDefinitionFilter.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\Discovery\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class EvenPluginDefinitionFilter implements PluginDefinitionFilterInterface {

  /**
   * {@inheritdoc}
   */
  public function filter(PluginDefinitionInterface ...$definitions) {
    $filtered = [];
    foreach ($definitions as $definition) {
      $plugin_id = $definition->getPluginId();
      $pos = strrpos($plugin_id, '_');
      $num = (int) substr($plugin_id, $pos+1);
      if (is_int($num) && is_int($num / 2)) {
        $filtered[] = $definition;
      }
    }
    return $filtered;
  }

}
