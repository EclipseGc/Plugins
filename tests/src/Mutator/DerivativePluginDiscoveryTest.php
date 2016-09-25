<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\DerivativePluginDiscoveryTest.
 */

namespace EclipseGc\Plugin\Test\Mutator;

use EclipseGc\Plugin\Mutator\PluginDefinitionDeriverMutator;
use EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary;
use EclipseGc\Plugin\Test\Utility\PluginDiscoveryDerivatives;
use EclipseGc\Plugin\Test\Utility\TestDeriverResolver;

class DerivativePluginDiscoveryTest extends \PHPUnit_Framework_TestCase {

  public function testPluginDefinitionDeriverMutator() {
    $discovery = $this->getMockForAbstractClass(AbstractPluginDictionary::class);
    $discovery->setDiscovery(new PluginDiscoveryDerivatives());
    $mutator = new PluginDefinitionDeriverMutator(new TestDeriverResolver());
    $discovery->setMutators($mutator);
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
