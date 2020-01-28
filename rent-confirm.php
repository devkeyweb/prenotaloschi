<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="robots" content="noindex, nofollow">

  <!-- bootstrap css -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>

  <div id="loading">loading...</div>

  <?php include "header.php"; ?>

  <!-- Page Content -->
  <form action="#" method="post" name="selection-form" id="selection-form" >

  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="page-title">Prenotazione servizio Traslochi Loschi  . STEP 1</h1>
      </div>

      <div class="col-lg-4 col-xs-12">
        <h2>Inserisci dati servizio</h2>

        <h3>Piano da raggiungere</h3>
        <select id="piano" name="piano" autocomplete="off" class="select-css" >
            <option value="0">Piano terra</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
          <option value="12">12</option>
        </select><br/>

        <h3>Peso da movimentare</h3>
        <select id="peso" name="peso" autocomplete="off" class="select-css" >
          <option value="200">0 - 200Kg</option>
          <option value="300">201 - 300Kg</option>
          <option value="400">301 - 400Kg</option>
        </select><br/>

        <h3>Altezza ingresso</h3>
        <select id="hingresso" name="hingresso" autocomplete="off" class="select-css" >
          <option value="281">da 1,55m a 2,80m</option>
          <option value="289">da 2,80m a 2,89m</option>
          <option value="290">oltre 2,90m</option>
        </select><br/>

        <h3>Larghezza ingresso</h3>
        <select id="wingresso" name="wingresso" autocomplete="off" class="select-css" >
          <option value="181">da 1,55m a 1,81m</option>
          <option value="192">da 1,82m a 1,92m</option>
          <option value="193">oltre 1,93m</option>
        </select><br/><br/>

      </div> <!-- /col-lg-4 -->

      <div class="col-lg-4 col-xs-12">

        <h2>Luogo richiesta servizio</h2>
        <h3>Città</h3>
        <select id="citta" name="citta" autocomplete="off" class="select-css" ><br/>
          <option value="Modena">Modena (+1h)</option>
          <option value="Bologna">Bologna (+2h)</option>
          <option value="Reggio Emilia">Reggio Emilia (+1h)</option>
          <option value="Milano">Milano (+3h)</option>
        </select><br/>

        <h3>Indirizzo *</h3>
        <input type="text" id="indirizzo" name="indirizzo"  placeholder="Via Lorem Ipsum, 23" ></input>
        <br/>

      </div> <!-- /col-lg-4 -->

      <div class="col-lg-4 col-xs-12">

        <h2>Vincoli Speciali *</h2>
        <input type="checkbox" name="checkbox-1-1" value="0" class="regular-checkbox" id="checkbox-1-1" /> <label class="ckLabel" for="checkbox-1-1">Centri storici</label><br>
        <input type="checkbox" name="checkbox-1-2" value="1" class="regular-checkbox" id="checkbox-1-2" /> <label class="ckLabel" for="checkbox-1-2">Zone pedonali</label><br>
        <input type="checkbox" name="checkbox-1-3" value="2" class="regular-checkbox" id="checkbox-1-3" /> <label class="ckLabel" for="checkbox-1-3">Richiesta autorizzazione luogo pubblico</label><br>
        <br/><br/><br/>
        <div class="form-group">
            <input type="checkbox" class="form-checkbox" name="checkPrivacy" id="checkPrivacy" >
            <strong>Dichiaro di aver letto l'<a href="#">Informativa</a> sul trattamento dei dati personali (Art. 13 del D.lgs. 196/2003)</strong>
        </div>

      </div> <!-- /col-lg-4 -->

    </div> <!-- /row -->

    <div class="row">    
      <div class="col-lg-12">
        <div class="stepButton">
          <!-- <a href="#" class="btBack" >Torna indietro</a> -->
          <button type="button" class="btNext" id="submit-btn-top" >Passo successivo</button>
         </div>
      </div>

    </div> <!-- /row -->
  </div> <!-- /container -->

  </form>

  <?php include "footer.php"; ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    $( document ).ready(function() {
      'use strict';

      $('#loading').hide();

      //$('#response_input_area_top').html("");

      var dataString;

      /* FORM TOP CLICK */
      $('#submit-btn-top').on('click', function(){

        var boolValidation = 0;
        var msgValidation  = new Array();

        /* var nameRequest= $('#nameTop').val();
        nameRequest = $.trim(nameRequest);
        var emailRequest = $('#emailTop').val();
        emailRequest = $.trim(emailRequest); */

        var authPrivacy = 0;
        //if(document.getElementById("checkPrivacy").checked == true){ authPrivacy = 1; }  // checkbox privacy
        if(authPrivacy != 1){
          boolValidation++;
          msgValidation.push("Autorizzazione privacy obbligatoria!");
        } 

        var vincoliCheck = 0;
        if(document.getElementById("checkbox-1-1").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-1
        if(document.getElementById("checkbox-1-2").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-2
        if(document.getElementById("checkbox-1-3").checked == true){ 
          vincoliCheck += 1; }  // checkbox vincolo 1-3

        

        /* if( nameRequest.length === 0 ) {
          boolValidation++;
          msgValidation.push("Campo nome obbligatorio!");
          if(!$("#nameTop").hasClass('is-invalid')) {
            $("#nameTop").addClass("is-invalid");
          }
        } else {
          if(!$("#nameTop").hasClass('is-valid')) {
            $("#nameTop").addClass("is-valid");
          }
        }

        if( emailRequest.length === 0 ) {
          boolValidation++;
          msgValidation.push("Campo email obbligatorio!");
          if(!$("#emailTop").hasClass('is-invalid')) {
            $("#emailTop").addClass("is-invalid");
          }
        } else {
          if(ValidateEmail(emailRequest)) {
            if(!$("#emailTop").hasClass('is-valid')) {
              $("#emailTop").addClass("is-valid");
            }
          } else {
            boolValidation++;
            msgValidation.push("Campo email non valido!");
            if(!$("#emailTop").hasClass('is-invalid')) {
              $("#emailTop").addClass("is-invalid");
            }
          }
        } */


        if(vincoliCheck > 0){ // sono stati selezionati vincoli
          console.log("sono stati selezionati vincoli");
          document.getElementById("selection-form").action = "rent-request.php";
          document.getElementById("selection-form").submit();
        } else { // NON sono stati selezionati vincoli
          // $('.response_input_area_top').html("<i class=\"fa fa-warning\" style=\"color: #c50a0a; font-weight: bold; font-size: 24px;\"></i><br/><span style=\"color: #c50a0a; font-weight: bold; font-size: 14px;\">"+msgValidation.join()+"</span>");
          console.log("NON sono stati selezionati vincoli");
          document.getElementById("selection-form").action = "item-selection.php";
          document.getElementById("selection-form").submit();
        }

      });

    });

  </script>

</body>
</html>





