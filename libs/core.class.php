<?php

class Core {

  private $controller;

  public function __construct() {
    $this->controller = Router::getController();
  }

  public function run() {

    include BASE."/controllers/".$this->controller.".php";
    $controller_name = $this->controller."_controller";
    $controller_obj = new $controller_name;
    include BASE."/templates/".System::getSetting('template')."/views/".$this->controller.".php";
    System::displayTemplate(true);
    return System::viewCompile('template.php');
  }

}

?>
