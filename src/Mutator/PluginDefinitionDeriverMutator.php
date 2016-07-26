<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Filter\PluginDefinitionDeriverFilter.
 */

namespace EclipseGc\Plugin\Mutator;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class PluginDefinitionDeriverMutator implements PluginDefinitionMutatorInterface {

  /**
   * {@inheritdoc}
   */
  public function mutate(PluginDefinitionInterface ...$definitions) : array {
    $results = [];
    foreach ($definitions as $definition) {
      if ($definition instanceof PluginDefinitionDerivativeInterface) {
        $deriver = $definition->getDeriver();
        $results = array_merge($results, $deriver->getDerivativeDefinitions($definition));
        continue;
      }
      $results[$definition->getPluginId()] = $definition;
    }
    return $results;
  }

}
