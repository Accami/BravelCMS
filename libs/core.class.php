<?php

class Core {

  public function run() {
    $var['title'] = Controller::getInstance()->title;
    System::displayTemplate(true);
    return System::viewCompile('template.php');
  }

}

?>
