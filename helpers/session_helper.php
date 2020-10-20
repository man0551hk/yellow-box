<?php
class Session {
	public static function set($key, $val) {
		$_SESSION["$key"] = $val;
  }
    
	public static function get($key){
		if(isset($_SESSION["$key"]) && !empty($_SESSION["$key"])) {
			return $_SESSION["$key"];
		} else {
			return "";
		}
	}
	public static function getValue($key, $index){
		if(isset($_SESSION["$key"]) && !empty($_SESSION["$key"])) {
			if(is_array($_SESSION["$key"])) {
				return $_SESSION["$key"]["$index"];
			} else {
				return $_SESSION["$key"];
			}
		} else {
			return "";
		}
	}
	public static function unSetSess($key) {
		unset($_SESSION["$key"]);
	}
	public static function destroy() {
		session_destroy();
	}

	public static function SetUserSession($userId, $name, $profilePic, $position) {
		self::set("userId", $userId);
		self::set("name", $name);
		self::set("profilePic", $profilePic);
		self::set("position", $position);
	}
}
?>