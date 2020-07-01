<?php
namespace Stephane888\Authen\Auth;

use Stephane888\Authen\Routes\Web;

trait PagePermission {

  public function LoadCurrentPage()
  {
    $web = new Web();
    $page = false;
    if ($this->request->query->has($this->key_page)) {
      $page = $web->getPageURI($this->request->query->get($this->key_page));
      if ($this->CheckPermission($page)) {
        return $page;
      }
    }
    return $page;
  }

  protected function CheckPermission(&$page)
  {
    return true;
  }

  public function getTitlePage()
  {
    return 'Gestion de taches';
  }
}