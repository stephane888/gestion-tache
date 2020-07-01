<?php
require_once getenv("DOCUMENT_ROOT") . '/vendor/autoload.php';
use Stephane888\Authen\Config\Init;

/**
 * initilisation.
 */
Init::init();
if (! empty($_SERVER['HTTP_X_CSRF_TOKEN'])) {
  /**
   * Contenu ajax.
   */
  include $_SERVER['DOCUMENT_ROOT'] . '/AppAuth/Ressources/Ajax.php';
} else {
  /**
   * Contenu html
   */
  include $_SERVER['DOCUMENT_ROOT'] . '/AppAuth/Ressources/DefaultPage.php';
}

//phpinfo();

