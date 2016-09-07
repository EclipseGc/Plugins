<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDefinitionFilterTest.
 */

namespace EclipseGc\Plugin\Test\Filter;

use EclipseGc\Plugin\Filter\PluginDefinitionFilterInterface;
use EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary;
use EclipseGc\Plugin\Test\Utility\EvenPluginDefinitionFilter;
use EclipseGc\Plugin\Test\Utility\PluginDiscovery;

class PluginDefinitionFilterTest extends \PHPUnit_Framework_TestCase {

  protected $definition_data = [
    'plugin_definition_1' => [
      'key_1' => 'value 1',
      'key_2' => 'value 2',
      'key_3' => 'value 3',
      'class' => 'EclipseGc\Plugin\Test\TestPlugin',
      'factory' => 'EclipseGc\Plugin\Test\Factory\TestFactory',
    ],
    'plugin_definition_2' => [
      'key_1' => 'value 4',
      'key_2' => 'value 5',
      'key_3' => 'value 6',
      'class' => 'EclipseGc\Plugin\Test\TestPlugin',
      'factory' => 'EclipseGc\Plugin\Test\Factory\TestFactory',
    ],
    'plugin_definition_3' => [
      'key_1' => 'value 7',
      'key_2' => 'value 8',
      'key_3' => 'value 9',
      'class' => 'EclipseGc\Plugin\Test\TestPlugin',
      'factory' => 'EclipseGc\Plugin\Test\Factory\TestFactory',
    ],
    'plugin_definition_4' => [
      'key_1' => 'value 10',
      'key_2' => 'value 11',
      'key_3' => 'value 12',
      'class' => 'EclipseGc\Plugin\Test\TestPlugin',
      'factory' => 'EclipseGc\Plugin\Test\Factory\TestFactory',
    ],
  ];


  public function testEvenPluginDefinitionFilter() {
    /** @var \EclipseGc\Plugin\Discovery\PluginDictionaryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDictionary::class);
    $discovery->setDiscovery(new PluginDiscovery($this->definition_data));
    $this->assertEquals(4, count($discovery->getDefinitions()));
    $filter = new EvenPluginDefinitionFilter();
    $filtered_definitions = $discovery->getFilteredDefinitions($filter);
    $this->assertEquals(2, count($filtered_definitions));
    $this->assertEquals(4, count($discovery->getDefinitions()));
  }

  public function testPluginDefinitionFilterInterfaces() {
    /** @var \EclipseGc\Plugin\Discovery\PluginDictionaryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDictionary::class);
    $discovery->setDiscovery(new PluginDiscovery($this->definition_data));
    $filter1 = $this->createMock(PluginDefinitionFilterInterface::class);
    // We'll use $filter1 twice, so the returns are input in duplicate.
    $filter1->method('filter')
      ->willReturnOnConsecutiveCalls(TRUE, TRUE, TRUE, FALSE, TRUE, TRUE, TRUE, FALSE);
    $filter2 = $this->createMock(PluginDefinitionFilterInterface::class);
    $filter2->method('filter')
      ->willReturnOnConsecutiveCalls(TRUE, FALSE, TRUE);
    $filtered_definitions = $discovery->getFilteredDefinitions($filter1);
    $this->assertEquals(3, count($filtered_definitions));
    $expected_definitions = [
      0 => 'plugin_definition_1',
      1 => 'plugin_definition_2',
      2 => 'plugin_definition_3',
    ];
    $this->assertEquals($expected_definitions, $filtered_definitions->getKeys());
    $filtered_definitions = $discovery->getFilteredDefinitions($filter1, $filter2);
    $this->assertEquals(2, count($filtered_definitions));
    $expected_definitions = [
      0 => 'plugin_definition_1',
      1 => 'plugin_definition_3',
    ];
    $this->assertEquals($expected_definitions, $filtered_definitions->getKeys());
  }
}
