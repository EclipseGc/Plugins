<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\DerivativePluginDiscoveryTest.
 */

namespace EclipseGc\Plugin\Test\Mutator;

use EclipseGc\Plugin\Mutator\PluginDefinitionDeriverMutator;
use EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary;
use EclipseGc\Plugin\Test\Utility\PluginDiscoveryDerivatives;
use EclipseGc\Plugin\Test\Utility\SetOtherDeriverMutator;
use EclipseGc\Plugin\Test\Utility\TestDeriverResolver;

class DerivativePluginDiscoveryTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface::getDeriver
   */
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

  /**
   * @covers \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface::getDeriver
   * @covers \EclipseGc\Plugin\Derivative\PluginDefinitionDerivativeInterface::setDeriver
   */
  public function testSetDeriver() {
    /** @var \EclipseGc\Plugin\Dictionary\PluginDictionaryInterface $discovery */
    $discovery = $this->getMockForAbstractClass(AbstractPluginDictionary::class);
    $discovery->setDiscovery(new PluginDiscoveryDerivatives());
    $mutator1 = new SetOtherDeriverMutator();
    $mutator2 = new PluginDefinitionDeriverMutator(new TestDeriverResolver());
    $discovery->setMutators($mutator1, $mutator2);
    $this->assertEquals(5, count($discovery->getDefinitions()));
    $definition = $discovery->getDefinition('plugin_definition_3:test4');
    $this->assertEquals('plugin_definition_3:test4', $definition->getPluginId());
    $this->assertEquals([
      'key_1' => 'value 7 test2',
      'key_2' => 'value 8 test2',
      'key_3' => 'value 9 test2'
    ], $definition->getProperties());
    $this->assertEquals('value 7 test2', $definition->getProperty('key_1'));
    $this->assertEquals('value 8 test2', $definition->getProperty('key_2'));
    $this->assertEquals('value 9 test2', $definition->getProperty('key_3'));
    $this->assertTrue($discovery->hasDefinition('plugin_definition_3:test3'));
    $this->assertFalse($discovery->hasDefinition('plugin_definition_3:test'));
    $this->assertFalse($discovery->hasDefinition('plugin_definition_3:test2'));
  }
}
