<?php

namespace Yakovmeister\Konek\Configure;

use Symfony\Component\Finder\Finder;

class Config
{
	/**
	 * [config instance in static form... for singleton use]
	 * @var [type]
	 */
	protected static $__instance;
	/**
	 * Configuration directory
	 * @access protected
	 */
	protected $dir;

	/**
	 * Finder instance
	 * @var Object Symfony\Component\Finder\Finder
	 */
	protected $finder;

	/**
	 * loaded configuration
	 */
	protected $loaded = [];

	/**
	 * last called configuration
	 * @var string
	 */
	protected $lastUsedConfig;

	public function __construct(Finder $finder) 
	{ 
		$this->dir = dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR."config";

		$this->finder = $finder;

		$this->finder->files()->ignoreUnreadableDirs()->in($this->dir);
	}

	/**
	 * Change configuration directory
	 * @param  string $directory path to directory you want to replace
	 * @return [type]            [description]
	 */
	public function changeDirectory($directory)
	{
		$this->dir = $directory;

		$this->finder->files()->ignoreUnreadableDirs()->in($this->dir);

		return $this;
	}

	/**
	 * Get configuration based on the file name from configuration directory
	 * @param  string $filename file name of the configuration you're trying to load
	 * @return array           [description]
	 */
	public function load($filename)
	{
		if(count($this->finder->name("{$filename}.php")) <= 0) throw new \Exception("File you are trying to load does not exists.");

		$this->lastUsedConfig = $filename;

		$this->loaded[$filename] = @require("{$this->dir}/{$filename}.php");

		return $this;
	}

	/**
	 * get configuration value, if param is not set, will return the array from last used config
	 * @param  string $configuration = null configuration string name
	 * @return mixed
	 */
	public function use($configuration = null)
	{
		return is_null($configuration)
			? $this->loaded[$this->lastUsedConfig]
			: $this->loaded[$this->lastUsedConfig][$configuration];
	}

	/**
	 * create config instance as static
	 * @return $this
	 */
	public static function instance()
	{
		return isset(static::$__instance) 
			? static::$__instance 
			: new Config(new Finder);
	}
}