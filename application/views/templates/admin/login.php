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
    <title>OpenField - Se connecter</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
</head>
    <body>
  <div class="bg-full bg-1"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="login-pane">
          <?php if(isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php foreach($errors as $error): ?>
                <li>
                  <?php echo $error; ?>
                </li>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <br></br><h4>
            <span class="fa fa-user"></span>
            Connexion
          </h4><br></br>
          <form role="form" method="post" action="<?php echo base_url(); ?>admin/login">
            <div class="form-group">
              <label for="email">Adresse mail:</label>
              <input type="email" class="form-control" id="email" placeholder="Saisir votre email" name="login-email" value="<?php echo ((isset($_POST["login-email"])) ? $_POST["login-email"] : ""); ?>">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe:</label>
              <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="login-password">
            </div>
            <button type="submit" class="btn btn-default" value="login-submit">
              Se connecter
            </button><br></br>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>