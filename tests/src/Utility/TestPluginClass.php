<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\TestPluginClass.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\PluginInterface;
use EclipseGc\Plugin\Traits\PluginTrait;

class TestPluginClass implements PluginInterface {

  use PluginTrait;

  public $arg1;

  public $arg2;

  public function __construct(PluginDefinitionInterface $definition, $arg_1 = NULL, $arg_2 = NULL) {
    $this->definition = $definition;
    $this->arg1 = $arg_1;
    $this->arg2 = $arg_2;
  }

}
