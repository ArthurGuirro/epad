<?php

namespace App\Session;

class Login{


  /**
   * Método responsável por iniciar a sessão
   * @return 
   */
  private static function init(){
    //verifica o status da sessão
    if(session_status() !== PHP_SESSION_ACTIVE){
      //inicia a sessão
      session_start();
    }
  }

  /**
   * Método responsával por retornar os dados do usuário logado
   * @return array
   */
  public static function getUsuarioLogado(){
    //inicia a sessão
    self::init();

    //retorna dados do usuário
    return self::isLogged() ? $_SESSION['proecunespar'] : null;

  }

  /**
   * @param Usuario $obUsuario
   */
  public static function login($obUsuario){
    //inicia a sessão
    self::init();

    //sessão de usuário
    $_SESSION['proecunespar'] =[

      'id' => $obUsuario->id,
      'nome' => $obUsuario->nome,
      'email' => $obUsuario->email,
      'senha' => $obUsuario->senha,
      'config' => $obUsuario->config,
      'ce_id' => $obUsuario->ce_id,
      'ce_cod' => $obUsuario->ce_cod,
      'ce_nome' => $obUsuario->ce_nome,
      'co_id' => $obUsuario->co_id,
      'co_nome' => $obUsuario->co_nome,
      'ca_id' => $obUsuario->ca_id,
      'ca_cod' => $obUsuario->ca_cod,
      'ca_nome' => $obUsuario->ca_nome,
      'tipo' => $obUsuario->tipo,
      'adm' => $obUsuario->adm,
      'ativo' => $obUsuario->ativo, 
      'year_sel' => '',
      'id_coSel' => ''
      

    ];

    // redireciona usuário para Index
    header('location: ../index.php');
    exit;

  }

  /**
   * Método responsável para deslogar o usuário
   */
  public static function logout(){
    //inicia a sessão
    self::init();

    //remove a sessão de usuário
    unset($_SESSION['proecunespar']);
    session_destroy('proecunespar');

    header('location: ../login/login.php');
    exit;

  }
  
  /**
   * Método responsável por verificar se o usuário está logado
   * @return boolean
   */
  public static function isLogged(){
    //inicia a sessão
    self::init();

    //validação da sessão
    return isset($_SESSION['proecunespar']['id']);
  }

  /**
   * Método responsável por obrigar o usuário a estar logado para acessar
   */
  public static function requireLogin(){
    if(!self::isLogged()){
      header('location: ../login/login.php');
      exit;
    }
  }

  /**
   * Método responsável por obrigar o usuário a estar deslogado para acessar
   */
  public static function requireLogout(){
    if(self::isLogged()){
      header('location: ../index.php');
      exit;
    }
  }

}