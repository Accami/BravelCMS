<?php

class Router {

  static private $_instance = null;

  /**
   * Исключает XSS уязвимости для вех пользовательских данных.
   * Сохраняет все переданные параметры в реестр queryParams,
   * в дальнейшем доступный из любой точки программы.
   * Выявляет часть пути в ссылках, по $_SERVER['SCRIPT_NAME'],
   * которая не должна учитываться при выборе контролера.
   * Актуально когда файлы движка лежат не в корне сайта.
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
   * Возвращет защищенный параметр из массива $_GET.
   * @return object
   */
  public static function get($param) {
    return self::getQueryParametr($param);
  }

  /**
   * Возвращает защищенный параметр из $_POST массива.
   * @return string
   * @param string $param запрошеный параметр.
   */
  public static function post($param) {
    return self::getQueryParametr($param);
  }

  /**
   * Возвращет единственный экземпляр данного класса.
   * @return object - объект класса URL.
   */
  static public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  public function getController() {
    $url = self::get('url');
    $url = explode('/', $url);
    if ($url[0] == "") {
      return 'index';
    }else {
      return $url[0];
    }
  }

  /**
   * Вовзращает запрошенный request параметр.
   * @return type
   */
  public static function getQueryParametr($param) {
    $params = self::getInstance()->queryParams;
    $res = !empty($params[$param]) ? $params[$param] : null;
    return $res;
  }

  /**
   * Инициализирует данный класс URL.
   * @return void
   */
  public static function init() {
    self::getInstance();
  }

  /**
   * Устанавливает параметр в реестр URL. Можно использовать как реестр переменных.
   * @param string $param наименование параметра.
   * $value string $param значение параметра.
   */
  public static function setQueryParametr($param, $value) {
    self::getInstance()->queryParams[$param] = $value;
  }

}
