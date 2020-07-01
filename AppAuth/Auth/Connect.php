<?php
namespace Stephane888\Authen\Auth;

use Stephane888\Authen\Config\Config;
use Query\Repositories\Utility as UtilityDb;
use Query\WbuJsonDb;
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;
use Symfony\Component\HttpFoundation\Request;
use Query\Repositories\AjaxPrepareResponse;

class Connect {
  use PagePermission;

  /**
   * Connection BD users.
   *
   * @var object
   */
  private $BD;

  protected $config;

  protected $PDO;

  private $auth;

  public $request;

  public $key_page = 'page';

  public static $message = '';

  public static $alert_class = '';

  /**
   *
   * @param string $databaseType
   */
  function __construct($databaseType = 'App-Auth')
  {
    $configDataBase = Config::DataBaseAuth();
    $this->BD = new WbuJsonDb(UtilityDb::checkCredentiel($configDataBase, $databaseType));
    $this->PDO = $this->BD->getPDO();
    $this->config = new PHPAuthConfig($this->PDO);
    $this->request = Request::createFromGlobals();
    self::$message = '';
    self::$alert_class = '';
  }

  /**
   *
   * @param array $fields
   * @return array[]|number[]
   */
  function createCompte($fields)
  {
    $email = (isset($fields['email'])) ? $fields['email'] : null;
    $password = (isset($fields['password'])) ? $fields['password'] : null;
    $repeatpassword = (isset($fields['password_confirm'])) ? $fields['password_confirm'] : null;
    $result = $this->auth->register($email, $password, $repeatpassword);
    return $this->buildDataAjax($result);
  }

  /**
   * Obtient les paramettres de connections pour la bd utilisateur.
   *
   * @return object|\Query\WbuJsonDb
   */
  protected function getConnexion()
  {
    return $this->BD;
  }

  function setCredentiel($setting, $value)
  {
    $this->config->__set($setting, $value);
  }

  function IsLogin()
  {
    $result = [];
    $this->auth = new PHPAuth($this->PDO, $this->config, "fr_FR");
    $status = $this->auth->isLogged();
    if (! $status) {
      if (! empty($this->request->request->get('password')) && ! empty($this->request->request->get('email'))) {
        $remember_me = false;
        /**
         * On verifie si l'utilisateur à cocher remember_me
         */
        if (! empty($this->request->request->get('remember_me'))) {
          $remember_me = true;
        }
        $result = $this->auth->login($this->request->request->get('email'), $this->request->request->get('password'), $remember_me);
        if (! $result['error']) {
          /**
           * Redirection vers la page
           */
          $this->redirectUserAfterLogin();
        } else {
          $this->setMessage($result['message']);
        }
      } else {
        if ($this->request->request->has('password')) {
          $this->setMessage('Le login et le mot de passe sont requis');
        }
      }
    }
    if (Config::$ForceConnexion) {
      return true;
    }
    return $status;
  }

  protected function setMessage($msg, $alert_class = 'alert-warning')
  {
    self::$message = $msg;
    self::$alert_class = $alert_class;
  }

  protected function buildDataAjax($result)
  {
    if (isset($result['error'])) {
      if ($result['error']) {
        return AjaxPrepareResponse::failureRequest('', $result['message']);
      } else {
        return AjaxPrepareResponse::successRequest('', $result['message']);
      }
    }
  }

  public function logout()
  {
    $this->IsLogin();
    $hash = $this->auth->getCurrentSessionHash();
    $this->auth->logout($hash);
  }

  protected function redirectUserAfterLogin()
  {
    $this->BackToHome();
  }

  public function AjaxErrorAuth()
  {
    die('Ajax error');
  }

  public function BackToHome()
  {
    header("Location: /");
    exit();
  }
}
