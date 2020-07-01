<?php
namespace Stephane888\GestionTache;

use Stephane888\GestionTache\Repositories\CreationProjet;

class Request {

  protected $BD;

  public $result = [];

  protected $token;

  protected $input_data = null;

  protected $is_localhost = false;

  private $CodeAjax = 200;

  private $TitleAjax = 'OK';

  function __construct($bd, $token, $input_data)
  {
    $this->BD = $bd;
    $this->token = $token;
    $this->input_data = $input_data;
  }

  /**
   *
   * @param string $token
   */
  public function AnalyseToken()
  {
    switch ($this->token) {
      case 'insert-db-add-project':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['add-project'] = $CreationProjet->addProject($this->input_data['inserts']);
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        break;

      case 'select-project':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['select-project'] = $CreationProjet->selectProject($this->input_data['level']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        break;

      case 'insert-db-add-tache':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['insert-db-add-tache'] = $CreationProjet->createTache($this->input_data['datas']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        break;

      case 'update-db-add-tache':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['update-db-add-tache'] = $CreationProjet->UpdateTache($this->input_data['datas']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        break;

      case 'delete-db-add-tache':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['delete-db-add-tache'] = $CreationProjet->DeleteTache($this->input_data['datas']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        break; //

      case 'create-update_style':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['create-update_style'] = $CreationProjet->CreateUpdateStyle($this->input_data['datas']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        $this->CodeAjax = $CreationProjet->getCodeAjax();
        $this->TitleAjax = $CreationProjet->getStatusText();
        $this->result['ajax'] = [
          'CodeAjax' => $this->CodeAjax,
          'TitleAjax' => $this->TitleAjax
        ];
        break;

      case 'load-project':
        $CreationProjet = new CreationProjet($this->BD);
        $this->result['load-project'] = $CreationProjet->LoadProject($this->input_data['project']['idcontents']);
        $this->result['load-project-cards'] = $CreationProjet->LoadProjectGroupCards($this->input_data['project']);
        $this->result['crumb'] = $CreationProjet->getFilAriane($this->input_data['project']);
        $this->result['querys'] = $CreationProjet->getQuerys();
        break;

      default:
        $this->CodeAjax = 400;
        $this->TitleAjax = ' Le token `' . $this->token . '` ne correcpont pas à une donnée. ';
        break;
    }
  }

  function getCodeAjax()
  {
    return $this->CodeAjax;
  }

  function getTitleAjax()
  {
    return $this->TitleAjax;
  }
}