<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDiscoveryTraitTest.
 */

namespace EclipseGc\Plugin\Test\Set;

use EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary;
use EclipseGc\Plugin\Test\Utility\PluginDiscovery;

class PluginDiscoveryTraitTest extends \PHPUnit_Framework_TestCase {

  protected $definition_data;

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
  }


  /**
   * @covers \EclipseGc\Plugin\Discovery\PluginDefinitionSet::rewind
   * @covers \EclipseGc\Plugin\Discovery\PluginDefinitionSet::current
   * @covers \EclipseGc\Plugin\Discovery\PluginDefinitionSet::key
   * @covers \EclipseGc\Plugin\Discovery\PluginDefinitionSet::next
   * @covers \EclipseGc\Plugin\Discovery\PluginDefinitionSet::valid
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getPluginType
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getDefinitions
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getDefinition
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::hasDefinition
   */
  public function testPluginDiscoveryTrait() {
    /** @var \EclipseGc\Plugin\Discovery\PluginDictionaryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDictionary::class);
    $discovery->setDiscovery(new PluginDiscovery($this->definition_data));
    $reflection = new \ReflectionClass($discovery);
    // Set plugin type.
    $property = $reflection->getProperty('plugin_type');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, 'test_plugin_type');

    $data_keys = array_keys($this->definition_data);
    $keyed_definitions = [];
    $set = $discovery->getDefinitions();
    $this->assertEquals(0, $set->key());
    /** @var \EclipseGc\Plugin\PluginDefinitionInterface $definition */
    foreach ($set as $key => $definition) {
      $this->assertTrue($set->valid());
      $this->assertEquals($definition, $set->current());
      $this->assertEquals($key, $set->key());
      $data_key = $data_keys[$key];
      $data = $this->definition_data[$data_key];
      $this->assertEquals($data_key, $definition->getPluginId());
      $this->assertEquals($data, $definition->getProperties());
      $this->assertEquals($data['key_1'], $definition->getProperty('key_1'));
      $this->assertEquals($data['key_2'], $definition->getProperty('key_2'));
      $this->assertEquals($data['key_3'], $definition->getProperty('key_3'));
      $keyed_definitions[$data_key] = $definition;
    }
    // There are 3 items in our iterator, so current key should be 3.
    $this->assertEquals(3, $set->key());
    // Manually force it forward to check validity
    $set->next();
    // Valid should fail now.
    $this->assertFalse($set->valid());
    // Rewind the iterator
    $set->rewind();
    // Should be 0.
    $this->assertEquals(0, $set->key());
    // We can check current against getDefinition because we know the order.
    $this->assertEquals($discovery->getDefinition('plugin_definition_1'), $set->current());
    // Force the iterator forward again.
    $set->next();
    // Recheck against getDefinition.
    $this->assertEquals($discovery->getDefinition('plugin_definition_2'), $set->current());
    $this->assertEquals('test_plugin_type', $discovery->getPluginType());
    $this->assertEquals($keyed_definitions['plugin_definition_1'], $discovery->getDefinition('plugin_definition_1'));
    $this->assertEquals($keyed_definitions['plugin_definition_2'], $discovery->getDefinition('plugin_definition_2'));
    $this->assertEquals($keyed_definitions['plugin_definition_3'], $discovery->getDefinition('plugin_definition_3'));
    $this->assertEquals(TRUE, $discovery->hasDefinition('plugin_definition_3'));
    $this->assertEquals(FALSE, $discovery->hasDefinition('plugin_definition_4'));
  }
}
