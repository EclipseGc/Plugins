<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\PluginDiscovery.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class PluginDiscovery extends \PHPUnit_Framework_TestCase implements PluginDiscoveryInterface {

  protected $definition_data = [];

  /**
   * PluginDiscovery constructor.
   *
   * @param array $definitionData
   *   An array that can be turned into PluginDefinitionInterface objects.
   */
  public function __construct(array $definitionData = []) {
    $this->definition_data = $definitionData;
  }

  /**
   * {@inheritdoc}
   */
  public function findPluginImplementations(PluginDefinitionInterface ...$definitions) : PluginDefinitionSet {
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
        ->willReturn('EclipseGc\Plugin\Test\TestPlugin');
      $definition->method('getClass')
        ->willReturn('EclipseGc\Plugin\Test\Factory\TestFactory');
      $definitions[] = $definition;
    }
    return new PluginDefinitionSet(...$definitions);
  }

}
