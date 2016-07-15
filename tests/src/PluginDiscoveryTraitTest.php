<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDiscoveryTraitTest.
 */

namespace EclipseGc\Plugin\Test;

class PluginDiscoveryTraitTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::rewind
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::current
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::key
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::next
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::valid
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getPluginType
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getDefinitions
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::getDefinition
   * @covers \EclipseGc\Plugin\Traits\PluginDiscoveryTrait::hasDefinition
   */
  public function testPluginDiscoveryTrait() {
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
    /** @var \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions */
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
      $definitions[] = $definition;
    }

    /** @var \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDiscovery::class);
    $reflection = new \ReflectionClass($discovery);
    // Set definitions.
    $property = $reflection->getProperty('definitions');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, $definitions);
    // Set plugin type.
    $property = $reflection->getProperty('plugin_type');
    $property->setAccessible(TRUE);
    $property->setValue($discovery, 'test_plugin_type');

    $data_keys = array_keys($definition_data);
    $keyed_definitions = [];
    $this->assertEquals(0, $discovery->key());
    /** @var \EclipseGc\Plugin\PluginDefinitionInterface $definition */
    foreach ($discovery as $key => $definition) {
      $this->assertTrue($discovery->valid());
      $this->assertEquals($definition, $discovery->current());
      $this->assertEquals($key, $discovery->key());
      $data_key = $data_keys[$key];
      $data = $definition_data[$data_key];
      $this->assertEquals($data_key, $definition->getPluginId());
      $this->assertEquals($data, $definition->getProperties());
      $this->assertEquals($data['key_1'], $definition->getProperty('key_1'));
      $this->assertEquals($data['key_2'], $definition->getProperty('key_2'));
      $this->assertEquals($data['key_3'], $definition->getProperty('key_3'));
      $keyed_definitions[$data_key] = $definition;
    }
    // There are 3 items in our iterator, so current key should be 3.
    $this->assertEquals(3, $discovery->key());
    // Manually force it forward to check validity
    $discovery->next();
    // Valid should fail now.
    $this->assertFalse($discovery->valid());
    // Rewind the iterator
    $discovery->rewind();
    // Should be 0.
    $this->assertEquals(0, $discovery->key());
    // We can check current against getDefinition because we know the order.
    $this->assertEquals($discovery->getDefinition('plugin_definition_1'), $discovery->current());
    // Force the iterator forward again.
    $discovery->next();
    // Recheck against getDefinition.
    $this->assertEquals($discovery->getDefinition('plugin_definition_2'), $discovery->current());
    $this->assertEquals('test_plugin_type', $discovery->getPluginType());
    $this->assertEquals($keyed_definitions, $discovery->getDefinitions());
    $this->assertEquals($keyed_definitions['plugin_definition_1'], $discovery->getDefinition('plugin_definition_1'));
    $this->assertEquals($keyed_definitions['plugin_definition_2'], $discovery->getDefinition('plugin_definition_2'));
    $this->assertEquals($keyed_definitions['plugin_definition_3'], $discovery->getDefinition('plugin_definition_3'));
    $this->assertEquals(TRUE, $discovery->hasDefinition('plugin_definition_3'));
    $this->assertEquals(FALSE, $discovery->hasDefinition('plugin_definition_4'));
  }
}
