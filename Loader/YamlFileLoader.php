<?php

namespace App\Croknoks\IdenticonBundle\Loader;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Loader\FileLoader;

/**
 * YamlFileLoader loads Yaml routing files.
 */
class YamlFileLoader extends FileLoader
{
    /**
     * Loads a Yaml file.
     *
     * @param string $file A Yaml file path
     *
     * @return array
     *
     * @throws \InvalidArgumentException When config can't be parsed
     */
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);

        $config = Yaml::parse($path);

        // empty file
        if (null === $config) {
            $config = array();
        }

        // not an array
        if (!is_array($config)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $file));
        }

        return $config;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     *
     * @api
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION) && (!$type || 'yaml' === $type);
    }
}