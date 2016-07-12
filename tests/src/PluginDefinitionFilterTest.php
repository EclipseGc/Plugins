<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDefinitionFilterTest.
 */

namespace EclipseGc\Plugin\Test;

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
}
