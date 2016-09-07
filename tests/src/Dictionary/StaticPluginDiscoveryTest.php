<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\StaticPluginDiscoveryTest.
 */

namespace EclipseGc\Plugin\Test\Dictionary;

use EclipseGc\Plugin\Discovery\StaticPluginDictionary;
use EclipseGc\Plugin\Test\Utility\PluginDiscovery;

class StaticPluginDiscoveryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var array
   */
  protected $definition_data;

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions;

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
    foreach ($this->definition_data as $key => $item) {
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

  /**
   * Test definitions manually added to the StaticPluginDiscovery.
   *
   * @covers \EclipseGc\Plugin\Discovery\StaticPluginDictionary::addPluginDefinition
   * @covers \EclipseGc\Plugin\Discovery\StaticPluginDictionary::getDefinitions
   */
  public function testAddingStaticDefinitions() {
    $dictionary = new StaticPluginDictionary();
    $discovery = new PluginDiscovery();
    $reflection = new \ReflectionClass($dictionary);
    $property = $reflection->getProperty('discovery');
    $property->setAccessible(TRUE);
    $property->setValue($dictionary, $discovery);
    $dictionary->addPluginDefinition($this->definitions['plugin_definition_1'], TRUE);
    $this->assertEquals(1, count($dictionary->getDefinitions()));
    $dictionary->addPluginDefinition($this->definitions['plugin_definition_2'], TRUE);
    $this->assertEquals(2, count($dictionary->getDefinitions()));
    $dictionary->addPluginDefinition($this->definitions['plugin_definition_3'], TRUE);
    $this->assertEquals(3, count($dictionary->getDefinitions()));
    $this->assertEquals($discovery->findPluginImplementations(...array_values($this->definitions)), $dictionary->getDefinitions());
  }

  /**
   * Add a new definition to an existing set of definitions.
   *
   * @covers \EclipseGc\Plugin\Discovery\StaticPluginDictionary::addPluginDefinition
   * @covers \EclipseGc\Plugin\Discovery\StaticPluginDictionary::getDefinitions
   */
  public function testAddingStaticDefinitionToExistingDefinitions() {
    $dictionary = new StaticPluginDictionary();
    $discovery = new PluginDiscovery($this->definition_data);
    $reflection = new \ReflectionClass($dictionary);
    $property = $reflection->getProperty('discovery');
    $property->setAccessible(TRUE);
    $property->setValue($dictionary, $discovery);
    // Ensure we have a known good start point.
    $this->assertEquals($discovery->findPluginImplementations(), $dictionary->getDefinitions());
    // Mock a new definition.
    /** @var \EclipseGc\Plugin\PluginDefinitionInterface $new_definition */
    $new_definition = $this->createMock('\EclipseGc\Plugin\PluginDefinitionInterface');
    $new_definition->method('getPluginId')
      ->willReturn('plugin_definition_4');
    $new_definition->method('getProperties')
      ->willReturn([
        'key_1' => 'value 10',
        'key_2' => 'value 11',
        'key_3' => 'value 12'
      ]);
    $dictionary->addPluginDefinition($new_definition);

    $definitions = $this->definitions;
    $definitions['plugin_definition_4'] = $new_definition;
    $this->assertEquals($discovery->findPluginImplementations(...array_values($definitions)), $dictionary->getDefinitions());
  }

}