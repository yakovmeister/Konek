<?php

	/**
	 * Check if array is associative
	 *
	 * @param $array
	 * @return bool
		 */
	if(! function_exists('is_assoc_array'))
	{
		function is_assoc_array($array)
		{
			return array_keys($array) !== range(0, count($array) - 1);
		}
	}

	/**
	 * Convert array to string as listed items
	 *
	 * @param $columns
	 * @return string
	 */
	if(! function_exists('chain')) 
	{
		function chain($columns = ['*'])
		{
			if(!is_array($columns)) return $columns;

			return implode(", ", $columns);
		}
	}

	/**
	 * Convert array to string as listed items and wrap them with quote
	 *
	 * @param $values
	 * @return string
	 */
	if(! function_exists('chainWrap'))
	{
		function chainWrap($values)
		{
			$values = is_array($values) ? $values : func_get_args();

			return implode(", ", wrapArray($values));
		}
	}

	/**
	 * Wrap string with quote
	 *
	 * @param $value
	 * @return string
	 */
	if(! function_exists('wrap'))
	{
		function wrap($value)
		{
	        if ($value === '*') {
	            return $value;
	        }
			
			if(!is_numeric($value)) return '"'.str_replace('"', '""', $value).'"';

			return $value;
		}
	}
	
	/**
	 * wrap for array
	 *
	 * @param $array
	 * @return string
	 */	
	if(!function_exists('wrapArray'))
	{
		function wrapArray($array)
		{
			if(!is_array($array)) return wrap($array);
			
			$cache = [];

			foreach ($array as $value) {

				$cache[] = wrap($value);
				
			}

			return $cache;
		}
	}

	/**
	 *
	 *
	 *
	 */
	if(! function_exists(''))
	{
		
	}
	
