<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

  function __construct() {
    parent::__construct();

    /** charge helpers/models
    */

    $this->load->helper('url');
    $this->load->model("user_model");
    $this->load->library("session");
    $this->load->model("survey_model");
    $this->load->library('table');
  }
 /** Fonction qui charge les templates pour la page de résultat sous forme de tableau*/
  public function chart()
  {
    $this->requiresLogin();
    $this->load->view('templates/admin/nav');
    $this->load->view('chart');
    $this->load->view('templates/admin/footer');

 }
/** Fonction qui  test si un user est loggué , si non , renvoi vers page de connexion*/
  private function requiresLogin() {

    if(!$this->user_model->isLoggedIn()) {
      redirect("admin/login", "redirect");
    }
  } 
/** Fonction qui test si un user est loggué , si oui , renvoi vers le dashboard*/
  private function alreadyLoggedIn() {

    if($this->user_model->isLoggedIn()) {
      redirect("admin/dashboard", "redirect");
    }
  }
/** Fonction qui connecte un user , si succès , renvoi vers dashboard, si erreur , affiche page d'erreur. Si pas d'admin enregistré ,renvoi vers la page d'enregistrement*/
  public function login()
  {

    $this->alreadyLoggedIn(); // verifie si un user est logué

    // verifie s'il existe un admin
    if($this->user_model->getUserCount() == 0) {
       redirect("/admin/signup", "refresh");
    }

    $data = "";
    // valider les données
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $loginResult = $this->user_model->login();
      if($loginResult["success"]) {
        redirect("/admin/dashboard", "refresh"); // succes de login de l'utilisateur 
      }
      else {
        $data["errors"] = $loginResult["errors"];
      }
    }
    $this->load->view('templates/admin/navlogin');
    $this->load->view('templates/admin/login', $data);
    $this->load->view('templates/admin/footer');
  }
/** Fonction de deconnexion: renvoi vers la page de login*/
  public function logout() {
    $this->user_model->logout();
    redirect("admin/login", "refresh");
  }
/** Fonction de création d'un compte admin, verifie si un compte existe , si oui , redirection vers page login , si non, accès a la page signup et possibilité de création*/
  public function signup() {

    // Vérifie si un utilisateur existe
    if($this->user_model->getUserCount() > 0) {
       redirect("/admin/login", "refresh");
    }

    $data = "";
    // Si le formulaire est soumis , validation des données
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

      $addUserResult = $this->user_model->addUser();
      if($addUserResult["success"]) {
        redirect("/admin/login", "refresh"); // création de l'utilisateur avec succès
      }
      else {
        $data["errors"] = $addUserResult["errors"];
      }
    }
    $this->load->view('templates/admin/navlogin');
    $this->load->view('templates/admin/signup', $data);
    $this->load->view('templates/admin/footer');
  }
/** Fonction du dashboard, le login est requis. Affiche la liste des survey et  des réponses avec date,heure et email de la personne*/
  public function dashboard() {

    $this->requiresLogin();

    $data["user"] = array("email" => $this->session->userdata("email"));
    $data["active_surveys"] = $this->survey_model->getActiveSurveys();
    $data["survey_responses"] = $this->survey_model->getSurveyResponses();
    $this->load->view('templates/admin/nav', $data);
    $this->load->view('templates/admin/dashboard', $data);
    $this->load->view('templates/admin/footer');
  }

  public function response($surveySlug = "", $responseId = 0) {

    $this->requiresLogin();
    $data["user"] = array("email" => $this->session->userdata("email"));

    if(!empty($surveySlug) && $responseId > 0) {

      $data["responses"] = $this->survey_model->getResponseData($surveySlug, $responseId);
      $data["valid_response"] = ($data["responses"] !== null);
    }
    else {
      $data["valid_response"] = false;
    }
    $this->load->view('templates/admin/nav', $data);
    $this->load->view('templates/admin/response', $data);
    $this->load->view('templates/admin/footer');
  }
}