<?php

namespace EclipseGc\Plugin\Mutator;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;
use EclipseGc\Plugin\Derivative\PluginDeriverResolverInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * A mutator which derives new definitions from definitions with a deriver.
 *
 * Plugin definitions may be mutated in any number of ways before being added
 * to a set of definitions. The deriver mutator checks plugin definitions for
 * implementation of the PluginDefinitionDerivativeInterface and extracts new
 * plugin definitions via the referenced deriver class. This allows a single
 * plugin class to be reference by multiple calculated plugin definitions.
 */
class PluginDefinitionDeriverMutator implements PluginDefinitionMutatorInterface {

  /**
   * The instantiated plugin deriver resolver.
   *
   * @var \EclipseGc\Plugin\Derivative\PluginDeriverResolverInterface
   */
  protected $deriverResolver;

  /**
   * PluginDefinitionDeriverMutator constructor.
   *
   * @param \EclipseGc\Plugin\Derivative\PluginDeriverResolverInterface $deriverResolver
   */
  public function __construct(PluginDeriverResolverInterface $deriverResolver) {
    $this->deriverResolver = $deriverResolver;
  }

  /**
   * {@inheritdoc}
   */
  public function mutate(PluginDefinitionInterface ...$definitions) : array {
    $results = [];
    foreach ($definitions as $definition) {
      if ($definition instanceof PluginDefinitionDerivativeInterface) {
        $deriver = $this->deriverResolver->getDeriverInstance($definition->getDeriver());
        foreach ($deriver->getDerivativeDefinitions($definition) as $pluginDefinition) {
          $results[$pluginDefinition->getPluginId()] = $pluginDefinition;
        }
        continue;
      }
      $results[$definition->getPluginId()] = $definition;
    }
    return $results;
  }

}
