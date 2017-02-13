# Plugins

[![Build Status](https://travis-ci.org/EclipseGc/Plugins.svg?branch=master)](https://travis-ci.org/EclipseGc/Plugins)
[![Code Climate](https://codeclimate.com/github/EclipseGc/Plugins/badges/gpa.svg)](https://codeclimate.com/github/EclipseGc/Plugins)
[![Test Coverage](https://codeclimate.com/github/EclipseGc/Plugins/badges/coverage.svg)](https://codeclimate.com/github/EclipseGc/Plugins/coverage)

## What is Plugins?

This library provides a set of tools designed to:
* Ease discovery of "like" objects
* Assembly of those objects into a common dictionary
* Facilitate common factory patterns for objects in the dictionary

The plugins library is designed to provide a simple pattern for allowing developers to create their own pluggable systems. This can be as simple as choosing a single plugin from a library during your run time, or executing multiple plugins from a library to do things like determine visibility, or build components of a page.

## History & Mission

The plugin system was originally developed in conjunction with the early development of Drupal 8 back in 2011-2012. Despite the fact that Drupal 8 was released in late 2015, the plugin system was developed against for multiple years before Drupal 8's release, and this code is an attempt at providing the Plugin system to the PHP community at large while simultaneously fixing numerous things that were lack-luster in the Drupal 8 version. It is our hope that this effort might ultimately be folded back into a future release of Drupal, and in the mean time might benefit from wider use in the PHP community.

## Usage

Each plugin dictionary must documents its:
* Plugin Type
* Discovery
* Factory Class
* Factory Resolver

These properties work together to define individual plugin dictionaries. The easiest entry into this is to build your own Dictionary class and utilize the provided PluginDictionaryTrait. A simple example might look like this:

```php
use \EclipseGc\Plugin\Dictionary\PluginDictionaryInterface;
use \EclipseGc\Plugin\Traits\PluginDictionaryTrait;

class MyDictionary implements PluginDictionaryInterface {
  use PluginDictionaryTrait;

  public function __construct(\Traversable $namespaces) {
    $this->discovery = new SomeDiscoveryClass();
    $this->factoryResolver = new SomeFactoryResolver();
    $this->factoryClass = 'My\Default\Factory';
    $this->pluginType = 'myType';
  }

}
```

## Plugin Type

The plugin type is a simple string just for documentation purposes. It allows for the developer to ask a dictionary class what plugin type it is working with.

## Understanding Discovery

Discovery is one of the most fundamental aspects of the Plugin system. Building classes that implement an interface is all well and good, but they don't matter if your application cannot find and execute them. The plugin system operates primarily as a tool for finding classes of "like" interface and making them available for execution. it does this by:

* Exposing and documenting classes intended for use within a swappable subsystem
* Providing pattern(s) by which classes meant to be used within a subsystem can be logically found.
* Providing mechanisms for instantiating these classes.
 
The most critical element of this process is the pattern(s) used for logically locating classes of the same interface. This entire system is completely pluggable, but for the sake of simplicity, you can think of discovery as being any sort of documentation that a centralized tool can find, and from which it can subsequently load one of those documented classes. As an example, you could imagine a magic named PHP callable that returns an array of plugin definitions or YAML which can be interpretted into plugin definitions. One such discovery solution already exists which leverages Doctrine's class [Annotations](https://github.com/EclipseGc/PluginsAnnotation).

Discovery is designed to give developers a self-documenting mechanism for finding new plugins across all available namespaces. Using the annotations example above, to be found, a new plugin must exist in an expected directory structure, implement a particular interface and be annotated with the expected annotation class. You can read more about that specific discovery mechanism on its github page.

To perform these sorts of discovery calls, the plugin system will need every namespace and its corresponding directory. For Composer based autoloading, the plugin system provides a static method which can already perform the necessary operation. Just pass the autoloader to the Namespaces::extractNamespaces() method. The resulting Traversable is what you see dependency injected in the code documentation above.

## The Factory Class

The factory class documented in the plugin dictionary is a fallback factory designed to instantiate any plugin. This means that the most basic expectations of the plugin type should be encapsulated in the expectations of the default factory class.

## The Factory Resolver

The factory resolver's job is to instantiate factory classes (including the default factory) as necessary. Each plugin could have radically different needs when being instantiated, so the resolver allows individual plugins to document their own factory in case they have special needs when being instantiated.

The factory resolver is designed to reduce dependency injection problems. Allowing single-use factory classes to be paired with individual plugins prevents tightly coupling a plugin class to a set of dependencies. The factory used is annotated and annotations can be changed during runtime or before being cached. Static factory methods (the mechanism Drupal 8 uses for this basic problem) cannot.

If you are using a dependency injection container or similar inversion of control mechanisms, it is likely that your factory resolver(s) may end up as services there with the entire container passed to them. This gives them the ability to satisfy any plugin's dependencies when instantiating their factory. In Drupal 8 terms, this plugin system essentially moves the static factory methods off the plugin classes themselves and allows that same basic code-flow to happen on customized factory classes to prevent tightly coupling the plugin to the services.
