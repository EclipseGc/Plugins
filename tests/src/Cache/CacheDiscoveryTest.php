<?php

namespace EclipseGc\Plugin\Test\Cache;

use EclipseGc\Plugin\Cache\PHPFileCache;
use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\Discovery\PluginDiscoveryInterface;
use EclipseGc\Plugin\Discovery\StaticPluginDictionary;
use EclipseGc\Plugin\PluginDefinitionInterface;

class CacheDiscoveryTest extends \PHPUnit_Framework_TestCase {


  public function testPhpFileCache() {
    $cache = new PHPFileCache('/tmp/foo.php');

    $discovery = new class() implements PluginDiscoveryInterface {
      public function findPluginImplementations(PluginDefinitionInterface ...$definitions): PluginDefinitionSet {
        return new PluginDefinitionSet(...$definitions);
      }
    };

    $dictionary = new class($cache, $discovery) extends StaticPluginDictionary {
      public function __construct($cache, $discovery) {
        $this->cache = $cache;
        $this->discovery = $discovery;
      }
    };
    $definition1 = $this->getPluginDefinition('foo', 'bar');
    $dictionary->addPluginDefinition($definition1);
    $definition2 = $this->getPluginDefinition('bar', 'baz');
    $dictionary->addPluginDefinition($definition2);
    $dictionary->getDefinitions();
    $expected_content = "<?php

use EclipseGc\\Plugin\\Discovery\\PluginDefinitionSet;
use EclipseGc\\Plugin\\PluginDefinitionInterface;
use EclipseGc\\Plugin\\Traits\\PluginDefinitionTrait;

\$plugins = [
  new class('Foo', '', ['pluginId' => 'foo','foo' => 'foo','bar' => 'bar',]) implements PluginDefinitionInterface {
    use PluginDefinitionTrait;

    public function __construct(string \$class, string \$factory, array \$values) {
      \$this->class = \$class;
      \$this->factory = \$factory;
      foreach (\$values as \$key => \$value) {
        \$this->\$key = \$value;
      }
    }
  },
  new class('Foo', '', ['pluginId' => 'bar','foo' => 'bar','bar' => 'baz',]) implements PluginDefinitionInterface {
    use PluginDefinitionTrait;

    public function __construct(string \$class, string \$factory, array \$values) {
      \$this->class = \$class;
      \$this->factory = \$factory;
      foreach (\$values as \$key => \$value) {
        \$this->\$key = \$value;
      }
    }
  },
];
return new PluginDefinitionSet(...\$plugins);";
    $this->assertEquals($expected_content, file_get_contents('/tmp/foo.php'));
    $cache->invalidate();
    $this->assertTrue(!file_exists('/tmp/foo.php'));
  }

  protected function getPluginDefinition($foo, $bar) {
    /** @var PluginDefinitionInterface $definition */
    $definition = $this->prophesize(PluginDefinitionInterface::class);
    $definition->getClass()->willReturn('Foo');
    $definition->getFactory()->willReturn('');
    $definition->getPluginId()->willReturn($foo);
    $definition->getProperties()->willReturn(['pluginId' => $foo, 'foo' => $foo, 'bar' => $bar]);
    return $definition->reveal();
  }
}
