   <!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap core CSS -->
    
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<link href="bootstrap/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
  <div class="container">
      <div class="row my-4">
        <div class="col-lg-8">
        <img center class="img-fluid rounded" src="images/logo3.png" alt="">
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4" style= "text-align: center">
          <h1><b>Enquête de satisfaction OpenField</b></h1>
          <p>Vous avez récemment pris contact avec notre sevice-client et nous aimerions nous assurer que vous êtes satisfait par le service offert. 

      Le résultat nous permettra d'améliorer nos services. Vos réponses ne seront utilisées que dans le cadre de l’enquête menée par OpenField. 

      Merci de prendre un moment pour compléter cette enquête, y répondre vous prendra seulement 5 minutes.
    </p>
    
        <?php if(isset($active_surveys) && $active_surveys != null): ?>
          <div class="list-group">
            <?php foreach($active_surveys as $survey): ?>
              <a class="btn btn-secondary btn-lg" href="<?php echo base_url() . "questions/" . $survey->slug; ?>" class="list-group-item">
                <span class="fa fa-arrow-alt-circle-right"></span> Commencer le sondage
              </a>

            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="alert alert-danger text-center" role="alert">
              Aucun sondage
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
