<?php

class Rakuun_User_Callbacks {
	/**
	 * use for usual call_user_func behavior.
	 */
	const STYLE_USUAL = 1;
	/**
	 * use if class has to be created via method, like class::get()->callback.
	 */
	const STYLE_GET = 2;
	/**
	 * use if class has to be created via method with $user-param, like class::get($user)->callback.
	 */
	const STYLE_GET_USER = 3;
	
	private static $instance = null;
	private $user = null;
	
	private function __construct($user) {
		$this->user = $user;
	}
	
	public static function get(Rakuun_DB_User $user) {
		return self::$instance ? self::$instance : self::$instance = new self($user);
	}
	
	/**
	 * Adds a callback to specified user. If callback method returns true, callback
	 * will be deleted, otherwise nothing happens and method will be executed over and over again.
	 * @param $callback Array(Class, Method)
	 * @param $style see self::STYLE_*
	 */
	public function add(array $callback, $style = self::STYLE_USUAL) {
		foreach ($callback as $key => $value) {
			if (is_object($value)) 
				$callback[$key] = get_class($value);
		}
		$record = new DB_Record();
		$record->user = $this->user;
		$record->style = $style;
		$record->method = implode('_|_', $callback);
		Rakuun_DB_Containers::getUserCallbacksContainer()->save($record);
	}
	
	/**
	 * runs the callbacks defined for this user.
	 */
	public function run() {
		$callbacks = Rakuun_DB_Containers::getUserCallbacksContainer()->selectByUser($this->user);
		foreach ($callbacks as $callback) {
			$method = explode('_|_', $callback->method);
			switch ($callback->style) {
				case self::STYLE_USUAL:
					if (call_user_func($method))
						$this->delete($callback);
				break;
				case self::STYLE_GET:
					$instance = call_user_func(array($method[0], 'get'));
					if ($instance->{$method[1]}())
						$this->delete($callback);
				break;
				case self::STYLE_GET_USER:
					$instance = call_user_func(array($method[0], 'get'), $this->user);
					if ($instance->{$method[1]}())
						$this->delete($callback);
				break;
				default:
					throw new Core_Exception('unknown callback style: '.$callback->style);
			}
		}
	}
	
	private function delete($callback) {
		Rakuun_DB_Containers::getUserCallbacksContainer()->delete($callback);
	}
}
?>