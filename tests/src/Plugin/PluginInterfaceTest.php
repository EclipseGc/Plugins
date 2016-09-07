<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Plugin\PluginInterfaceTest.
 */

namespace EclipseGc\Plugin\Test\Plugin;

class PluginInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \EclipseGc\Plugin\PluginInterface::getPluginId
   * @covers \EclipseGc\Plugin\PluginInterface::getPluginDefinition
   */
  public function testPluginInterface() {
    /** @var \EclipseGc\Plugin\PluginDefinitionInterface $definition */
    $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
    $definition->method('getPluginId')
      ->willReturn('plugin_definition_1');
    $definition->method('getProperties')
      ->willReturn([
        'key_1' => 'value 1',
        'key_2' => 'value 2',
        'key_3' => 'value 3'
      ]);

    $plugin = $this->createMock('\EclipseGc\Plugin\PluginInterface');
    $plugin->method('getPluginDefinition')
      ->willReturn($definition);
    $plugin->method('getPluginId')
      ->willReturn($definition->getPluginId());

    $this->assertEquals('plugin_definition_1', $plugin->getPluginId());
    $this->assertEquals($definition, $plugin->getPluginDefinition());
  }
}