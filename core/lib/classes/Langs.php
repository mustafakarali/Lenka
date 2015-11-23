<?php
class Langs
{
	public static $get;
	public static $set;

	public static $deneme;
	
	public function __get($variable)
	{
		echo 'get';
	}
	public function __set($variable, $value)
	{
		echo 'set';
	}
	public function __construct()
	{
		echo 'const';
	}
}
