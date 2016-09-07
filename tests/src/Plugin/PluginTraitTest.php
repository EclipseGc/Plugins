<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Plugin\PluginTraitTest.
 */

namespace EclipseGc\Plugin\Test\Plugin;

class PluginTraitTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \EclipseGc\Plugin\Traits\PluginTrait::getPluginId
   * @covers \EclipseGc\Plugin\Traits\PluginTrait::getPluginDefinition
   */
  public function testPluginTrait() {
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

    /** @var \EclipseGc\Plugin\PluginInterface $plugin */
    $plugin = $this->getMockForTrait('\EclipseGc\Plugin\Traits\PluginTrait');
    $r = new \ReflectionClass($plugin);
    $r_property = $r->getProperty('definition');
    $r_property->setAccessible(TRUE);
    $r_property->setValue($plugin, $definition);

    $this->assertEquals('plugin_definition_1', $plugin->getPluginId());
    $this->assertEquals($definition, $plugin->getPluginDefinition());
  }

}
