<?php
if ( !defined('MCRYPT_RIJNDAEL_256') ) {
    define('MCRYPT_RIJNDAEL_256', 0);
}
if ( !defined('MCRYPT_MODE_CBC') ) {
    define('MCRYPT_MODE_CBC', 0);
}
class Encrypt {
  public static function encryptIt( $q ) {
      $cryptKey  = 'loichan2@19';
   
      $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
      $iv = openssl_random_pseudo_bytes($ivlen);
      $ciphertext_raw = openssl_encrypt($q, $cipher, $cryptKey, $options=OPENSSL_RAW_DATA, $iv);
      $hmac = hash_hmac('sha256', $ciphertext_raw, $cryptKey, $as_binary=true);
      $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
      return $ciphertext;
  }

  public static function decryptIt( $q ) {
    $cryptKey  = 'loichan2@19';
    $c = base64_decode($q);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $cryptKey, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $cryptKey, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
        return $original_plaintext;
    }
  }
}
?>