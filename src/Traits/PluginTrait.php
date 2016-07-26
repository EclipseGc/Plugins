<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Traits\PluginTrait.
 */

namespace EclipseGc\Plugin\Traits;
use EclipseGc\Plugin\PluginDefinitionInterface;

/**
 * Implementation of \EclipseGc\Plugin\PluginInterface
 */
trait PluginTrait {

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface
   */
  protected $definition;

  /**
   * @see \EclipseGc\Plugin\PluginInterface::getPluginId()
   */
  public function getPluginId() : string {
    return $this->definition->getPluginId();
  }

  /**
   * @see \EclipseGc\Plugin\PluginInterface::getPluginDefinition()
   */
  public function getPluginDefinition() : PluginDefinitionInterface {
    return $this->definition;
  }

}
