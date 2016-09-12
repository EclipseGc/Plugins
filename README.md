# Plugins

[![Build Status](https://travis-ci.org/EclipseGc/Plugins.svg?branch=master)](https://travis-ci.org/EclipseGc/Plugins)
[![Code Climate](https://codeclimate.com/github/EclipseGc/Plugins/badges/gpa.svg)](https://codeclimate.com/github/EclipseGc/Plugins)
[![Test Coverage](https://codeclimate.com/github/EclipseGc/Plugins/badges/coverage.svg)](https://codeclimate.com/github/EclipseGc/Plugins/coverage)

## What is Plugins?

This library provides a set of tools designed to:
* Ease discovery of "like" objects
* Assembly of those objects into a common dictionary
* Facilitate common factory patterns for objects in the dictionary

The plugins library is designed to provide a simple patterns for allowing developers to create their own pluggable systems. This can be as simple as choosing a single plugin from a library during your run time, or executing multiple plugins from a library to do things like determine visibility, or build components of a page.

## History & Mission

The plugin system was originally developed in conjunction with the early development of Drupal 8 back in 2011-2012. Despite the fact that Drupal 8 was released in late 2015, the plugin system was developed against for multiple years before Drupal 8's release, and this code is an attempt at providing the Plugin system to the PHP community at large while simultaneously fixing numerous things that were lack-luster in the Drupal 8 version. It is our hope that this effort might ultimately be folded back into a future release of Drupal, and in the mean time might benefit from wider use in the PHP community.

## Usage

Each plugin system documents its:
* Type
* Discovery
* Mutators
* Factory Class
* Factory Resolver

These 5 things work together to define individual plugin use cases. The easiest entry into this is to build your own Dictionary class and utilize the provided PluginDictionaryTrait. A simple example might look like this:

```php
use \EclipseGc\Plugin\Dictionary\PluginDictionaryInterface;
use \EclipseGc\Plugin\Traits\PluginDictionaryTrait;

class MyDictionary implements PluginDictionaryInterface {
  use PluginDictionaryTrait;
  
  protected $plugin_type = 'myType';
  
  protected $discovery = new SomeDiscoveryClass();
  
  protected $factory_class = 'My\Default\Factory';
  
  protected $factoryResolver = new SomeFactoryResolver();
  
}
```

## Understanding Discovery

Discovery is one of the most fundamental aspects of the Plugin system. Building classes that implement an interface is all well and good, but they don't matter if your application cannot find and execute them. Having an interface means that the logic executed is swappable. Many different system has mechanisms for doing this, but the Plugin system specializes in:

* Exposing and documenting classes intended for use within a swappable subsystem
* Providing a pattern by which classes meant to be used within a subsystem can be logically found.
* Providing mechanisms for instantiating these classes.
 
The most critical element of this process is the pattern(s) used for logically locating classes of the same interface. This entire system is completely pluggable, but for the sake of simplicity, you can think of discovery as being any sort of documentation that a centralized tool can find, and from which it can subsequently load one of those documented classes. As an example, you could imagine a magic named PHP callable that returns an array of plugin definitions or YAML which can be interpretted into plugin definitions. One such discovery solution already exists which leverages class [Annotations](https://github.com/EclipseGc/PluginsAnnotation).
