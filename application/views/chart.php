<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
<pre>
<link rel="icon" href="<?php echo base_url();?>assets/images/logo.png" type="image/png">
</pre>
    <title>OpenField - Résultats</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

</head>
<body>
    <div class="container"><h2><i class="fas fa-chart-bar"></i> <span> <b>Analyse des enquêtes(%):</b></span></h2></div>
    <div class="container" style="background-color:#fff">
    <div class="row" style="border: 6px double #787878">
      <div class="col-md-12"><br/>
<ul>
<h4><li>Comment avez-vous pris contact avec notre représentant?</li></h4>
<?php
$query = $this->db->query('SELECT * FROM question1');
echo $this->table->generate($query); ?> <br/>

<h4><li>Combien de temps avez-vous dû attendre avant de pouvoir parler à notre représentant?</li></h4><?php
$q2 = $this->db->query('SELECT * FROM question2');
echo $this->table->generate($q2); ?> <br/>

<h4><li>Combien de temps avez-vous dû attendre avant qu'un représentant prenne contact avec vous?</li></h4><?php
$q3 = $this->db->query('SELECT * FROM question3');
echo $this->table->generate($q3); ?> <br/>

<h4><li>Globalement , comment qualifieriez-vous le processus jusqu'à résolution de l'incident?</li></h4><?php
$q4 = $this->db->query('SELECT * FROM question4');
echo $this->table->generate($q4); ?> <br/>
<hr></hr>
<h4><li>Facilité de contact avec le service-client:</li></h4><?php
$q5 = $this->db->query('SELECT * FROM question7');
echo $this->table->generate($q5); ?> <br/>

<h4><li>Efficacité du représentant:</li></h4><?php
$q7 = $this->db->query('SELECT * FROM question8');
echo $this->table->generate($q7); ?> <br/>

<h4><li>Qualité du conseil:</li></h4><?php
$q8 = $this->db->query('SELECT * FROM question9');
echo $this->table->generate($q8); ?> <br/>

<h4><li>Professionnalité du représentant:</li></h4><?php
$q9 = $this->db->query('SELECT * FROM question10');
echo $this->table->generate($q9); ?> <br/>

<h4><li>Résolution du problème:</li></h4><?php
$q10 = $this->db->query('SELECT * FROM question11');
echo $this->table->generate($q10); ?> <br/>

<h4><li>Rapidité de réponse par email:</li></h4><?php
$q11 = $this->db->query('SELECT * FROM question12');
echo $this->table->generate($q11); ?> <br/>

<h4><li>Rapidité de réponse par téléphone:</li></h4><?php
$q12 = $this->db->query('SELECT * FROM question13');
echo $this->table->generate($q12); ?> <br/>
<hr/>
<h4><li>Le représentant était bien informé:</li></h4><?php
$q13 = $this->db->query('SELECT * FROM question15');
echo $this->table->generate($q13); ?> <br/>

<h4><li>Le représentant était patient:</li></h4><?php
$q14 = $this->db->query('SELECT * FROM question16');
echo $this->table->generate($q14); ?> <br/>

<h4><li>Le représentant a eu une attitude positive:</li></h4><?php
$q15 = $this->db->query('SELECT * FROM question17');
echo $this->table->generate($q15); ?> <br/>

<h4><li>Le représentant était attentif:</li></h4><?php
$q16 = $this->db->query('SELECT * FROM question18');
echo $this->table->generate($q16); ?> <br/>

<h4><li>Le représentant a été aimable:</li></h4><?php
$q17 = $this->db->query('SELECT * FROM question19');
echo $this->table->generate($q17); ?> <br/>

<h4><li>Le représentant a fait preuve de responsabilité:</li></h4><?php
$q18 = $this->db->query('SELECT * FROM question20');
echo $this->table->generate($q18); ?> <br/>

<h4><li>Le représentant a fait preuve de courtoisie:</li></h4>
<?php
$q19 = $this->db->query('SELECT * FROM question21');
echo $this->table->generate($q19);?> <br/></ul>
</div></div></div>
<br/>
</body>
</html> 