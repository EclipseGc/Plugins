<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDiscoveryInterfaceTest.
 */

namespace EclipseGc\Plugin\Test\Discovery;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;

class PluginDiscoveryInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @see EclipseGc\Plugin\Discovery\PluginDiscoveryInterface::findPluginImplementations
   */
  public function testFindPluginImplementations() {
    $discovery = $this->createMock('EclipseGc\Plugin\Discovery\PluginDiscoveryInterface');
    $set = new PluginDefinitionSet();
    $discovery->method('findPluginImplementations')
      ->willReturn($set);
    $this->assertEquals($set, $discovery->findPluginImplementations());
  }

}
