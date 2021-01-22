<?php

namespace Helpers;

class Auth
{
	static $loginUrl = '/index.php';

	static function check()
	{
		session_start();
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		} else {
			HTTP::redirect(static::$loginUrl);
		}
	}
}
