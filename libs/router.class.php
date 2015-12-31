<?php

class Router {

  static private $_instance = null;
  static private $route = 'index';

  /**
   * ��������� XSS ���������� ��� ��� ���������������� ������.
   * ��������� ��� ���������� ��������� � ������ queryParams,
   * � ���������� ��������� �� ����� ����� ���������.
   * �������� ����� ���� � �������, �� $_SERVER['SCRIPT_NAME'],
   * ������� �� ������ ����������� ��� ������ ����������.
   * ��������� ����� ����� ������ ����� �� � ����� �����.
   */
  private function __construct() {
    
    if (get_magic_quotes_gpc()) {
      $_REQUEST = System::stripslashesArray($_REQUEST);
      $_POST = System::stripslashesArray($_POST);
      $_GET = System::stripslashesArray($_GET);
    }

    $_REQUEST = System::defenderXss($_REQUEST, $emulMgOff);
    $_POST = System::defenderXss($_POST, $emulMgOff);
    $_GET = System::defenderXss($_GET, $emulMgOff);
	
	$this->queryParams = $_REQUEST;
  }

  private function __clone() {
    
  }

  private function __wakeup() {
    
  }

  /**
   * ��������� ���������� �������� �� ������� $_GET.
   * @return object
   */
  public static function get($param) {
    return self::getQueryParametr($param);
  }

  /**
   * ���������� ���������� �������� �� $_POST �������.
   * @return string
   * @param string $param ���������� ��������.
   */
  public static function post($param) {
    return self::getQueryParametr($param);
  }
  
  /**
   * ��������� ������������ ��������� ������� ������.
   * @return object - ������ ������ URL.
   */
  static public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  /**
   * ���������� ����������� request ��������.
   * @return type
   */
  public static function getQueryParametr($param) {
    $params = self::getInstance()->queryParams;
    $res = !empty($params[$param]) ? $params[$param] : null;
    return $res;
  }

  /**
   * �������������� ������ ����� URL.
   * @return void
   */
  public static function init() {
    self::getInstance();
  }

  /**
   * ������������� �������� � ������ URL. ����� ������������ ��� ������ ����������.
   * @param string $param ������������ ���������.
   * $value string $param �������� ���������.
   */
  public static function setQueryParametr($param, $value) {
    self::getInstance()->queryParams[$param] = $value;
  }

}