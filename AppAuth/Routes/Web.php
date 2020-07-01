<?php
namespace Stephane888\Authen\Routes;

class Web {

  const RoleAdmin = 'admin';

  const PermAdmin = 'admin';

  private $pages = [];

  function __construct()
  {
    $this->defaultPage();
    $this->siteUrl();
  }

  /**
   * Charge toutes les pages du sites.
   */
  protected function defaultPage()
  {
    $this->pages = [
      'register' => [
        'permission' => static::RoleAdmin,
        'URI' => '/App/Ressources/Register.php',
        'group' => static::PermAdmin
      ],
      'logout' => [
        'permission' => '',
        'URI' => '/App/Ressources/Logout.php',
        'group' => '',
        'no_headers' => true
      ],
      'nutribe' => [
        'permission' => static::RoleAdmin,
        'URI' => '/App/Ressources/App.php',
        'group' => static::PermAdmin
      ]
    ];
  }

  public function getPageURI($key)
  {
    if (isset($this->pages[$key])) {
      return $this->pages[$key];
    }
    return false;
  }

  /**
   * url de site.
   */
  protected function siteUrl()
  {
    $this->pages['gestion-tache'] = [
      'permission' => static::RoleAdmin,
      'URI' => '/App/Ressources/gestion-tache.php',
      'group' => static::PermAdmin
    ];
  }
}