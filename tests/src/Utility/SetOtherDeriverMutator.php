<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\SetOtherDeriverMutator.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;
use EclipseGc\Plugin\Mutator\PluginDefinitionMutatorInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class SetOtherDeriverMutator implements PluginDefinitionMutatorInterface {

  public function mutate(PluginDefinitionInterface ...$definitions): array {
    foreach ($definitions as $definition) {
      if ($definition->getPluginId() == 'plugin_definition_3') {
        /** @var PluginDefinitionDerivativeInterface $definition */
        $definition->setDeriver('\EclipseGc\Plugin\Test\Utility\OtherTestDeriver');
      }
    }
    return $definitions;
  }

}
