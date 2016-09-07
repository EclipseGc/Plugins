<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginTestTrait.
 */

namespace EclipseGc\Plugin\Test\Utility;

/**
 * Class PluginTestTrait
 * @package EclipseGc\Plugin\Test
 *
 * This trait is meant for use on \PHPUnit_Framework_TestCase classes.
 */
trait PluginTestTrait {

  /**
   * @var array
   */
  protected $definition_data = [
    'plugin_definition_1' => [
      'key_1' => 'value 1',
      'key_2' => 'value 2',
      'key_3' => 'value 3',
      'class' => '\EclipseGc\Plugin\Test\Utility\TestPluginClass',
      'factory' => '\EclipseGc\Plugin\Test\Factory\TestPluginFactory'
    ],
    'plugin_definition_2' => [
      'key_1' => 'value 4',
      'key_2' => 'value 5',
      'key_3' => 'value 6',
      'class' => '\EclipseGc\Plugin\Test\Utility\TestPluginClass',
      'factory' => '\EclipseGc\Plugin\Test\Factory\TestPluginFactory'
    ],
    'plugin_definition_3' => [
      'key_1' => 'value 7',
      'key_2' => 'value 8',
      'key_3' => 'value 9',
      'class' => '\EclipseGc\Plugin\Test\Utility\TestPluginClass',
      'factory' => '\EclipseGc\Plugin\Test\Factory\TestPluginFactory'
    ],
  ];

  /**
   * Returns a list of plugin definitions from the data in $definition_data.
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected function getPluginDefinitions() {
    $definitions = [];
    foreach ($this->definition_data as $key => $item) {
      $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
      $definition->method('getPluginId')
        ->willReturn($key);
      $definition->method('getProperties')
        ->willReturn($item);
      $definition->method('getProperty')
        ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
        ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      $definition->method('getClass')
        ->willReturn($item['class']);
      $definition->method('getFactory')
        ->willReturn($item['factory']);
      $definitions[] = $definition;
    }
    return $definitions;
  }

}
