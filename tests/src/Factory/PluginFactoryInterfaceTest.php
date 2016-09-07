<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Factory\PluginFactoryInterfaceTest.
 */

namespace EclipseGc\Plugin\Test\Factory;

use EclipseGc\Plugin\Test\Utility\PluginDiscovery;
use EclipseGc\Plugin\Test\Utility\PluginTestTrait;
use EclipseGc\Plugin\Test\Utility\TestFactoryResolver;
use EclipseGc\Plugin\Test\Utility\TestPluginClass;

class PluginFactoryInterfaceTest extends \PHPUnit_Framework_TestCase {

  use PluginTestTrait;

  /**
   * @var \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  protected $definitions;

  /**
   * @var \EclipseGc\Plugin\PluginInterface[]
   */
  protected $plugins;

  protected function setUp() {
    $this->definitions = $this->getPluginDefinitions();
    $this->plugins["test_plugin_1"] = new TestPluginClass($this->definitions[0]);
    $this->plugins["test_plugin_2"] = new TestPluginClass($this->definitions[1], 'foo');
    $this->plugins["test_plugin_3"] = new TestPluginClass($this->definitions[2], 'foo', 'bar');
  }

  /**
   * @covers \EclipseGc\Plugin\Factory\FactoryInterface::createInstance
   */
  public function testPluginFactoryInterface() {
    $arg_1 = 'foo';
    $arg_2 = 'bar';
    /** @var \EclipseGc\Plugin\Factory\FactoryInterface $factorzy */
    $factory = $this->createMock('\EclipseGc\Plugin\Factory\FactoryInterface');
    $factory->method('createInstance')
      ->withConsecutive($this->definitions[0], [$this->definitions[1], $arg_1], [$this->definitions[2], $arg_1, $arg_2])
      ->willReturnOnConsecutiveCalls($this->plugins['test_plugin_1'], $this->plugins['test_plugin_2'], $this->plugins['test_plugin_3']);

    /** @var \EclipseGc\Plugin\PluginInterface $plugin */
    $plugin = $factory->createInstance($this->definitions[0]);
    $this->assertEquals($plugin, $this->plugins["test_plugin_1"]);
    $this->assertEquals($plugin->arg1, NULL);
    $this->assertEquals($plugin->arg2, NULL);
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins["test_plugin_1"]->getPluginDefinition());
    $plugin = $factory->createInstance($this->definitions[1], $arg_1);
    $this->assertEquals($plugin, $this->plugins["test_plugin_2"]);
    $this->assertEquals($plugin->arg1, 'foo');
    $this->assertEquals($plugin->arg2, NULL);
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins["test_plugin_2"]->getPluginDefinition());
    $plugin = $factory->createInstance($this->definitions[2], $arg_1, $arg_2);
    $this->assertEquals($plugin, $this->plugins["test_plugin_3"]);
    $this->assertEquals($plugin->arg1, 'foo');
    $this->assertEquals($plugin->arg2, 'bar');
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins["test_plugin_3"]->getPluginDefinition());
  }

  /**
   * @covers \EclipseGc\Plugin\Dictionary\PluginDictionaryInterface::createInstance
   */
  public function testPluginDictionaryFactory() {
    /** @var \EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary $dictionary */
    $dictionary = $this->getMockForAbstractClass('\EclipseGc\Plugin\Test\Utility\AbstractPluginDictionary');
    $dictionary->setDiscovery(new PluginDiscovery($this->definition_data));
    $dictionary->setFactoryClass('\EclipseGc\Plugin\Test\Factory\TestPluginFactory');
    $dictionary->setFactoryResolver(new TestFactoryResolver());
    $plugin = $dictionary->createInstance('plugin_definition_1');
    $this->assertEquals($plugin, $this->plugins['test_plugin_1']);
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins['test_plugin_1']->getPluginDefinition());
    $this->assertEquals($plugin->arg1, NULL);
    $this->assertEquals($plugin->arg2, NULL);
    $plugin = $dictionary->createInstance('plugin_definition_2', 'foo');
    $this->assertEquals($plugin, $this->plugins['test_plugin_2']);
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins['test_plugin_2']->getPluginDefinition());
    $this->assertEquals($plugin->arg1, $this->plugins['test_plugin_2']->arg1);
    $this->assertEquals($plugin->arg2, NULL);
    $plugin = $dictionary->createInstance('plugin_definition_3', 'foo', 'bar');
    $this->assertEquals($plugin, $this->plugins['test_plugin_3']);
    $this->assertEquals($plugin->getPluginDefinition(), $this->plugins['test_plugin_3']->getPluginDefinition());
    $this->assertEquals($plugin->arg1, $this->plugins['test_plugin_3']->arg1);
    $this->assertEquals($plugin->arg2, $this->plugins['test_plugin_3']->arg2);
  }
}