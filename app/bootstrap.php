<?php
  // Load Config
  require_once 'config/config.php';

  //helpers

  require 'helpers/url_helper.php';

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });
  
  // // Autoload Classes
  // spl_autoload_register(function($className){
  //   require_once 'classes/' . $className . '.php';
  // });
  
