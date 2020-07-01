<?php
namespace Stephane888\Authen\Config;

use ScssPhp\ScssPhp\Compiler;

class Init {

  static public function init()
  {
    self::wbu_session_start();
    self::wbu_init();
  }

  static public function wbu_session_start()
  {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    //
    if (! session_id()) {
      @session_start();
    }
  }

  static public function wbu_init()
  {
    // echo '<pre>'; print_r($_SERVER); echo '</pre>';
    $c_dir = explode("/public/", __DIR__);
    // echo '<pre> c_dir'; print_r($c_dir); echo '</pre>';
    $public_dir = explode("/", $_SERVER["DOCUMENT_ROOT"]);
    $public_html = end($public_dir);
    $ROOT = explode($public_html, $c_dir[0]);
    if (isset($ROOT[1])) {
      $ROOT = $ROOT[1];
    } else {
      $ROOT = '';
    }
    $fullRoot = $_SERVER["DOCUMENT_ROOT"] . $ROOT;
    echo $ROOT;
    /**
     * root for folder, user by files ( css, js , img ...)
     *
     * @var string
     */
    define('ROOT_WBU', $ROOT);

    /**
     * defautl root for folder, user by php files
     *
     * @var string
     */
    define('FULLROOT_WBU', $fullRoot);

    date_default_timezone_set('Europe/Paris');
  }

  /**
   * load scss csss
   */
  static public function _load_scss()
  {
    // convert bootstrap scss to css
    $parser = new Compiler();

    // build custom style
    if ($_GET['build'] == 'style' || $_GET['build'] == 'scss') {
      $result = $parser->compile('@import "' . FULLROOT_WBU . '/AppAuth/Ressources/scss/style.scss";');
      $filename = FULLROOT_WBU . '/AppAuth/Ressources/css/style.css';
      $monfichier = fopen($filename, 'w+');
      fputs($monfichier, $result);
      fclose($monfichier);
    }
  }
}