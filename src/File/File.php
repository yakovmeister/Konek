<?php

namespace Yakovmeister\File;

class File 
{



	public function __construct()
	{

	}

	public function createDirectory($directory) { }

	public function deleteDirectory($directory) { }

	public function appendFile() { }

	public function directoryExist($directory)
	{
		return file_exists($directory);
	}

	public function rm() { }


}