<?php
namespace Stephane888\Authen\Init;

use Query\WbuJsonDb;

class Bootstrap {

  protected $filters = [];

  protected $defualtFilters = [];

  protected $BD;

  protected $requests = [];

  protected $request = '';

  protected $codeAjax;

  protected $TitleAjax;

  function __construct(WbuJsonDb $BD)
  {
    $this->BD = $BD;
  }

  protected function selectData($request, $ref)
  {
    $this->request = $request;
    $this->saveQuery($this->request, $ref);
    return $this->BD->CustomRequest($this->request);
  }

  public function setFilter($filters)
  {
    if (\is_object($filters)) {
      $this->filters = (array) $filters;
    }
    $this->filters = $filters;
    $this->defualtFilters = $filters;
  }

  /**
   * ;
   *
   * @return array
   */
  public function getQuerys()
  {
    return $this->requests;
  }

  /**
   *
   * @param string $query
   * @param string $name
   */
  protected function saveQuery($query, $name)
  {
    $this->requests[$name][] = $query;
  }

  public function getQuery($name)
  {
    return $this->requests[$name];
  }

  public function getStatusText()
  {
    return $this->TitleAjax;
  }

  public function getCodeAjax()
  {
    return $this->codeAjax;
  }
}