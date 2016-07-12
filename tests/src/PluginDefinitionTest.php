<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDefinitionTest.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\PluginDefinitionInterface;

class PluginDefinitionTest extends \PHPUnit_Framework_TestCase {

  /**
   * The data provider for \EclipseGc\Plugin\Test\PluginDefinitionTest::testPluginDefinitionInterface
   *
   * @return array
   */
  public function getPluginDefinitions() {
    $definition_data = [
      'plugin_definition_1' => [
        'key_1' => 'value 1',
        'key_2' => 'value 2',
        'key_3' => 'value 3'
      ],
      'plugin_definition_2' => [
        'key_1' => 'value 4',
        'key_2' => 'value 5',
        'key_3' => 'value 6'
      ],
      'plugin_definition_3' => [
        'key_1' => 'value 7',
        'key_2' => 'value 8',
        'key_3' => 'value 9'
      ],
    ];
    $definitions = [];
    foreach ($definition_data as $key => $item) {
      $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
      $definition->method('getPluginId')
        ->willReturn($key);
      $definition->method('getProperties')
        ->willReturn($item);
      $definition->method('getProperty')
        ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
        ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      $definitions[] = [$key, $item, $definition];
    }
    return $definitions;
  }

  /**
   * Tests the plugin definition interface.
   *
   * @dataProvider getPluginDefinitions
   *
   * @covers       \EclipseGc\Plugin\PluginDefinitionInterface::getPluginId
   * @covers       \EclipseGc\Plugin\PluginDefinitionInterface::getProperties
   * @covers       \EclipseGc\Plugin\PluginDefinitionInterface::getProperty
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterface($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($key, $definition->getPluginId());
    $this->assertEquals($item, $definition->getProperties());
    $this->assertEquals($item['key_1'], $definition->getProperty('key_1'));
    $this->assertEquals($item['key_2'], $definition->getProperty('key_2'));
    $this->assertEquals($item['key_3'], $definition->getProperty('key_3'));
  }

}
