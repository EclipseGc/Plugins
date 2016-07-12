<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\AbstractPluginDiscovery.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
use EclipseGc\Plugin\Traits\PluginDiscoveryTrait;

abstract class AbstractPluginDiscovery implements PluginDiscoveryInterface{

  use PluginDiscoveryTrait;

}
