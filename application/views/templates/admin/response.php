<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
<pre>
<link rel="icon" href="<?php echo base_url();?>assets/images/logo.png" type="image/png">
</pre>
    <title>OpenField - Résultats de l'enquête</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


  <div class="container" >
    <div class="row">
      <div class="col-md-12">
        <h4>
          <span class="fa fa-comment"></span>
          Réponses à l'enquête <?php echo (isset($responses) ? " - <a target='_blank' href='mailto:" . $responses["email"] . "'>" . $responses["email"] . "</a>" : ""); ?></small>
        </h4>
        <?php if(isset($valid_response) && $valid_response): ?>
        <ul class="list-group" >
          <?php foreach($responses["responses"] as $response): ?>
            <li class="list-group-item">
              <h5 class="list-group-item-heading">
                <?php echo $response["question"]; ?>
              </h5>
              <p class="list-group-item-text">
                <ul>
                  <?php foreach($response["response"] as $answer): ?>
                    <li>
                      <?php echo ((!empty($answer)) ? $answer : "<i class='text-muted'>Pas de réponse</i>"); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </p>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <div class="alert alert-warning text-center" role="alert">
            Le résultat demandé est indisponible.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>