<?php
namespace Tabster\Library;

class TwigHelper
{
	public function css($link)
	{
		return sprintf('<link rel="stylesheet" type="text/css" href="' . $link . '">');
	}
}