<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

  public function __construct()
  {
      parent::__construct();
      $this->load->helper('url');
      $this->load->model("survey_model");
      $this->load->library('email');
  }
/**Page d'accueil*/
  public function index()
  {
    $data["active_surveys"] = $this->survey_model->getActiveSurveys();
    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/intro', $data);
    $this->load->view('home');
    $this->load->view('templates/survey/footer');
  }
/** Page nous contacter*/
public function apropos()
  {
    $this->load->view('navabout');
    $this->load->view('about');
    $this->load->view('templates/survey/footer');
  }
  /**
   * Fonction qui récupère les questions en faisant appel au modele
   */
  public function questions($survey = "")
  {

    $surveyPrefix = "";
    $surveyData = $this->survey_model->getSurveyPrefix($survey);
    $data["valid_survey"] = true;
    $data["show_questions"] = true;
    $data["survey_errors"] = false;

    // Si non null , rempli avec les infos sur le survey
    if($surveyData != null) {

      $surveyPrefix = $surveyData->prefix;
      $data["survey_title"] = $surveyData->title;
      $data["survey_subtitle"] = $surveyData->subtitle;
    }
    else {
      $data["valid_survey"] = false; // renvoi error
    }

    // verifie que le survey a été validé par la personne ayant repondu
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $data["valid_survey"]) {

      $result = $this->survey_model->validateSubmission($surveyPrefix);
      if(array_key_exists("errors", $result)) {
        $data["errors"] = $result["errors"];
        $data["survey_errors"] = true;
      }
      else {
        $data["show_questions"] = false;
      }
    }

    // verifie que l'utilisateur à spécifié un survey valide
    if(!empty($surveyPrefix)) {

      $data["questions"] = $this->survey_model->getSurveyData($surveyPrefix);
      ($data["questions"] === null) ? $data["valid_survey"] = false: "";
    }

    $this->load->view('templates/survey/nav');
    $this->load->view('templates/survey/survey', $data);
    $this->load->view('templates/survey/footer');
  }
}