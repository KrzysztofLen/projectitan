<?php


function error($msg) {

  $error = '<div class="alert alert-danger" role="alert">Wypełnij pole: '.$msg.'</div>';

  return $error;

}


function msg($msg) {

  $msg = '<span style = "color: green;">'.$msg.'</span>';
  return $msg;

}

function err($msg) {

  $result = '<div class="alert alert-danger" role="alert">Niepoprawny format: '.$msg.' </div>';
  return $result;

}




// Zamienia 232-333-24-34 na 2323332434
function correctNIP($NIP){

$tablica = str_split($NIP);

  foreach ($tablica as $value) {

 if($value != "-"){
 $poprawnyNIP .= $value;
  }
}
return $poprawnyNIP;
}


//Zamienia 2323332434 na 232-333-24-34
function correctNIP2($NIP){

$tablica = str_split($NIP);

foreach ($tablica as $key => $value) {

  if (($key == 3) || ($key == 6) || ($key == 8)) {
    $poprawnyNIP .= "-";
}

$poprawnyNIP .= $value;
}
return $poprawnyNIP;
}


//40-111
function correctKod($kod){
  $tablica = str_split($kod);

foreach ($tablica as $key => $value) {

  if($key == 2) {
    $poprawnyKod .= "-";
  }

$poprawnyKod .= $value;
}
return $poprawnyKod;

}

// zamienia male litery imienia na duze

function maleLitery ($small) {

  $nospace = str_replace(" ","", $small);

  if(in_array(('A'-'Z'), str_split($nospace))){
    $result = ucfirst(strtolower($nospace));
  }

  return $result;

}


// zamienia dwuczłonowe miasto na pierwszą dużą litere

function dwuczlonowe($male) {
  $tablica = explode(" ", $male);

  foreach ($tablica as $value) {
      $czlon[] = ucwords(strtolower($value));
  }

  $result = implode(" ", $czlon);
    return $result;
  }


// dodanie nowego maila

function addMail($mail) {

  $tablica = explode(";", $mail);

  foreach ($tablica as $key => $value) {
    if(filter_var($value, FILTER_VALIDATE_EMAIL) === false)
    {
      return true;
    }

  }



}

function usunSpacje($spacja) {

  $spacjabrak = str_replace(" ","", $spacja);

  return $spacjabrak;

}




 ?>
