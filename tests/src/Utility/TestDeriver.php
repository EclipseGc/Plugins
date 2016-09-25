<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\TestDeriver.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface;
use EclipseGc\Plugin\Derivative\PluginDeriverInterface;

class TestDeriver extends \PHPUnit_Framework_TestCase implements PluginDeriverInterface {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions(PluginDefinitionDerivativeInterface $definition) {
    $items = [
      'plugin_definition_3:test' => [
        'key_1' => 'value 7 test',
        'key_2' => 'value 8 test',
        'key_3' => 'value 9 test'
      ],
      'plugin_definition_3:test2' => [
        'key_1' => 'value 7 test2',
        'key_2' => 'value 8 test2',
        'key_3' => 'value 9 test2'
      ]
    ];
    $definitions = [];
    foreach ($items as $key => $item) {
      $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
      $definition->method('getPluginId')
        ->willReturn($key);
      $definition->method('getProperties')
        ->willReturn($item);
      $definition->method('getProperty')
        ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
        ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      $definitions[$key] = $definition;
    }
    return $definitions;
  }

}
