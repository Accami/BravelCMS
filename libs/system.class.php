<?php

class System {

  static private $_instance = null;
  private $_registry = array();

  /**
   * ����������� ��������� ��������� ��������
   * - ����� ������
   * - ��������� ����������������� �������
   * - ������������� ���������� ��� ������ � �����������
   */
  private function __construct() {

    // ����� ������
    session_start();
	
  }

  private function __clone() {
    
  }

  private function __wakeup() {
    
  }

  /**
   * �������� ��� �����, ������ ������� ���������� ���������� �������.
   *
   * @param array ������ � ������� ���� ������� �����.
   * @return array $arr ��� �� ������ �� ��� ������.
   */
  public static function stripslashesArray($array) {
    if (is_array($array))
      return array_map(array(__CLASS__, 'stripslashesArray'), $array);
    else
      return stripslashes($array);
  }

  /**
   * ������ �� XSS ���� ���������� ������ ����������.
   *
   * @param array $arr ���������, ������� ���� ��������.
   * @return array $arr ���� ���������, �� ��� ����������.
   */
  public static function defenderXss($arr, $emulMgOff = false) {


    $filter = array('<', '>');

    foreach ($arr as $num => $xss) {
      if (is_array($xss)) {
        $arr[$num] = self::defenderXss($xss, $emulMgOff);
      } else {
        if ($emulMgOff) {
          $xss = stripslashes($xss);
        }
        $xss = htmlspecialchars_decode($xss);
        $xss = str_replace('"', '&quot;', $xss);
        $arr[$num] = str_replace($filter, array('&lt;', '&gt;'), trim($xss));
      }
    }

    return $arr;
  }

  /**
   * ��������������� ������ �������� ������ �� xss ���� - defenderXss()
   *
   * @param array $string �������� ������.
   */
  public static function defenderXss_decode($string) {
    return str_replace(array('&lt;', '&gt;', '&quot;'), array('<', '>', '"'), trim($string));
  }

  /**
   * ���������� ���������� �� �������.
   * @param $key - ��� ���������.
   */
  static public function get($key) {
    return !empty(self::getInstance()->_registry[$key])?self::getInstance()->_registry[$key]:null;
  }
  
  /**
   * ������� ���������� � �������, � ����������� �������� �� ����� ����� ���������.
   * @param $key - ��� ���������.
   * @param $object - �������� ����������.
   */
  static public function set($key, $object) {
    self::getInstance()->_registry[$key] = $object;
  }

  /**
   * ��������� ������������ ��������� ������� ������.
   * @return object - ������ ������ MG.
   */
  static public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  /**
   * ������������� �������� ����� �� ������� settings � ��.
   * ���������� � ������ ��� ��������� �� �������,
   * � ����������� � ��� �������������� ������ �� ����� ����� ���������
   * @return void
   */
  public static function init() {
	self::getInstance();
  }

  /**
   * �������� �������� � ��������.
   * @param string $str ����������� ������.
   * @param string $mode ���� ��� ������ ������� / �� -.
   * @return string
   */
  public static function translitIt($str, $mode = 0) {
    $simb = '-';
    if ($mode == 1) {
      $simb = '/';
    }
    $tr = array(
      '�' => 'a',
      '�' => 'b',
      '�' => 'v',
      '�' => 'g',
      '�' => 'd',
      '�' => 'e',
      '�' => 'yo',
      '�' => 'j',
      '�' => 'z',
      '�' => 'i',
      '�' => 'y',
      '�' => 'k',
      '�' => 'l',
      '�' => 'm',
      '�' => 'n',
      '�' => 'o',
      '�' => 'p',
      '�' => 'r',
      '�' => 's',
      '�' => 't',
      '�' => 'u',
      '�' => 'f',
      '�' => 'h',
      '�' => 'ts',
      '�' => 'ch',
      '�' => 'sh',
      '�' => 'sch',
      '�' => '',
      '�' => 'y',
      '�' => '',
      '�' => 'e',
      '�' => 'yu',
      '�' => 'ya',
      '�' => 'a',
      '�' => 'b',
      '�' => 'v',
      '�' => 'g',
      '�' => 'd',
      '�' => 'e',
      '�' => 'yo',
      '�' => 'j',
      '�' => 'z',
      '�' => 'i',
      '�' => 'y',
      '�' => 'k',
      '�' => 'l',
      '�' => 'm',
      '�' => 'n',
      '�' => 'o',
      '�' => 'p',
      '�' => 'r',
      '�' => 's',
      '�' => 't',
      '�' => 'u',
      '�' => 'f',
      '�' => 'h',
      '�' => 'ts',
      '�' => 'ch',
      '�' => 'sh',
      '�' => 'sch',
      '�' => '',
      '�' => 'y',
      '�' => '',
      '�' => 'e',
      '�' => 'yu',
      '�' => 'ya',
      '/' => $simb,
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '0' => '0',
      '�' => 'i',
      '�' => 'i',
      '�' => 'e',
      '�' => 'g',
      '�' => 'i',
      '�' => 'i',
      '�' => 'e',
      '�' => 'g',
      ' ' => '-'
    );

    return strtr($str, $tr);
  }

  /**
   * �������������� �� ������ �������� �����.
   * @param string $location ������ �� ���������������� ��������.
   * @param string $redirect ��� ��������� 301, 302, � �.�.
   * @return void
   */
  public static function redirect($location, $redirect = '') {
    if ($redirect){
      header('HTTP/1.1 '.$redirect);
    }
    header('Location: '.SITE.$location);
    exit;
  }

  /**
   * ���������� ������������ ���������� ����������, � �������� ���������� �������� �������.
   * @return string - ������������ ����������.
   */
  function isMobileDevice() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $device['ipod'] = strpos($user_agent, "iPod");
    $device['iphone'] = strpos($user_agent, "iPhone");
    $device['android'] = strpos($user_agent, "Android");
    $device['symb'] = strpos($user_agent, "Symbian");
    $device['winphone'] = strpos($user_agent, "WindowsPhone");
    $device['wp7'] = strpos($user_agent, "WP7");
    $device['wp8'] = strpos($user_agent, "WP8");
    $device['operam'] = strpos($user_agent, "Opera M");
    $device['palm'] = strpos($user_agent, "webOS");
    $device['berry'] = strpos($user_agent, "BlackBerry");
    $device['mobile'] = strpos($user_agent, "Mobile");
    $device['htc'] = strpos($user_agent, "HTC_");
    $device['fennec'] = strpos($user_agent, "Fennec/");

    foreach ($device as $key => $isMobile) {
      if ($isMobile) {
        return $key;
      }
    }

    return false;
  }

}