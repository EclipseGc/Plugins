<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\DerivativePluginDiscoveryTest.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\Mutator\PluginDefinitionDeriverMutator;

class DerivativePluginDiscoveryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions;

  protected function setUp() {
    parent::setUp();
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
      'plugin_definition_4' => [
        'key_1' => 'value 10',
        'key_2' => 'value 11',
        'key_3' => 'value 12'
      ],
    ];
    foreach ($definition_data as $key => $item) {
      if ($key == 'plugin_definition_3') {
        $deriver = $this->createMock('\EclipseGc\Plugin\Derivative\PluginDeriverInterface');
        $deriver->method('getDerivativeDefinitions')
          ->willReturn($this->getMockDerivatives());
        $definition = $this->createMock('\EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface');
        $definition->method('getDeriver')
          ->willReturn($deriver);
      }
      else {
        $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
        $definition->method('getPluginId')
          ->willReturn($key);
        $definition->method('getProperties')
          ->willReturn($item);
        $definition->method('getProperty')
          ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
          ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      }
      $this->definitions[$key] = $definition;
    }
  }

  protected function getMockDerivatives() {
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
      $definitions[] = $definition;
    }
    return $definitions;
  }

  public function testPluginDefinitionDeriverMutator() {
    $discovery = $this->getMockForAbstractClass(AbstractPluginDiscovery::class);
    $reflection = new \ReflectionClass($discovery);
    $definitions = $reflection->getProperty('definitions');
    $definitions->setAccessible(TRUE);
    $definitions->setValue($discovery, array_values($this->definitions));
    $mutator = new PluginDefinitionDeriverMutator();
    $property = $reflection->getProperty('mutators');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, [$mutator]);
    $this->assertEquals(5, count($discovery->getDefinitions()));
    $definition = $discovery->getDefinition('plugin_definition_3:test2');
    $this->assertEquals('plugin_definition_3:test2', $definition->getPluginId());
    $this->assertEquals([
      'key_1' => 'value 7 test2',
      'key_2' => 'value 8 test2',
      'key_3' => 'value 9 test2'
    ], $definition->getProperties());
    $this->assertEquals('value 7 test2', $definition->getProperty('key_1'));
    $this->assertEquals('value 8 test2', $definition->getProperty('key_2'));
    $this->assertEquals('value 9 test2', $definition->getProperty('key_3'));
  }

}
