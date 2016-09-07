<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Factory\PluginFactoryInterfaceTest.
 */

namespace EclipseGc\Plugin\Test\Factory;

class PluginFactoryInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var array
   */
  protected $definition_data;

  /**
   * @var \EclipseGc\Plugin\PluginInterface[]
   */
  protected $plugins;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->definition_data = [
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
    $i = 1;
    foreach ($this->definition_data as $key => $item) {
      $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
      $definition->method('getPluginId')
        ->willReturn($key);
      $definition->method('getProperties')
        ->willReturn($item);
      $definition->method('getProperty')
        ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
        ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      $plugin = $this->createMock('\EclipseGc\Plugin\PluginInterface');
      $plugin->method('getPluginDefinition')
        ->willReturn($definition);
      $plugin->method('getPluginId')
        ->willReturn("test_plugin_$i");
      $this->plugins["test_plugin_$i"] = $plugin;
      $i++;
    }
  }

  /**
   * @covers \EclipseGc\Plugin\Factory\FactoryInterface::createInstance
   */
  public function testPluginFactoryInterface() {
    $arg_1 = 'foo';
    $arg_2 = 'bar';
    $definitions = [];
    $definitions[] = $this->plugins['test_plugin_1']->getPluginDefinition();
    $definitions[] = $this->plugins['test_plugin_2']->getPluginDefinition();
    $definitions[] = $this->plugins['test_plugin_3']->getPluginDefinition();
    /** @var \EclipseGc\Plugin\Factory\FactoryInterface $factorzy */
    $factory = $this->createMock('\EclipseGc\Plugin\Factory\FactoryInterface');
    $factory->method('createInstance')
      ->withConsecutive($definitions[0], [$definitions[1], $arg_1], [$definitions[2], $arg_1, $arg_2])
      ->willReturnOnConsecutiveCalls($this->plugins['test_plugin_1'], $this->plugins['test_plugin_2'], $this->plugins['test_plugin_3']);

    $plugin = $factory->createInstance($definitions[0]);
    $this->assertEquals($plugin, $this->plugins["test_plugin_1"]);
    $plugin = $factory->createInstance($definitions[1], $arg_1);
    $this->assertEquals($plugin, $this->plugins["test_plugin_2"]);
    $plugin = $factory->createInstance($definitions[2], $arg_1, $arg_2);
    $this->assertEquals($plugin, $this->plugins["test_plugin_3"]);
  }
}