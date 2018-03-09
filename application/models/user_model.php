<?php

class User_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  /**
  Fonction de log in d'un user
  Si l'user existe, récupération dans la bdd en comparant aux infos tapée
  si il exite pas , affichage d'une erreur
  */
  function login() {

    $errors = array();
    // Email et mot de passe valide
    if(isset($_POST["login-password"]) && !empty($_POST["login-password"])
      && isset($_POST["login-email"]) && !empty($_POST["login-email"])) {

      $email = $_POST["login-email"];
      $password = $_POST["login-password"];

      $this->db->select("*")->from("admin_users")->where(array("email" => $email, "password" => md5($password)));
      $query = $this->db->get();
      if($query->num_rows() > 0) {

        $user = $query->row();
        //Ajouter les infos dans la  variable de session
        $userdata = array(
          'id'  => $user->id,
          'email'    => $user->email,
          'logged_in'  => TRUE,
        );
        $this->session->set_userdata($userdata);
      }
      else {
        array_push($errors, "Adresse ou mot de passe incorrect.");
      }
    }
    else {
      array_push($errors, "Tous les champs sont obligatoires.");
    }

    return array("errors" => $errors, "success" => (empty($errors)));
  }

  /*
  Fonction qui Verifie s'il y a un utilisateur connecté
  */
  function isLoggedIn() {

    return ($this->session->userdata("logged_in") !== FALSE);
  }

  /**
  Fonction qui deconnecte l'utilisateur
  */
  function logout() {
    $userdata = array(
      'id'   =>'',
      'email'     => '',
      'logged_in' => FALSE,
    );
    $this->session->unset_userdata($userdata);
    $this->session->sess_destroy();
  }

  /**
  Fonction qui enregistre un utilisateur qui vient de s'inscrire
  Vérifie la validité de l'email et du mot de passe , verifie que l'email n'est pas déjà utilisé , test la longueur du mot de passe , crypte le mot de passe et crée l'utilisateur
  */
  function addUser() {

    $errors = array();
    // verifie la validité de l'email et du mot de passe
    if(isset($_POST["signup-password"]) && !empty($_POST["signup-password"])
      && isset($_POST["signup-email"]) && !empty($_POST["signup-email"])) {

      $email = $_POST["signup-email"];
      $password = $_POST["signup-password"];
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // verifie que l'email n'est pas déjà utilisé
        $this->db->select("*")->from("admin_users")->where("email", $email);
        $query = $this->db->get();
        if($query->num_rows() == 0) {

          if(strlen($password) >= 6){//test si le mdp est > a 6 caracteres 

            // créer l'utilisateur et  cryptage du mot de passe en md5
            $password = md5($password);
            $this->db->insert("admin_users", array("email" => $email, "password" => $password)); //insertion dans la bdd les infos du nouvel admin
          }
          //differentes erreurs
          else {
            array_push($errors, "Le mot de passe doit contenir au moins 6 caractères. ");
          }
        }
        else {
          array_push($errors, "L'adresse mail est déjà utilisée.");
        }
      }
      else {
        array_push($errors, "L'adresse mail est invalide.");
      }
    }
    else {
      array_push($errors, "Tous les champs sont obligatoires");
    }

    return array("errors" => $errors, "success" => (empty($errors)));
  }

  /**
  Fonction qui compte les utilisateurs dans la table des admin
  */
  function getUserCount() {

    $this->db->select("*")->from("admin_users");
    return $this->db->get()->num_rows();
  }
}