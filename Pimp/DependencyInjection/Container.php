<?php

namespace Pimp\DependencyInjection;

/**
 * Our application service and configuration manager
 */
class Container {
    private $settings = array();
    private $services = array();

    /**
     * Sets the application's settings
     *
     * @param array $settings our application settings
     *
     * @return void
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Adds a service in the container
     *
     * @param string $name    the service's name that will be used by the other Objects to retrieve it
     * @param Object $service the service Object
     *
     * @return void
     */
    public function addService($name, $service)
    {
        $this->services[$name] = $service;
    }

    /**
     * Gets a service from the container
     *
     * @param string $name the service's name that we want to retrieve
     *
     * @throws \Exception
     *
     * @return Object the requested service
     */
    public function get($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }

        throw new \Exception($name . ' service not found');
    }

    /**
     * Gets a specified setting from the container
     *
     * @param string $name the setting's name that we want to retrieve
     *
     * @return mixed the setting element requested
     */
    public function getSetting($name)
    {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }

        return null;
    }
}
