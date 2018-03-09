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
    <title>OpenField - Panneau d'administration</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h4>
          <span class="fa fa-th-list"></span>
          Enquêtes en cours:
        </h4>
        <?php if(isset($active_surveys) && $active_surveys != null): ?>
          <div class="list-group">
            <?php foreach($active_surveys as $survey): ?>
              <a href="<?php echo base_url() . "questions/" . $survey->slug; ?>" class="list-group-item">
                <?php echo $survey->title; ?>
                <span class="fa fa-chevron-right pull-right "></span>
              </a>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="alert alert-secondary text-center" role="alert" style="border-color: #7B230B;">
              il n'y a aucune enquête en cours
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-12">
        <h4>
          
          <br></br>
          <span class="fa fa-comment"></span> Résultats aux enquêtes:
        </h4>
        <?php if(isset($survey_responses) && $survey_responses != null): ?>
          <div class="list-group" style="border-color: #7B230B;">
            <?php foreach($survey_responses as $response): ?>
              <a href="<?php echo base_url() . "admin/response/" . $response->survey_slug . "/" . $response->id; ?>" class="list-group-item">
                <?php echo $response->survey_title; ?>
                <i class="text-muted"> <?php echo $response->email; ?></i>
                <span class="pull-right display-block-sm">
                  <span class="text-muted"> <?php echo date(strftime('%d-%m-%Y %H:%M:%S',strtotime($response->created))); ?></span>
                  <span class="fa fa-chevron-right"></span>
                </span>
              </a>
                </div>
            <?php endforeach; ?>
          <br/><br/>
        <?php else: ?>
          <div class="alert alert-secondary text-center" role="alert" style="border-color: #7B230B;">
              Personne n'a répondu à l'enquête.
          </div>
        <?php endif; ?>
        <br></br>
      </div>
    </div>
  </div>
  <br/> <div align="center"><h6><a class="btn btn-secondary btn-lg center-block"  href=" <?php echo base_url()."admin/chart"?>"> Analyse des enquêtes</a></h6></div><br/>