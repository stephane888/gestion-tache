<?php
namespace Stephane888\Authen;

use Stephane888\GestionTache\Request as SrcRequest;
use Query\WbuJsonDb;
use Stephane888\Authen\Config\Config;
use Query\Repositories\Utility as Bd_Utility;
use Stephane888\Authen\Auth\Connect;
use Query\Repositories\ExecuteQuery;

class Request extends Connect {

  /**
   * Connection BD definie par l'utilisateur.
   *
   * @var object
   */
  protected $Rq_BD;

  public $result = [];

  protected $token;

  protected $input_data = null;

  private $CodeAjax;

  private $TitleAjax;

  private $UserBD;

  function __construct($token, $configs = [])
  {
    $this->input_data = $configs;
    parent::__construct();
    if (! empty($configs['databaseConfig'])) {
      $bdinfo = Bd_Utility::checkCredentiel(Config::DataBase(), $configs['databaseConfig']);
      // $this->result = Bd_Utility::$result;
      $this->Rq_BD = new WbuJsonDb($bdinfo);
      if ($this->IsLogin()) {
        $this->UserBD = $this->getConnexion();
        $this->AnalyseToken($token);
      } else {
        $this->CodeAjax = 400;
        $this->TitleAjax = "Vous n'etes pas connéctée";
      }
    } else {
      $this->CodeAjax = 400;
      $this->TitleAjax = 'Custom config BD not define';
    }
  }

  /**
   *
   * @param string $token
   */
  protected function AnalyseToken($token)
  {
    /**
     * user
     */
    if ($token == 'registeruser') {
      $this->result['registeruser'] = $this->setConfigsAjax($this->createCompte($this->input_data['fields']));
    } elseif ($token == 'query-db') {
      if (! empty($this->input_data['selects'])) {
        $UserQuery = new ExecuteQuery($this->UserBD);
        $this->result['query-db'] = $UserQuery->applySelect($this->input_data['selects']);
      }
    } //
    /**
     * Default requet :: insertion des données en BD.
     */
    elseif ($token == 'insert-db') {
      $DataQuery = new ExecuteQuery($this->Rq_BD);
      $this->result['inserts'] = $DataQuery->buildInserts($this->input_data['inserts']);
      if ($DataQuery->hasErrors()) {
        $this->TitleAjax = $DataQuery->FirstErrors();
        $this->CodeAjax = 400;
      }
    } else {
      $SrcRequest = new SrcRequest($this->Rq_BD, $token, $this->input_data);
      $SrcRequest->AnalyseToken();
      $this->CodeAjax = $SrcRequest->getCodeAjax();
      $this->TitleAjax = $SrcRequest->getTitleAjax();
      $this->result = \array_merge($this->result, $SrcRequest->result);
    }
  }

  public function getStatusText()
  {
    return $this->TitleAjax;
  }

  public function getCodeAjax()
  {
    return $this->CodeAjax;
  }

  /**
   *
   * @param array $datas
   * @return array
   */
  protected function setConfigsAjax($datas)
  {
    $this->CodeAjax = $datas['code'];
    $this->TitleAjax = $datas['title'];
    return $datas['datas'];
  }
}