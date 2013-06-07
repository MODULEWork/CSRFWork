<?php
namespace MODULEWork;
/*===================================================
*
*
*
* Name: CSRFWork
* Version: 1.0
* License: Apache 2.0
* Author: Christian Gärtner
* Author URL: christiangaertner.github.io
* Project URL: https://github.com/ChristianGaertner/MODULEWork
* Description: Simple CSRF protection class
*
*
*
===================================================*/


/**
* CSRF
* @author ChristianGaertner <christiangaertner.film@googlemail.com>
*/
class CSRF
{

	private static $salt;
	private static $token;

	/**
	 * Default init method for MODULEWork classes
	 * @param  string $c_salt Use a custom salt for the tokens
	 * @return void
	 */
	public static function init($c_salt = null)
	{
		if (isset($_SESSION[__NAMESPACE__]['module_data']['csrf']['salt'])) {
			static::$salt = $_SESSION[__NAMESPACE__]['module_data']['csrf']['salt'];
			return;
		} else {
			if ($c_salt != null) {
				static::$salt = $c_salt;
			} else {
				static::$salt = (time() . sha1(static::random_string()));
			}

			$_SESSION[__NAMESPACE__]['module_data']['csrf']['salt'] = static::$salt;
		}

		static::generate();		

	}

	/**
	 * Returns the CSRF-protection-token
	 * @return string The token
	 */
	public static function token()
	{
		return static::$token;
	}

	/**
	 * Checks whether a string matches the token
	 * @param  string $token	The token to check
	 * @return boolean			returns true when the strings match  
	 */
	public static function check($token)
	{
		if ($token == $_SESSION[__NAMESPACE__]['module_data']['csrf']['token']) {
			$_SESSION[__NAMESPACE__]['module_data']['csrf']['token'] = static::$token;
			return true;
		} else {
			$_SESSION[__NAMESPACE__]['module_data']['csrf']['token'] = static::$token;
			return false;
		}
	}

	/**
	 * Generates the token
	 * @return void
	 */
	protected static function generate()
	{
		$parts[] = static::generateExtras();
		$parts[] = hash('md4', sha1(static::$salt . static::random_string()));
		$org_token = implode(static::random_string(), $parts);

		static::$token = base64_encode(md5($org_token));
	}

	/**
	 * Generate special stuff based on $_SERVER vars
	 * @return string the extras
	 */
	protected static function generateExtras()
	{
		return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
	}

	/**
	 * Generate a random string
	 * @param  integer $length The desired lenght, DEFAULT: 30
	 * @return string          The random string
	 */
	protected static function random_string($length = 30)
	{
		$char_base = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!§$%&/()=?";
		$random_string = '';
		
		for ($i=0; $i < $length; $i++) { 
			$random_string .= $char_base{rand(0, strlen($char_base))};
		}

		return $random_string;
	}
}