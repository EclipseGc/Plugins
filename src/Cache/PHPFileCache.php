<?php

namespace EclipseGc\Plugin\Cache;

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;

/**
 * A plugin cache object which writes plugin definitions as anonymous classes.
 */
class PHPFileCache implements CacheInterface {

  /**
   * The file name.
   *
   * @var string
   */
  protected $fileName;

  /**
   * PHPFileCache constructor.
   *
   * @param string $file_name
   *   The name of the file in which the php will be written as cache.
   */
  public function __construct(string $file_name) {
    $this->fileName = $file_name;
  }

  /**
   * {@inheritdoc}
   */
  public function get() {
    if (file_exists($this->fileName)) {
      $set = include "{$this->fileName}";
      if ($set instanceof PluginDefinitionSet) {
        return $set;
      }
    }
    return new PluginDefinitionSet();
  }

  /**
   * {@inheritdoc}
   */
  public function set(PluginDefinitionSet $set) {
    $contents = <<<EOT
<?php

use EclipseGc\Plugin\Discovery\PluginDefinitionSet;
use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\Traits\PluginDefinitionTrait;

\$plugins = [

EOT;

    foreach ($set as $pluginDefinition) {
      $pluginDefinitionClass = get_class($pluginDefinition);
      $properties = '[';
      foreach ($pluginDefinition->getProperties() as $property_key => $property_value) {
        $properties .= "'$property_key' => '$property_value',";
      }
      if (strpos($pluginDefinitionClass, 'class@anonymous') !== 0) {
        $properties .= "'class' => '{$pluginDefinition->getClass()}',";
        $properties .= "'factory' => '{$pluginDefinition->getFactory()}'";
      }
      $properties .= ']';
      if (strpos($pluginDefinitionClass, 'class@anonymous') === 0) {
        $contents .= "  new class('{$pluginDefinition->getClass()}', '{$pluginDefinition->getFactory()}', $properties) implements PluginDefinitionInterface {
    use PluginDefinitionTrait;

    public function __construct(string \$class, string \$factory, array \$values) {
      \$this->class = \$class;
      \$this->factory = \$factory;
      foreach (\$values as \$key => \$value) {
        \$this->\$key = \$value;
      }
    }
  },\n";
      }
      else {
        $contents .= "  new $pluginDefinitionClass($properties);\n";
      }
    }
    $contents .= "];\n";
    $contents .= "return new PluginDefinitionSet(...\$plugins);";
    file_put_contents($this->fileName, $contents);
  }

  /**
   * {@inheritdoc}
   */
  public function invalidate() {
    if (file_exists($this->fileName)) {
      unlink($this->fileName);
    }
  }

}
