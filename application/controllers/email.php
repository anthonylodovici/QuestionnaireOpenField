<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class email extends CI_Controller {

  public function __construct()
  {
      parent::__construct();
      $this->load->helper('url');
      $this->load->model("survey_model");
      $this->load->library('email');
  }
  public function sending()
  {
    
    	$this->email->from('anthony.lodovici@gmail.com', 'Anthony');
$this->email->to('anthony.lodovici@gmail.com');
$this->email->subject("Titre de l'email");
$this->email->message('ton message');
if($this->email->send()){
	echo 'email envoyé';
}
  }

  }
