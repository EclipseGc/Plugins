<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Factory\FactoryResolverInterface.
 */

namespace EclipseGc\Plugin\Factory;

interface FactoryResolverInterface {

  /**
   * Resolves a factory class string into a FactoryInterface object.
   *
   * @param string $factoryClass
   *
   * @return FactoryInterface
   */
  public function getFactoryInstance(string $factoryClass) : FactoryInterface ;
}