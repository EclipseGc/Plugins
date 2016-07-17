<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Filter\PluginDefinitionDeriverFilter.
 */

namespace EclipseGc\Plugin\Filter;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class PluginDefinitionDeriverFilter implements PluginDefinitionFilterInterface {

  /**
   * {@inheritdoc}
   */
  public function filter(PluginDefinitionInterface ...$definitions) {
    $filtered = [];
    foreach ($definitions as $definition) {
      if ($definition instanceof PluginDefinitionDerivativeInterface) {
        $deriver = $definition->getDeriver();
        $filtered = array_merge($filtered, $deriver->getDerivativeDefinitions($definition));
        continue;
      }
      $filtered[] = $definition;
    }
    return $filtered;
  }

}
