<?php

namespace EclipseGc\Plugin\Traits;

use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * A trait that implements the methods of \EclipseGc\Plugin\PluginInterface.
 */
trait PluginTrait {

  /**
   * The plugin definition.
   *
   * @var \EclipseGc\Plugin\PluginDefinitionInterface
   */
  protected $definition;

  /**
   * Implementations \EclipseGc\Plugin\PluginInterface::getPluginId().
   *
   * @see \EclipseGc\Plugin\PluginInterface::getPluginId()
   */
  public function getPluginId() : string {
    return $this->definition->getPluginId();
  }

  /**
   * Implementations \EclipseGc\Plugin\PluginInterface::getPluginDefinition().
   *
   * @see \EclipseGc\Plugin\PluginInterface::getPluginDefinition()
   */
  public function getPluginDefinition() : PluginDefinitionInterface {
    return $this->definition;
  }

}
