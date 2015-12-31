<?php

class Controller {

  static private $_instance = null;

  public $title = null;

  /**
   * Исключает XSS уязвимости для вех пользовательских данных.
   * Сохраняет все переданные параметры в реестр queryParams,
   * в дальнейшем доступный из любой точки программы.
   * Выявляет часть пути в ссылках, по $_SERVER['SCRIPT_NAME'],
   * которая не должна учитываться при выборе контролера.
   * Актуально когда файлы движка лежат не в корне сайта.
   */
  private function __construct() {

  }

  private function __clone() {

  }

  private function __wakeup() {

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

  /**
   * Инициализирует данный класс URL.
   * @return void
   */
  public static function init() {
    self::getInstance();
  }

}

?>
