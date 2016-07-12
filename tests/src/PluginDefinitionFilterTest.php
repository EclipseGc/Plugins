<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDefinitionFilterTest.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\Discovery\PluginDefinitionFilterInterface;

class PluginDefinitionFilterTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions;

  /**
   * {@inheritdoc}
   */
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
      $definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
      $definition->method('getPluginId')
        ->willReturn($key);
      $definition->method('getProperties')
        ->willReturn($item);
      $definition->method('getProperty')
        ->withConsecutive(['key_1'], ['key_2'], ['key_3'])
        ->willReturnOnConsecutiveCalls($item['key_1'], $item['key_2'], $item['key_3']);
      $this->definitions[$key] = $definition;
    }
  }

  public function testEvenPluginDefinitionFilter() {
    /** @var \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDiscovery::class);
    $reflection = new \ReflectionClass($discovery);
    $property = $reflection->getProperty('definitions');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, array_values($this->definitions));
    $this->assertEquals(4, count($discovery->getDefinitions()));
    $filter = new EvenPluginDefinitionFilter();
    $new_discovery = $discovery->getFilteredDiscovery([$filter]);
    $this->assertEquals(2, count($new_discovery->getDefinitions()));
    $this->assertEquals(4, count($discovery->getDefinitions()));
  }

  public function testPluginDefinitionFilterInterfaces() {
    $definitions = $this->definitions;
    unset($definitions['plugin_definition_4']);
    /** @var \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDiscovery::class);
    $reflection = new \ReflectionClass($discovery);
    $property = $reflection->getProperty('definitions');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, array_values($this->definitions));
    $filter1 = $this->createMock(PluginDefinitionFilterInterface::class);
    $filter1->method('filter')
      ->willReturn($definitions);
    unset($definitions['plugin_definition_2']);
    $filter2 = $this->createMock(PluginDefinitionFilterInterface::class);
    $filter2->method('filter')
      ->willReturn($definitions);
    $new_discovery = $discovery->getFilteredDiscovery([$filter1]);
    $this->assertEquals(3, count($new_discovery->getDefinitions()));
    $expected_definitions = [
      0 => 'plugin_definition_1',
      1 => 'plugin_definition_2',
      2 => 'plugin_definition_3',
    ];
    $this->assertEquals($expected_definitions, array_keys($new_discovery->getDefinitions()));
    $new_discovery = $discovery->getFilteredDiscovery([$filter1, $filter2]);
    $this->assertEquals(2, count($new_discovery->getDefinitions()));
    $expected_definitions = [
      0 => 'plugin_definition_1',
      1 => 'plugin_definition_3',
    ];
    $this->assertEquals($expected_definitions, array_keys($new_discovery->getDefinitions()));
  }
}
