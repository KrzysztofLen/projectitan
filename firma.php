<?php
session_start();
  if(!$_SESSION['zalogowany']){ header("Location: index.php"); exit();}

require_once('function.php');
require_once('classes.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $nazwa = $_POST['nazwa'];
  $adres = $_POST['adres'];
  $miasto = $_POST['miasto'];
  $kod = $_POST['kod'];
  $nip = $_POST['nip'];
  $imie = $_POST['imie'];
  $nazwisko = $_POST['nazwisko'];
  $telefon = $_POST['telefon'];
  $email = $_POST['email'];



  $con = mysqli_connect("sql.hakkai.nazwa.pl","hakkai_3","Projectitan123","hakkai_3");
  mysqli_query($con,"SET CHARSET utf8");
   mysqli_query($con,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

  if (mysqli_connect_errno())
    {
    echo "Nie udało się połączyć z MySQL: " . mysqli_connect_error();
    }


$error = "";


// sprawdza czy użytkownik istnieje w bazie danych
  $mysqli = mysqli_query($con,"SELECT COUNT(*) AS ile FROM dane_podstawowe WHERE nip = '{$nip}'");


  while ($row = mysqli_fetch_array($mysqli)) {
    $ile = $row['ile'];
  }


// walidacja nazwy firmy

  $nazwaOk = htmlspecialchars($nazwa, ENT_QUOTES, "UTF-8");

  if ($nazwaOk == "") {

    $error .= error("Nazwa firmy");

  }

// walidacja adresu siedziby

  $adresOk = htmlspecialchars($adres, ENT_QUOTES, "UTF-8");

  if ($adresOk == "") {

  $error .= error("Adres");

  } elseif (!preg_match('/^([a-zA-Z0-9óąęśłżźćńÓĘĄŚŁŻŹĆŃ.\\s-\/]*)$/', $adresOk)) {

    $error .= err("Błędny adres");

  }



// walidacja miasto

  $miastook = htmlspecialchars($miasto, ENT_QUOTES, "UTF-8");

  $miastodwa = dwuczlonowe($miastook);

  if ($miastodwa == "") {

    $error .= error('Miasto');

  } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $miastodwa)) {

    $error .= err("W polu Miasto mogą znajdować się ino litery");

  }



// walidacja kod pocztowy

$postcode = htmlentities($kod, ENT_QUOTES, "UTF-8");

$postcode1 = str_replace("-","", $postcode);

$postcodelength = strlen($postcode1);


if ($postcode == "") {

  $error .= error("Kod pocztowy");

} elseif (!preg_match('/^([0-9-]*)$/', $postcode1)) {

  $error .= err("W Kodzie pocztowym mogą być tylko liczby");

} elseif ($postcodelength < 5) {

  $error .= err("Kod pocztowy jest za krótki");

} elseif ($postcodelength > 5){

  $error .= err("Kod pocztowy jest za długi");

}


// walidacja NIPu


  $nipOk = htmlentities($nip, ENT_QUOTES, "UTF-8");

  $niprep = str_replace("-","", $nipOk);

  $niplen = strlen($niprep);


  if ($nipOk == "") {

    $error .= error("NIP");

  } elseif (!preg_match('/^([0-9]*)$/', $niprep)) {

    $error .= err("W NIPie mogą być tylko liczby");

  } elseif ($niplen < 10) {

    $error .= err("NIP za krótki");

  } elseif ($niplen > 10) {

    $error .= err("NIP za długi");

  }




// walidacja imienia

  $imieOk = htmlspecialchars($imie, ENT_QUOTES, "UTF-8");

  $imiedobre = usunSpacje(maleLitery($imieOk));

  if ($imie == "") {

    $error .= error("Imię");

  } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $imiedobre)) {

    $error .= err("W Imieniu mogą być tylko litery");

  }




// walidacja nazwisko

  $nazwiskoOk = htmlspecialchars($nazwisko, ENT_QUOTES, "UTF-8");

  $nazwiskodobre = usunSpacje(maleLitery($nazwiskoOk));

  if ($nazwiskodobre == "") {

  $error .= error("Nazwisko");

  } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $nazwiskodobre)) {

  $error .= err("W Nazwisku mogą być tylko litery");

}



// walidacja telefonu

$telefonOk = htmlentities($telefon, ENT_QUOTES, "UTF-8");

$telefonreplace = str_replace("-","", $telefonOk);

$telefonlength = strlen($telefonreplace);

  if ($telefonOk == "") {

    $error .= error("Telefon");

  } elseif (!preg_match('/^([0-9]*)$/', $telefonreplace)) {

    $error .= err("W numerze telefonu mogą być tylko liczby");

  } elseif ($telefonlength > 9) {

    $error .= err("Za dużo cyfr");

  } elseif ($telefonlength < 9) {

    $error .= err("Za mało cyfr");

  }

// walidacja email

  if ($email == "") {

    $error .= error("Email");

  } elseif (addMail($email)) {

    $error .= err("To nie jest poprawny email");

  }
// sprawdź wszystko_OK

  if (!$error)
  {

    echo msg("<div class='alert alert-success' role='alert'>Przesłano formularz</div>");

  } else {

    echo $error;

  }

  // sprawdza czy uzytkownik juz istnieje
  if ($ile != 0) {

      echo "<div class='alert alert-warning' role='alert'>Taki użytkownik już istnieje w bazie danych</div>";
  }





    if (!$error) {


      //dopisanie do bazy danych danych podstawowych(nazwa, nip)
      mysqli_query($con,"INSERT INTO dane_podstawowe (Nazwa_firmy,NIP)
      VALUES ('$nazwaOk','$niprep')");

      $id =  mysqli_insert_id($con);

      // dopisanie do bazy danych danych do kontaktu(imie, nazwisko)

      mysqli_query($con,"INSERT INTO osoba_do_kontaktu(ID,imie_kontakt, nazwisko_kontakt)VALUES('$id', '$imiedobre', '$nazwiskodobre')");

      // dopisanie do bazy danych danych firmy(adres, kod, miasto)

      mysqli_query($con,"INSERT INTO adres_siedziby(ID,miasto_siedziby, adres_siedziby, kod_pocztowy_siedziby)VALUES('$id', '$miastodwa', '$adresOk', '$postcode1')");

      // dopisanie do bazy danych kontaktu telefon

      mysqli_query($con,"INSERT INTO telefon_kontakt(ID,Telefon)VALUES('$id', '$telefonreplace')");

      // dopisanie do bazy danych kontaktu email
      mysqli_query($con,"INSERT INTO mail_kontakt(ID,mail_kontakt)VALUES('$id', '$email')");

    }



// zakończenie if'a przy sprawdzeniu czy metoda POST
}

 ?>



 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Firma</title>

   </head>
   <body>


<div class="container">

  <form id="add_new_company" action="indexlog.php?rodzajklienta=firma&wyslij=Dodaj+nowego+klienta.php" method="post">

        <h1 class="header_search">Dodaj nową firmę</h1>

      <div class="col-sm-6 col-md-6">
        <h5 class="new_company-description">Dane firmy</h3>
        <div class="new_company_form">
            <label for="nazwa">Nazwa firmy: </label>
            <input type="text" class="form-control new_company" name="nazwa" id="nazwa" placeholder="Przykładowa nazwa firmy" value="<?php echo $nazwa; ?>">
          </div>


        <div class="new_company_form">
            <label for="adres">Adres siedziby: </label>
            <input type="text" name="adres" class="form-control new_company" id="adres" size="30" placeholder="ul. Przykładowa 12/10" value="<?php echo $adres; ?>">
          </div>

        <div class="new_company_form">
          <label for="miasto">Miasto: </label>
          <input type="text" class="form-control new_company" name="miasto" id="miasto" size="30" placeholder="Miasto" value="<?php echo $miasto; ?>">
        </div>

        <div class="new_company_form">
          <label for="kod">Kod pocztowy: </label>
          <input type="text" class="form-control new_company" name="kod" id="kod" size="10" placeholder="xx-xxx" value="<?php echo $kod; ?>">
        </div>

        <div class="new_company_form">
          <label for="nip">NIP: </label>
          <input type="text" class="form-control new_company" name="nip" id="nip" size="15" placeholder="1234567890" value="<?php echo $nip; ?>">
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <h5 class="new_company-description">Dane osoby do kontaktu</h4>
          <div class="new_company_form">
              <label for="imie"> Imię: </label>
              <input type="text" class="form-control new_company" name="imie" id="imie" size="30" placeholder="Imie" value="<?php echo $imie; ?>">
          </div>

        <div class="new_company_form">
            <label for="nazwisko">Nazwisko: </label>
            <input type="text" class="form-control new_company" name="nazwisko" id="nazwisko" size="30" placeholder="Nazwisko" value="<?php echo $nazwisko; ?>">
        </div>

        <div class="new_company_form">
            <label for="telefon">Telefon: </label>
            <input type="text" class="form-control new_company" name="telefon" id="telefon" size="15" placeholder="123456789" value="<?php echo $telefon; ?>">
        </div>

        <div class="new_company_form">
            <label for="email">Email: </label>
            <input type="text" class="form-control new_company" name="email" id="email" size="30" placeholder="przykladowy@przyklad.pl" value="<?php echo $email; ?>">
        </div>
      </div>

    <div class="container">
      <input type="submit" name="wyslij" value="Wyślij" id="sending-btn">
      <input type="submit" id="clear" name="wyczysc" value="Wyczyść pola">
    </div>


    </form>

    <!-- jQuery -->
    <script src="js/jquery-2.2.3.min.js"></script>

    <!-- Custom -->
    <script src="js/custom.js" charset="utf-8"></script>


   </body>
 </html>
