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
    <title>OpenField - Enquête de satisfaction</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> 
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?> assets/css/small-business.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


  </head>

  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php if(isset($valid_survey) && $valid_survey && isset($show_questions) && $show_questions): ?>
          <b><h2 class="text-center">
            <div style="border: 2px solid #000; padding: 3px; background-color: #fff; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px; -moz-border-radius-bottomright: 5px; -moz-border-radius-bottomleft: 5px;"><?php echo ((isset($survey_title)) ? $survey_title : "Sans titre"); ?></b></div></h2>
            <small class="show">
              <h4><?php echo ((isset($survey_subtitle)) ? $survey_subtitle : ""); ?></h4>
            </small>
          
          <?php if(isset($survey_errors) && $survey_errors): ?>
            <div class="alert alert-danger" role="alert">
              <strong>
                Erreur<?php echo ((sizeof($errors) > 1) ? "s" : "" );?>:
              </strong>
              <ul>
                <?php foreach($errors as $error): ?>
                  <li>
                    <?php echo $error; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
         
          <form role="form" method="post" class="survey-form clearfix">
            <div class="form-group">
              <label for="email_field">
                Adresse email <small>(Optionnel)</small>
              </label>
              <input
                type="text"
                class="form-control"
                id="email_field"
                name="email_field"
                placeholder="Saisir votre adresse email"
                value=""
                autofocus>
            </div>
            <?php foreach($questions as $question): ?>
              <?php if($question->question_type == 0): 
              ?>

                <div class="form-group">
                  <label>
                      <?php echo ((!empty($question->helper_text)) ? $question->helper_text : "") .
                       $question->question_text . " <small>" .
                      (($question->required) ? " (Obligatoire) " : "") . "</small>"; ?>
                  </label>
                  <?php foreach($question->options as $option): ?>
                    <div class="radio">
                      <label>
                        <input 
                          type="radio"
                          name="question_<?php echo $question->id; ?>"
                          id="question_<?php echo $question->id . "_option" . $option->id; ?>"
                          value="<?php echo $option->id; ?>"
                          <?php echo ((isset($_POST["question_" . $question->id]) && $_POST["question_" . $question->id] == $option->id) ? "checked" : "" ); ?> >
                        <?php echo $option->option_text; ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if($question->question_type == 1): ?>
                <div class="form-group">
                  <label>
                    <?php echo $question->question_text . " <small>" .
                      ((!empty($question->helper_text)) ? $question->helper_text : "") .
                      (($question->required) ? " (Obligatoire) " : "") . "</small>"; ?>
                  </label>
                  <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Saisir la réponse" 
                    name="question_<?php echo $question->id; ?>" 
                    id="question_<?php echo $question->id; ?>" 
                    value="<?php echo ((isset($_POST["question_" . $question->id]) && !empty($_POST["question_" . $question->id])) ? $_POST["question_" . $question->id] : "" ); ?>">
                </div>
              <?php endif; ?>
              <?php if($question->question_type == 2): ?>
                <div class="form-group">
                  <label>
                    <?php echo $question->question_text . " <small>" .
                      ((!empty($question->helper_text)) ? $question->helper_text : "") .
                      (($question->required) ? " (Obligatoire) " : "") . "</small>"; ?>
                  </label>
                  <textarea 
                    class="form-control"
                    rows="3"
                    placeholder="Saisir votre réponse"
                    name="question_<?php echo $question->id; ?>"
                    id="question_<?php echo $question->id; ?>"
                    value=""><?php 
                      echo ((isset($_POST["question_" . $question->id]) && !empty($_POST["question_" . $question->id])) ? $_POST["question_" . $question->id] : "" ); 
                    ?></textarea>
                </div>
              <?php endif; ?>
              <?php if($question->question_type == 3): ?>
                <div class="form-group">
                  <label>
                    <?php echo $question->question_text . " <small>" .
                      ((!empty($question->helper_text)) ? $question->helper_text : "") .
                      (($question->required) ? " (Obligatoire) " : "") . "</small>"; ?>
                  </label>
                  <?php foreach($question->options as $option): ?>
                    <div class="checkbox">
                      <label>
                        <input 
                          type="checkbox"
                          name="question_<?php echo $question->id; ?>[]"
                          id="question_<?php echo $question->id . "_option" . $option->id; ?>"
                          value="<?php echo $option->id; ?>"
                          <?php echo ((isset($_POST["question_" . $question->id]) && $_POST["question_" . $question->id] == $option->id) ? "checked" : "" ); ?> >
                        <?php echo $option->option_text; ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-lg btn-secondary pull-right">Envoyer</button>
          </form><br></br>
        <?php elseif(isset($valid_survey) && $valid_survey && !(isset($survey_errors) && $survey_errors)): ?>
          <div class="alert alert-secondary text-center" role="alert">

              Merci d'avoir complété notre enquête de satisfaction.
          </div>
        <?php else: ?>
          <div class="alert alert-danger text-center" role="alert">

              L'enquête n'existe pas
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
