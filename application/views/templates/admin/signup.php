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
    <title>OpenField - S'enregistrer</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


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
          <h4 class="text-center">
            <span class="glyphicon glyphicon-user"></span>
            Créer un compte Administrateur
          </h4>
          <form role="form" method="post" action="signup">
            <div class="form-group">
              <label for="email">Adresse mail</label>
              <input type="email" class="form-control" id="email" placeholder="Adresse mail" name="signup-email" value="<?php echo ((isset($_POST["signup-email"])) ? $_POST["signup-email"] : ""); ?>">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="signup-password">
            </div>
            <button type="submit" class="btn btn-default" value="signup-submit">
              Créer
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>