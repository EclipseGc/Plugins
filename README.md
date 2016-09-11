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
