<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\AbstractPluginDefinitionDerivative.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;

abstract class AbstractPluginDefinitionDerivative implements PluginDefinitionDerivativeInterface {

  protected $deriver;

  public function getDeriver(): string {
    return $this->deriver;
  }

  public function setDeriver(string $deriver) {
    $this->deriver = $deriver;
  }

}
