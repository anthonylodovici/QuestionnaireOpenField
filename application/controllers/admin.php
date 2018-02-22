<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

  function __construct() {
    parent::__construct();

    // charge helpers/models
    $this->load->helper('url');
    $this->load->model("user_model");
    $this->load->library("session");
    $this->load->model("survey_model");
  }

  private function requiresLogin() {

    if(!$this->user_model->isLoggedIn()) {
      redirect("admin/login", "redirect");
    }
  } 

  private function alreadyLoggedIn() {

    if($this->user_model->isLoggedIn()) {
      redirect("admin/dashboard", "redirect");
    }
  }
public function envoi(){
  $contact= $this->db->select('(SELECT email FROM users)');
    if($this->user_model->isLoggedIn()) {
   $this->load->view('templates/admin/nav');
   $this->load->view('email',$contact);
  $this->load->view('templates/admin/footer');
}else{
  redirect("/admin/login","redirect");
}

}
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

  public function logout() {
    $this->user_model->logout();
    redirect("admin/login", "refresh");
  }
//création d'un compte
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