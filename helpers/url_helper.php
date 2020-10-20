<?php
class Url {	
	public static function redirect($url = null, $fullpath = false) {
		include 'config/config.php';
		if ($url == 'home') {
			$url = $domain;
		} else {
			$url = $domain . $url;
		}
		// header('Location: '.$url );
		?>
		<script>window.location="<?=$url?>";</script>
		<?php
		exit;
	}
	
	public static function getPath($custom = false) {
		include 'config/config.php';
		$path =  $_SERVER['DOCUMENT_ROOT'];
		if ($env == "local") {
			$path = exec("pwd");
		}
		if ($custom == true) {
			//return $_SERVER['DOCUMENT_ROOT'] . '/' . $custom . '/';
			return $path. '/' . $custom . '/';
		} else {
			//return $_SERVER['DOCUMENT_ROOT'] . '/';
			return $path. '/';
		}
	}
	
	public static function getRelativePath($custom = false) {
		if ($custom == true) {
			return $custom . '/';
		} else {
			return '';
		}
	}
	
	public static function getStaticPath($custom = false) {
		include 'config/config.php';
		return $domain . $custom;
	}

	public static function getDomain() {
		include 'config/config.php';
		return $domain;
  }
  
  public static function getImageDomain() {
		include 'config/config.php';
		return $imageDomain;
	}
	
	public static function autoLink($text, $custom = null) {
		$regex = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';
		if ($custom === null) {
			$replace = '<a href="http$2://$4">$1$2$3$4</a>';
		} else {
			$replace = '<a href="http$2://$4">'.$custom.'</a>';
		}
		return preg_replace($regex, $replace, $text);
	}
	
	public static function generateSafeSlug($slug) {
		setlocale(LC_ALL, 'en_US.utf8');
		$slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));
		$slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');
		$pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
		$slug = preg_replace($pattern, '$1', $slug);
		$slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');
		$pattern = '~[^0-9a-z]+~i';
		$slug = preg_replace($pattern, '-', $slug);
		return strtolower(trim($slug, '-'));
	}

	public static function SetLink($path) {
    if (Session::get("lang") == "tc") {
      return Url::getDomain() . ($path != '' ? $path . "/" : "");
    }
    return Url::getDomain() . 'en/' . ($path != '' ? $path . "/" : "");
  }
	
	public static function previous() {
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	
	public static function segments() {
		return explode('/', $_SERVER['REQUEST_URI']);
	}
	
	public static function getSegment($segments, $id) {
		if (array_key_exists($id, $segments)) {
			return $segments[$id];
		}
	}
	
	public static function lastSegment($segments) {
		return end($segments);
	}
	
	public static function firstSegment($segments) {
		return $segments[0];
	}
	
	public static function vendorFolderPath() {
		return Url::getPath("vendor");
	}

	public static function helpersFolderPath() {
		return Url::getPath("helpers");
	}

	public static function modelsFolderPath() {
		return Url::getPath("models");
	}

	public static function configFolderPath() {
		return Url::getPath("config");
	}	
	
	public static function viewsFolderPath() {
		return Url::getPath("views");
	}
	
	public static function controllersFolderPath() {
		return Url::getPath("controllers");
	}
	
	public static function cssFolderPath() {
		return Url::getStaticPath("dist/css/");
	}

	public static function distFolderPath() {
		return Url::getStaticPath("dist/");
	}

	public static function pluginFolderPath() {
		return Url::getStaticPath("dist/plugins/");
	}
	
	public static function jsFolderPath() {
		return Url::getStaticPath('dist/js/');
	}

	public static function assetFolderPath() {
		return Url::getStaticPath('assets/');
	}
	
	public static function fontsFolderPath($campaign = false, $customPath) {
		if($campaign) {
			return Url::getStaticPath($customPath . "/fonts", true);
		} else {
			return Url::getStaticPath("fonts");
		}
	}
	
	public static function imagesFolderPath($campaign = false, $customPath) {
		if($campaign) {
			return Url::getStaticPath($customPath . "/images", true);
		} else {
			return Url::getStaticPath("images");
		}
	}
	
	public static function getProtocol() {
		return isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? "https:" : "http:";
	}

}

?>