<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\EvenPluginDefinitionFilter.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class EvenPluginDefinitionFilter implements PluginDefinitionFilterInterface {

  /**
   * {@inheritdoc}
   */
  public function filter(PluginDefinitionInterface $definition) : bool {
    $plugin_id = $definition->getPluginId();
    $pos = strrpos($plugin_id, '_');
    $num = (int) substr($plugin_id, $pos+1);
    if (is_int($num) && is_int($num / 2)) {
      return TRUE;
    }
    return FALSE;
  }

}
