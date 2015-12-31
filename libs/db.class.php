<?php

class DB {

  static private $_instance = null;
  static private $_debugMode = DEBUG_SQL;
  static private $log = null;
  static private $lastQuery = null;
  static public $connection = null;

  private function __construct() {
	global $db_config;
	$hostAndPort = explode(':',$db_config['host']);
	$port =  null;
	$host = $db_config['host'];
	if(!empty($hostAndPort[1])){
	  $port = $hostAndPort[1];
	  $host = $hostAndPort[0];
	}

    self::$connection = new mysqli($host, $db_config['user'], $db_config['password'], $db_config['db'], $port);

    if (self::$connection->connect_error) {
      die('Ошибка подключения ('.self::$connection->connect_errno.') '
        .self::$connection->connect_error);
    }
  }

  private function __clone() {

  }

  private function __wakeup() {

  }

  /**
   * Возвращает запись в виде массива.
   * @param obj $object
   * @return array
   */
  public static function fetchArray($object) {
    return @mysqli_fetch_array($object);
  }

  /**
   * Возвращает ряд результата запроса в качестве ассоциативного массива.
   * @param obj $object
   * @return array
   */
  public static function fetchAssoc($object) {
    return @mysqli_fetch_assoc($object);
  }

  /**
   * Возвращает запись в виде объекта.
   * @param obj $object
   * @return obj
   */
  public static function fetchObject($object) {
    return @mysqli_fetch_object($object);
  }

  /**
   * Возвращет единственный экземпляр данного класса.
   * @return object - объект класса DB
   */
  static public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  /**
   * Инициализирует единственный объект данного класса, устанавливает кодировку БД utf8.
   * @return object - объект класса DB
   */
  public static function init() {
    self::getInstance();
    DB::query('SET names utf8');
  }

  /**
   * Возвращает сгенерированный колонкой с AUTO_INCREMENT
   * последним запросом INSERT к серверу.
   * @return int
   */
  public static function insertId() {
    return @mysqli_insert_id(self::$connection);
  }

  /**
   * Возвращает количество рядов результата запроса.
   * @param obj $object
   * @return int
   */
  public static function numRows($object) {
    return @mysqli_num_rows($object);
  }

  /**
   * Выполняет запрос к БД.
   *
   * @param srting $sql запрос.( Может содержать дополнительные аргументы.)
   * @return obj|bool
   */
  public static function query($sql) {

    if (($num_args = func_num_args()) > 1) {
      $arg = func_get_args();
      unset($arg[0]);

      // Экранируем кавычки для всех входных параметров.
      foreach ($arg as $argument => $value) {
        $arg[$argument] = mysqli_real_escape_string(self::$connection, $value);
      }
      $sql = vsprintf($sql, $arg);
    }
    $obj = self::$_instance;

    if (isset(self::$connection)) {
      $obj->count_sql++;

      $startTimeSql = microtime(true);
      $result = mysqli_query(self::$connection, $sql)
        or die(self::console('<br/><span style="color:red">Ошибка в SQL запросе: '
          . '</span><span style="color:blue">'.$sql.'</span> <br/> '
          . '<span style="color:red">'.mysqli_error(self::$connection).'</span>'));

      $timeSql = microtime(true) - $startTimeSql;
      $obj->timeout += $timeSql;
      self::$lastQuery = $sql;

      return $result;
    }
    return false;
  }

  /**
   * Экранирует кавычки для части запроса.
   *
   * @param srting $noQuote - если true, то не будет выводить кавычки вокруг строки.
   * @param srting $string часть запроса.
   */
  public static function quote($string, $noQuote = false) {
    return (!$noQuote) ? "'".mysqli_real_escape_string(self::$connection, $string)."'" : mysqli_real_escape_string(self::$connection, $string);
  }

  /*
   * Выводит последний выполненный запрос.
   */
  public static function lastQuery() {
    return self::$lastQuery;
  }

}
