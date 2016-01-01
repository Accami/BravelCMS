<?php

class System {

  static private $_instance = null;
  private $_registry = array();

  /**
   * Конструктор выполняет следующие действия
   * - Старт сессии
   * - Включение пользовательского шаблона
   * - инициализация библиотеки для работы с категориями
   */
  private function __construct() {

    // Старт сессии
    session_start();

  }

  private function __clone() {

  }

  private function __wakeup() {

  }

  /**
   * Вырезает все слеши, аналог функции отключения магических кавычек.
   *
   * @param array массив в котором надо удалить слеши.
   * @return array $arr тот же массив но без слешей.
   */
  public static function stripslashesArray($array) {
    if (is_array($array))
      return array_map(array(__CLASS__, 'stripslashesArray'), $array);
    else
      return stripslashes($array);
  }

  public static function getSetting($name) {
    return self::getInstance()->_registry['settings'][$name];
  }

  public static function viewCompile($include) {
    if ($_SESSION['disp_template']) {
      ob_start();
        include BASE."/templates/".self::getSetting('template')."/".$include;
        $content = ob_get_contents();
      ob_end_clean();
    }
    return $content;
  }

  /**
   * Защита от XSS атак полученный массив параметров.
   *
   * @param array $arr параметры, которые надо защитить.
   * @return array $arr теже параметры, но уже безопасные.
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
   * Восстанавливает строку пошедшую защиту от xss атак - defenderXss()
   *
   * @param array $string входящая строка.
   */
  public static function defenderXss_decode($string) {
    return str_replace(array('&lt;', '&gt;', '&quot;'), array('<', '>', '"'), trim($string));
  }

  /**
   * Возвращает переменную из реестра.
   * @param $key - имя перменной.
   */
  static public function get($key) {
    return !empty(self::getInstance()->_registry[$key])?self::getInstance()->_registry[$key]:null;
  }

  /**
   * Создает переменную в реестре, в последствии доступна из любой точки программы.
   * @param $key - имя перменной.
   * @param $object - значение переменной.
   */
  static public function set($key, $object) {
    self::getInstance()->_registry[$key] = $object;
  }

  /**
   * Возвращет единственный экземпляр данного класса.
   * @return object - объект класса MG.
   */
  static public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  /**
   * Инициализация настроек сайта из таблицы settings в БД.
   * Записывает в реестр все настройки из таблицы,
   * в последствии к ним осуществляется доступ из любой точки программы
   * @return void
   */
  public static function init() {
	  self::getInstance();

    // Подключаем кофигурацию бд
    global $db_config;

    // Записываем конфигурацию в реестр
    $query = DB::query("SELECT * FROM `".$db_config['prefix']."_settings`");
    if (DB::numRows($query) > 0) {
      $settings = Array();
      while ($array_settings = DB::fetchAssoc($query)) {
        $settings[$array_settings['name']] = $array_settings['value'];
      }
      self::set("settings", $settings);
    }

  }

  public static function displayTemplate($display) {
    $_SESSION['disp_template'] = $display;
  }

  /**
   * Перевдит кирилицу в латиницу.
   * @param string $str переводимая строка.
   * @param string $mode флаг для замены символа / на -.
   * @return string
   */
  public static function translitIt($str, $mode = 0) {
    $simb = '-';
    if ($mode == 1) {
      $simb = '/';
    }
    $tr = array(
      'А' => 'a',
      'Б' => 'b',
      'В' => 'v',
      'Г' => 'g',
      'Д' => 'd',
      'Е' => 'e',
      'Ё' => 'yo',
      'Ж' => 'j',
      'З' => 'z',
      'И' => 'i',
      'Й' => 'y',
      'К' => 'k',
      'Л' => 'l',
      'М' => 'm',
      'Н' => 'n',
      'О' => 'o',
      'П' => 'p',
      'Р' => 'r',
      'С' => 's',
      'Т' => 't',
      'У' => 'u',
      'Ф' => 'f',
      'Х' => 'h',
      'Ц' => 'ts',
      'Ч' => 'ch',
      'Ш' => 'sh',
      'Щ' => 'sch',
      'Ъ' => '',
      'Ы' => 'y',
      'Ь' => '',
      'Э' => 'e',
      'Ю' => 'yu',
      'Я' => 'ya',
      'а' => 'a',
      'б' => 'b',
      'в' => 'v',
      'г' => 'g',
      'д' => 'd',
      'е' => 'e',
      'ё' => 'yo',
      'ж' => 'j',
      'з' => 'z',
      'и' => 'i',
      'й' => 'y',
      'к' => 'k',
      'л' => 'l',
      'м' => 'm',
      'н' => 'n',
      'о' => 'o',
      'п' => 'p',
      'р' => 'r',
      'с' => 's',
      'т' => 't',
      'у' => 'u',
      'ф' => 'f',
      'х' => 'h',
      'ц' => 'ts',
      'ч' => 'ch',
      'ш' => 'sh',
      'щ' => 'sch',
      'ъ' => '',
      'ы' => 'y',
      'ь' => '',
      'э' => 'e',
      'ю' => 'yu',
      'я' => 'ya',
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
      'І' => 'i',
      'Ї' => 'i',
      'Є' => 'e',
      'Ґ' => 'g',
      'і' => 'i',
      'ї' => 'i',
      'є' => 'e',
      'ґ' => 'g',
      ' ' => '-'
    );

    return strtr($str, $tr);
  }

  /**
   * Перенаправляет на другую страницу сайта.
   * @param string $location ссылка на перенаправляемую страницу.
   * @param string $redirect тип редиректа 301, 302, и т.п.
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
   * Возвращает наименование мобильного устройства, с которого происходит просмотр страниц.
   * @return string - наименование устройства.
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
