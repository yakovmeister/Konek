<?php namespace Yakovmeister\Konek;

use \Closure;
/**
 *	@author Jacob Baring (Yakovmeister)
 *			http://www.facebook.com/rwx777kid.ph
 *	@version 1.0.0
 */

class KonekException extends \Exception 
{

	public function __construct($message, $code, Exception $previous = null)
	{
		parent::__construct($message,$code, $previous);
	}


	public function __toString()
	{
		return __CLASS__."[{$this->code}]: {$this->message}";
	}

	public function __toArray()
	{
		return [
			'class'		=> __CLASS__,
			'code'		=> $this->code,
			'message'	=> $this->message
		];
	}

}