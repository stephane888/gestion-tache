<?php
namespace Stephane888\Authen\Config;

class ConfigExample {

  /**
   * Permet de definir la base de donnée à utiliser.
   * Les valeurs possibles sont definis par : 'prodNutribe', 'testNutribe', 'localhost'
   *
   * @var string
   */
  public static $dataBaseConfig = null;

  /**
   * Pour permettre à toute personne de se connecter sans authentification.
   *
   * @var boolean
   */
  public static $ForceConnexion = false;

  /**
   * a utiliser si la bd des utilisateurs est externes à APP.
   *
   * @return string[][]
   */
  public static function DataBaseAuth()
  {
    return [
      'App-Auth' => [
        'user' => 'user_name',
        'password' => 'user_passwordt',
        'dbName' => 'table_data'
      ],
      'localhost' => [
        'user' => 'user_name',
        'password' => 'user_passwordt',
        'dbName' => 'table_data'
      ]
    ];
  }

  /**
   * a utiliser si la bd des utilisateurs est externes à APP.
   *
   * @return string[][]
   */
  public static function DataBase()
  {
    return [
      'Wbu-Gestion-Tache' => [
        'user' => 'user_name',
        'password' => 'user_passwordt',
        'dbName' => 'table_data'
      ],
      'localhost' => [
        'user' => 'user_name',
        'password' => 'user_passwordt',
        'dbName' => 'table_data'
      ]
    ];
  }
}
