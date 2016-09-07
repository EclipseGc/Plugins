<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDefinitionTest.
 */

namespace EclipseGc\Plugin\Test\Definition;

use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\Test\Utility\PluginTestTrait;

class PluginDefinitionInterfaceTest extends \PHPUnit_Framework_TestCase {

  use PluginTestTrait;

  /**
   * The data provider for \EclipseGc\Plugin\Test\PluginDefinitionTest::testPluginDefinitionInterface
   *
   * @return array
   */
  public function pluginDefinitionProvider() {
    $items = array_values($this->definition_data);
    $keys = array_keys($this->definition_data);
    $definitions = [];
    $i = 0;
    foreach ($this->getPluginDefinitions() as $definition) {
      $definitions[] = [$keys[$i], $items[$i], $definition];
      $i++;
    }
    return $definitions;
  }

  /**
   * @covers \EclipseGc\Plugin\PluginDefinitionInterface::getPluginId
   *
   * @dataProvider pluginDefinitionProvider
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterfaceGetPluginId($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($key, $definition->getPluginId());
  }

  /**
   * @covers \EclipseGc\Plugin\PluginDefinitionInterface::getProperties
   *
   * @dataProvider pluginDefinitionProvider
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterfaceGetProperties($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($item, $definition->getProperties());
  }

  /**
   * @covers \EclipseGc\Plugin\PluginDefinitionInterface::getProperty
   *
   * @dataProvider pluginDefinitionProvider
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterfaceGetProperty($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($item['key_1'], $definition->getProperty('key_1'));
    $this->assertEquals($item['key_2'], $definition->getProperty('key_2'));
    $this->assertEquals($item['key_3'], $definition->getProperty('key_3'));
  }

  /**
   * @covers \EclipseGc\Plugin\PluginDefinitionInterface::getClass
   *
   * @dataProvider pluginDefinitionProvider
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterfaceGetClass($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($item['class'], $definition->getClass());
  }

  /**
   * @covers \EclipseGc\Plugin\PluginDefinitionInterface::getFactory
   *
   * @dataProvider pluginDefinitionProvider
   *
   * @param string $key
   * @param array $item
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   */
  public function testPluginDefinitionInterfaceGetFactory($key, $item, PluginDefinitionInterface $definition) {
    $this->assertEquals($item['factory'], $definition->getFactory());
  }

}
