<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\StaticPluginDiscoveryTest.
 */

namespace EclipseGc\Plugin\Test;

use EclipseGc\Plugin\Discovery\StaticPluginDiscovery;

class StaticPluginDiscoveryTest extends \PHPUnit_Framework_TestCase {

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

  /**
   * Test definitions manually added to the StaticPluginDiscovery.
   */
  public function testAddingStaticDefinitions() {
    $discovery = new StaticPluginDiscovery();
    $discovery->addPluginDefinition($this->definitions['plugin_definition_1'], TRUE);
    $this->assertEquals(1, count($discovery->getDefinitions()));
    $discovery->addPluginDefinition($this->definitions['plugin_definition_2'], TRUE);
    $this->assertEquals(2, count($discovery->getDefinitions()));
    $discovery->addPluginDefinition($this->definitions['plugin_definition_3'], TRUE);
    $this->assertEquals(3, count($discovery->getDefinitions()));
    $this->assertEquals($this->definitions, $discovery->getDefinitions());
  }

  /**
   * Add a new definition to an existing set of definitions.
   */
  public function testAddingStaticDefinitionToExistingDefinitions() {
    $discovery = new StaticPluginDiscovery();
    $reflection = new \ReflectionClass($discovery);
    $property = $reflection->getProperty('definitions');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, array_values($this->definitions));
    // Ensure we have a known good start point.
    $this->assertEquals($this->definitions, $discovery->getDefinitions());
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
    $discovery->addPluginDefinition($new_definition);

    $definitions = $this->definitions;
    $definitions['plugin_definition_4'] = $new_definition;
    $this->assertEquals($definitions, $discovery->getDefinitions());
  }

  /**
   * The StaticPluginDiscovery::addPluginDefinition method support expanding
   * new definitions into the keyedDefinitions array. This can result in
   * mismatched array lengths that could affect the result of the
   * PluginDiscoveryInterface::getDefinitions. This tests ensures that the
   * logic is accounting for this.
   */
  public function testGetDefinitionsRecalculation() {
    $discovery = new StaticPluginDiscovery();
    $reflection = new \ReflectionClass($discovery);
    $property = $reflection->getProperty('definitions');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, array_values($this->definitions));
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
    $discovery->addPluginDefinition($new_definition, TRUE);

    $definitions = $this->definitions;
    $definitions['plugin_definition_4'] = $new_definition;
    $this->assertEquals($definitions, $discovery->getDefinitions());
  }
}