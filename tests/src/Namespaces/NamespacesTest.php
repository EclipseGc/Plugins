<?php

namespace EclipseGc\Plugin\Test\Namespaces;

use Composer\Autoload\ClassLoader;
use EclipseGc\Plugin\Namespaces;

class NamespacesTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test the Namespaces class.
   */
  public function testNamespaces() {
    $classloader = $this->prophesize(ClassLoader::class);
    $classloader->getPrefixes()->willReturn([
      'Example\Namespace' => ['foo/bar'],
      'Example\Namespace2' => ['foo/bar2']
    ]);
    $classloader->getPrefixesPsr4()->willReturn([
      'Example\Namespace3' => ['foo/Example/Namespace3'],
      'Example\Namespace4' => ['foo/Example/Namespace4']
    ]);
    $namespaces = Namespaces::extractNamespaces($classloader->reveal());
    $expected = new \ArrayIterator(
      [
        'Example\Namespace' => 'foo/bar',
        'Example\Namespace2' => 'foo/bar2',
        'Example\Namespace3' => 'foo/Example/Namespace3',
        'Example\Namespace4' => 'foo/Example/Namespace4'
      ]
    );
    $this->assertEquals($expected, $namespaces);
  }

}
