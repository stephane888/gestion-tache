<?php
namespace Stephane888\GestionTache\Repositories;

use Stephane888\GestionTache\Init\Bootstrap;
use Query\Repositories\ExecuteQuery;

class CreationProjet extends Bootstrap {

  private $requete = "
  c.idcontents, c.text, c.titre, c.created_at, c.update_at,
  h.idhierachie, h.idcontentsparent, h.ordre, h.level,
  cf.idconfigs, cf.testconfigs
  ";

  public function __construct($BD)
  {
    parent::__construct($BD);
  }

  /**
   *
   * @param array $inserts
   */
  public function addProject($inserts)
  {
    $ExecuteQuery = new ExecuteQuery($this->BD);
    $query = $ExecuteQuery->buildInserts($inserts);
    if ($ExecuteQuery->hasErrors()) {
      $this->codeAjax = 400;
      $this->TitleAjax = $ExecuteQuery->FirstErrors();
    } else {
      $idcontent = $ExecuteQuery->getLastId();
      if ($idcontent) {
        $table = 'hierachie';
        $fields = [
          'idcontents' => $idcontent,
          'idcontentsparent' => 0,
          'ordre' => 0
        ];
        $insert = $this->BD->insert($table, $fields);
      }
    }

    return [
      'query' => $query,
      'insert' => $insert
    ];
  }

  public function selectProject($level, $idcontentsparent = 0)
  {
    $champs = $this->requete;
    $request = "select $champs from `contents` as c
      INNER JOIN `hierachie` as h ON h.idcontents = c.idcontents
      LEFT JOIN `configs` as cf ON cf.idcontents = c.idcontents
      WHERE h.level=$level and h.idcontentsparent=$idcontentsparent
    ";
    return $this->selectData($request, 'selectProject');
  }

  public function LoadProject($idcontents)
  {
    $champs = $this->requete;
    $request = "select $champs from `hierachie` as h
      INNER JOIN `contents` as c ON h.idcontents = c.idcontents
      LEFT JOIN `configs` as cf ON cf.idcontents = c.idcontents
      WHERE ( h.idcontentsparent = $idcontents OR c.idcontents = $idcontents )
    ";
    return $this->selectData($request, 'LoadProject');
  }

  public function LoadProjectGroupCards($project)
  {
    $idcontents = $project['idcontents'];
    $results = [];
    $champs = $this->requete;
    $request = "select $champs from `hierachie` as h
      INNER JOIN `contents` as c ON h.idcontents = c.idcontents
      LEFT JOIN `configs` as cf ON cf.idcontents = c.idcontents
      WHERE ( c.idcontents = $idcontents )
    ";
    $project = $this->selectData($request, 'LoadProjectGroupCards');
    if (! empty($project) && ! isset($project['PHP_execution_error'])) {
      $results = $project;
      $this->loadRCard($idcontents, $results);
    }
    return $results;
  }

  public function getFilAriane($project, $results = [])
  {
    if (! empty($project['level'])) {
      $idcontentsparent = $project['idcontentsparent'];
      $champs = $this->requete;
      $request = "select $champs from `hierachie` as h
      INNER JOIN `contents` as c ON h.idcontents = c.idcontents
      LEFT JOIN `configs` as cf ON cf.idcontents = c.idcontents
      WHERE ( c.idcontents = $idcontentsparent)
      ";
      $results[] = $data = $this->selectOneData($request, 'getFilAriane');
      $results = $this->getFilAriane($data, $results);
    }
    return $results;
  }

  protected function loadRCard($idcontents, &$results)
  {
    $stop = 0;
    $champs = $this->requete;
    while ($idcontents && $stop < 99) {
      $stop ++;
      $request = "select $champs from `hierachie` as h
      INNER JOIN `contents` as c ON h.idcontents = c.idcontents
      LEFT JOIN `configs` as cf ON cf.idcontents = c.idcontents
      WHERE ( h.idcontentsparent = $idcontents)
      ";
    }
    $project = $this->selectData($request, 'LoadProjectGroupCards');
    if (! empty($project) && ! isset($project['PHP_execution_error'])) {
      foreach ($results as $key => $ligne) {
        if ($ligne['idcontents'] == $idcontents) {
          $results[$key]['cards'] = $project;
          foreach ($results[$key]['cards'] as $data) {
            $idcontents = $data['idcontents'];
            $this->loadRCard($data['idcontents'], $results[$key]['cards']);
          }
        }
      }
    } else {
      $idcontents = false;
    }
  }

  public function createTache($datas)
  {
    if (isset($datas['idcontentsparent'])) {
      $fields = [
        'titre' => $datas['titre'],
        'text' => $datas['text']
      ];
      $inserts[] = [
        'table' => 'contents',
        'fields' => $fields
      ];
      $ExecuteQuery = new ExecuteQuery($this->BD);
      $query = $ExecuteQuery->buildInserts($inserts);
      if ($ExecuteQuery->hasErrors()) {
        $this->codeAjax = 400;
        $this->TitleAjax = $ExecuteQuery->FirstErrors();
      } else {
        $idcontent = $ExecuteQuery->getLastId();
        if ($idcontent) {
          $table = 'hierachie';
          $fields = [
            'idcontents' => $idcontent,
            'idcontentsparent' => $datas['idcontentsparent'],
            'ordre' => 0,
            'level' => $datas['level']
          ];
          $insert = $this->BD->insert($table, $fields);
        }
      }
      return [
        'query' => $query,
        'insert' => $insert
      ];
    }
  }

  protected function ContentHasSubContent($idcontents)
  {
    $request = "SELECT * FROM `hierachie` WHERE idcontentsparent=$idcontents";
    $result = $this->selectOneData($request, 'ContentHasSubContent');
    if (! empty($result)) {
      return $result;
    }
    return false;
  }

  public function DeleteTache($datas)
  {
    $resuls = [
      'action' => false
    ];
    if (isset($datas['idcontents'])) {
      if (! $this->ContentHasSubContent($datas['idcontents'])) {
        $idcontents = $datas['idcontents'];
        $req = "DELETE FROM `hierachie` WHERE `idcontents`='$idcontents'";
        $resuls['hierachie'] = $this->BD->deleteDatas($req);
        $req = "DELETE FROM `contents` WHERE `idcontents`='$idcontents'";
        $resuls['contents'] = $this->BD->deleteDatas($req);
        $req = "DELETE FROM `configs` WHERE `idcontents`='$idcontents'";
        $resuls['configs'] = $this->BD->deleteDatas($req);
        $resuls['action'] = true;
        return $resuls;
      }
    }
    return $resuls;
  }

  public function CreateUpdateStyle($datas)
  {
    if (isset($datas['idcontents'])) {
      $table = 'configs';
      if (empty($datas['idconfigs'])) {
        $fields = [
          'testconfigs' => \json_encode($datas),
          'idcontents' => $datas['idcontents']
        ];
        $inserts[] = [
          'table' => $table,
          'fields' => $fields
        ];
        $ExecuteQuery = new ExecuteQuery($this->BD);
        $query = $ExecuteQuery->buildInserts($inserts);
        if ($ExecuteQuery->hasErrors()) {
          $this->codeAjax = 400;
          $this->TitleAjax = $ExecuteQuery->FirstErrors();
        }
      } else {
        $fields = [
          'testconfigs' => \json_encode($datas)
        ];
        $this->BD->Where = [
          'f1' => [
            'field' => 'idconfigs',
            'value' => $datas['idconfigs']
          ]
        ];
        $query = $this->BD->update($table, $fields);
      }
      return $query;
    }
    return false;
  }

  public function UpdateTache($datas)
  {
    if (isset($datas['idcontents'])) {
      $table = 'contents';
      $fields = [
        'titre' => $datas['titre'],
        'text' => $datas['text']
      ];
      $this->BD->Where = [
        'f1' => [
          'field' => 'idcontents',
          'value' => $datas['idcontents']
        ]
      ];
      $this->BD->update($table, $fields);
      return true;
    }
    return null;
  }
}
