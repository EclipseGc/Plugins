<?php

namespace EclipseGc\Plugin\Traits;

trait PluginDefinitionTrait {

  /**
   * The string identifier of the plugin.
   *
   * @var string
   */
  protected $pluginId;

  /**
   * The class this plugin will instantiate.
   *
   * @var string
   */
  protected $class;

  /**
   * The optional factory to instantiate this plugin.
   *
   * @var string
   */
  protected $factory = '';

  /**
   * {@inheritdoc}
   */
  public function getProperties() : array {
    $properties = get_object_vars($this);
    unset($properties['value']);
    unset($properties['class']);
    unset($properties['factory']);
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getProperty($name) {
    $properties = $this->getProperties();
    if (array_key_exists($name, $properties)) {
      return $this->$name;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginId() : string {
    return $this->pluginId;
  }

  /**
   * {@inheritdoc}
   */
  public function getClass() : string {
    return $this->class;
  }

  /**
   * {@inheritdoc}
   */
  public function getFactory() : string {
    return $this->factory;
  }

}
