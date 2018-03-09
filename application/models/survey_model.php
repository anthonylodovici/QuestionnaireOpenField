<?php

class Survey_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  /**
  Fonction qui récupère le survey demandé dans la bdd
  @return : null
  */
  function getSurveyPrefix($slug) {

    // compare le nom du survey dans la bdd
    $this->db->select("*")->from("survey_list")->where("slug", $slug)->where("enabled", 1);
    $query = $this->db->get();

    if($query->num_rows() > 0)
      return $query->row();
    else
      return null;
  }

  /*
  Fonction qui récupère tout les survey actifs afin de les afficher dans le dashboard
  @return la liste des survey actifs
  */
  function getActiveSurveys() {

    $this->db->select("*")->from("survey_list")->where("enabled", 1);
    return $this->db->get()->result();
  }

  
  function mergeByCreateProperty($arrayOne, $arrayTwo) {

    if(empty($arrayOne)) return $arrayTwo;
    if(empty($arrayTwo)) return $arrayOne;

    $result = array();
    $length = sizeof($arrayOne) + sizeof($arrayTwo);
    $posOne = 0;
    $posTwo = 0;
    for($i = 0; $i < $length; $i++) {

      if($posOne < sizeof($arrayOne) && $posTwo < sizeof($arrayTwo) &&
        $arrayOne[$posOne]->created > $arrayTwo[$posTwo]->created) {
        array_push($result, $arrayOne[$posOne++]);
      }
      else if($posTwo < sizeof($arrayTwo)) {
        array_push($result, $arrayTwo[$posTwo++]);
      }
      else {
        array_push($result, $arrayOne[$posOne++]);
      }
    }
    return $result;
  }

  /**
  Fonction qui récupère tout les résultats aux surveys afin de les afficher dans le dashboard
  @return les réponses aux survey
  */
  function getSurveyResponses() {

    $this->db->select("*")->from("survey_list");
    $surveys = $this->db->get()->result();

    $surveyResponses = array();
    foreach($surveys as $survey) {
      $this->db->select("*")->from($survey->prefix . "_responses")->order_by("created", "desc");
      $responses = $this->db->get()->result();

      // Ajout des infos de l'utilisateur
      foreach($responses as $response) {
        $response->survey_title = $survey->title;
        $response->survey_slug = $survey->slug;
        $this->db->select("email")->from("survey_users")->where("id", $response->user_id);
        $response->email = $this->db->get()->row()->email;
      }
      $surveyResponses = $this->mergeByCreateProperty($surveyResponses, $responses);
    }

    return $surveyResponses;
  }

  /*
   Fonction qui récuprère tout les données des résultats
  param - surveySlug - Le nom du survey
  param - responseId - L'identifiant de la réponse
  return - les données des réponses
  */
  function getResponseData($surveySlug, $responseId) {

    // Verification du format du nom
    $this->db->select("*")->from("survey_list")->where("slug", $surveySlug);
    $query = $this->db->get();
    if($query->num_rows() > 0) {

      // Vérifie si l'id est valide
      $prefix = $query->row()->prefix;
      $this->db->select("*")->from($prefix . "_responses")->where("id", $responseId);
      $responseData = $this->db->get();
      if($responseData->num_rows() > 0 ) {

        $responseInfo = array();
        $this->db->select("email")->from("survey_users")->where("id", $responseData->row()->user_id);
        $responseInfo["email"] = $this->db->get()->row()->email;
        $result = array();

        // récupère toute les questions
        $this->db->select("*")->from($prefix . "_questions");
        $questions = $this->db->get()->result();

        foreach($questions as $question) {
          $result[$question->id] = array("question" => $question->question_text);
        }

        // Récupère toutes les réponses
        $this->db->select("*")->from($prefix . "_response_answers")->where("response_id", $responseId);
        $responses = $this->db->get()->result();

        foreach($responses as $response) {

          if(!isset($result[$response->question_id]["response"]) || !is_array($result[$response->question_id]["response"])) $result[$response->question_id]["response"] = array();
          if($response->option_id == 0) {
            array_push($result[$response->question_id]["response"], $response->text);
          }
          else {
            $this->db->select("*")->from($prefix . "_options")->where("id", $response->option_id);
            array_push($result[$response->question_id]["response"], $this->db->get()->row()->option_text);
          }
        }

        $responseInfo["responses"] = $result;
        return $responseInfo;
      }
    }
    return null;
  }

  /*
  Fonction qui récupère tout les données selon le préfixe
  param - surveyPrefix of table - exemple 's1'
  return - null si non valide 
  
  */
  function getSurveyData($surveyPrefix) {

    if($this->db->table_exists($surveyPrefix . "_questions") &&
      $this->db->table_exists($surveyPrefix . "_options")) {

      $this->db->select("*")->from($surveyPrefix . "_questions")->order_by("id", "asc");
      $question_query = $this->db->get();

      foreach($question_query->result() as $question) {
          // Récupère toute les réponses pour les questions de type 0 et de type 3
        if($question->question_type == 0 || $question->question_type == 3|| $question->question_type ==4 ||$question->question_type==5 ||$question->question_type==6 || $question->question_type==7) {


          $this->db->select("*")->from($surveyPrefix . "_options")->where("question_id", $question->id);
          $option_query = $this->db->get();

          // Ajoute tout le contenu des réponse
          $question->options = array();
          foreach($option_query->result() as $option) {
            array_push($question->options, $option);
          }
        }
      } // end foreach - all questions

      return $question_query->result();
    } // end if - valid table

    return null;
  }

  /*
  Verfie la validité des infos saisies par la personne qui repond au survey
  param - surveyPrefix of table - example 's1'
  */
  function validateSubmission($surveyPrefix) {

    // Récupere les question réponse et voit si tout est correct
    $surveyData = $this->getSurveyData($surveyPrefix);
    $errors = array();
    if($surveyData != null) {

      $responses = array();
            if(isset($_POST["email_field"])) {
        $responses["email"] = $_POST["email_field"];
      }
      else {
        array_push($errors, "'L'adresse mail doit être valide.");
      }

      foreach($surveyData as $question) {

        if(isset($_POST["question_" . $question->id]) && !empty($_POST["question_" . $question->id])) {
          
          if(!is_array($_POST["question_" . $question->id]))
            $question->response = array($_POST["question_" . $question->id]);
          else
            $question->response = $_POST["question_" . $question->id];

          $responses[($question->id)] = $question;
        }
        else {

          // check si la réponse à une question est obligatoire
          if($question->required == 1) {

            // error 
            array_push($errors, "'" . $question->question_text . "' est obligatoire.");
          }
          elseif(isset($_POST["question_" . $question->id]) ) {

            // question n'ayant pas de réponse mais n'est pas obligatoire
            
            if(!is_array($_POST["question_" . $question->id]))
              $question->response = array($_POST["question_" . $question->id]);
            else
              $question->response = $_POST["question_" . $question->id];
            $responses[($question->id)] = $question;
          }
        }
      }

      if(sizeof($errors) > 0) 
        return array("errors" => $errors);
      else
        return array("success" => $this->submitData($surveyPrefix, $responses));
    }

    return null;
  } // Valider le submit des données saisies

  /*
  Envoi des infos dans la bdd
  param - surveyPrefix de la table - exemple 's1'
  param - reponses aux questions - question object including responses
  */
  private function submitData($surveyPrefix, $responses) {

    // Verifie si l'la personne ayant répondu existe
    $this->db->select("*")->from("survey_users")->where("email", $responses["email"]);
    $emailQuery = $this->db->get();
    $userId = 0;


      // ajoute les infos de la personne ayant repondu dans la bdd
      $this->db->insert("survey_users", array("email" => $responses["email"]));

      // recupere l'id de l'utilisateur ayant repondu
      $this->db->select("*")->from("survey_users")->where("email", $responses["email"]);
      $emailQuery = $this->db->get();
      $userId = $emailQuery->row()->id;
    


    // create a response & retrieve the id
    $responseId = 0;
    $this->db->insert($surveyPrefix . "_responses", array("user_id" => $userId));
    $responseId = $this->db->insert_id();

    // preparation de l'insertion des reponses saisies
    $insert_data = array();
    foreach ($responses as $response) {
  
      if($response == $responses["email"]) continue;

      if(isset($response->response) && $response->response != null) {
        foreach($response->response as $single_response) {

          // generer les données de reponse
          $response_data = array();
          $response_data["response_id"] = $responseId;
          $response_data["question_id"] = $response->id;

          // check si la question est à choix multiple
          if($response->question_type == 0 || $response->question_type == 3 || $response->question_type == 4 ||$response->question_type == 5||$response->question_type == 6||$response->question_type == 7) {

            // associe les options de reponse et ignore le texte
            $response_data["option_id"] = $single_response;
            $response_data["text"] = null;
          }
          // check si la question est une simple ligne de texte ou un champ de texte
          elseif($response->question_type == 1 || $response->question_type == 2 ) {

            // ignore les options de reponse et recupere le texte
            $response_data["option_id"] = 0;
            $response_data["text"] = $single_response;
          }

          array_push($insert_data, $response_data);
        }
      }
      else {

        // Générer les données de reponse
        $response_data = array();
        $response_data["response_id"] = $responseId;
        $response_data["question_id"] = $response->id;
        $response_data["option_id"] = 0;
        $response_data["text"] = null;
        array_push($insert_data, $response_data);
      }
    }

    $this->db->insert_batch($surveyPrefix . "_response_answers", $insert_data);
    return null;

  }
}

?>