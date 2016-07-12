<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Traits\PluginTrait.
 */

namespace EclipseGc\Plugin\Traits;

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
  public function getPluginId() {
    return $this->definition->getPluginId();
  }

  /**
   * @see \EclipseGc\Plugin\PluginInterface::getPluginDefinition()
   */
  public function getPluginDefinition() {
    return $this->definition;
  }

}
