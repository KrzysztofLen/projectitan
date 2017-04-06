<?php

  session_start();
  if(!$_SESSION['zalogowany']){ header("Location: index.php"); exit();}

  require_once('function.php');
  require_once('classes.php');

  if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $adres = $_POST['adres'];
    $miasto = $_POST['miasto'];
    $kod = $_POST['kod'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $pesel = $_POST['pesel'];



    $con = mysqli_connect("sql.hakkai.nazwa.pl","hakkai_2","Projectitan123","hakkai_2");
    mysqli_query($con,"SET CHARSET utf8");
     mysqli_query($con,"SET NAMES `utf8` COLLATE `utf8_polish_ci`");

     if (mysqli_connect_errno())
       {
       echo "Nie udało się połączyć z MySQL: " . mysqli_connect_error();
       }


    // sprawdza czy użytkownik istnieje w bazie danych
      $mysqli = mysqli_query($con,"SELECT COUNT(*) AS ile FROM dane_podstawowe WHERE pesel = '{$pesel}'");

      while ($row = mysqli_fetch_array($mysqli)) {
        $ile = $row['ile'];
      }

$error = "";


    // sprawdz imie

    $imieok = htmlspecialchars($imie, ENT_QUOTES, "UTF-8");

    $imiedobre = usunSpacje(maleLitery($imieok));


    if ($imiedobre == "") {

      $error .= error("Imię");

    } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $imiedobre)) {

      $error .= err("W imieniu mogą być tylko litery");

    }




// sprawdz nazwisko

  $nazwiskook = htmlspecialchars($nazwisko, ENT_QUOTES, "UTF-8");

  $nazwiskodobre = usunSpacje(maleLitery($nazwiskook));

  if($nazwiskodobre == "") {

    $error .= error("Nazwisko");

  } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $nazwiskodobre)) {

    $error .= err("W nazwisku mogą być tylko litery");
  }




// sprawdz adres

  $adresok = htmlspecialchars($adres, ENT_QUOTES, "UTF-8");

  if ($adresok == "") {

    $error .= error("Adres");

  }  elseif (!preg_match('/^([a-zA-Z0-9óąęśłżźćńÓĘĄŚŁŻŹĆŃ.\\s-\/]*)$/', $adresok)) {

    $error .= err("Błędny adres");

  }

// sprawdz miasto

  $miastook = htmlspecialchars($_POST['miasto'], ENT_QUOTES, "UTF-8");

  $miastodwa = dwuczlonowe($miastook);

  if ($miastodwa == "") {

  $error .= error('Miasto');

  } elseif (!preg_match('/^([a-zA-ZóąęśłżźćńÓĘĄŚŁŻŹĆŃ]*)$/', $miastodwa)) {

    $error .= err("W polu Miasto mogą znajdować się ino litery");

  }


// sprawdz kod pocztowy


  $postcode = htmlentities($kod, ENT_QUOTES, "UTF-8");

  $postcode1 = str_replace("-","", $postcode);

  $postcodelength = strlen($postcode1);


  if ($postcode == "") {

    $error .= error('Kod pocztowy');

  } elseif (!preg_match('/^([0-9-]*)$/', $postcode1)) {

    $error .= err("W Kodzie pocztowym mogą być tylko liczby");

  } elseif ($postcodelength < 5) {

    $error .= err("Kod pocztowy jest za krótki");

  } elseif ($postcodelength > 5){

    $error .= err("Kod pocztowy jest za długi");

  }

// walidacja telefon

$telefonOk = htmlentities($telefon, ENT_QUOTES, "UTF-8");

$telefonrep = str_replace("-","", $telefonOk);

$telefonlen = strlen($telefonrep);

  if ($telefonOk == "") {

    $error .= error("Telefon");

  } elseif (!preg_match('/^([0-9]*)$/', $telefonrep)) {

    $error .= err("W numerze telefonu mogą być tylko liczby");

  } elseif ($telefonlen > 9) {

    $error .= err("Za dużo cyfr");

  } elseif ($telefonlen < 9) {

    $error .= err("Za mało cyfr");

  }

// walidacja mail

  if ($email == "") {

    $error .= error("Email");

  } elseif (addMail($email)) {

    $error .= err("To nie jest poprawny email");

  } else {

    $email = $_POST['email'];

  }




// walidacja pesel

  $peselok = htmlentities($_POST['pesel'], ENT_QUOTES, "UTF-8");

  $pesellen = strlen($peselok);

  if ($peselok == "") {

    $error .= error("Pesel");

  } elseif (!preg_match('/^([0-9]*)$/', $peselok)) {

    $error .= err("W numerze pesel mogą być tylko liczby");

  } elseif ($pesellen > 11) {

    $error .= err("Pesel jest za długi");

  } elseif ($pesellen < 11) {

    $error .= err("Pesel jest za krótki");

  }


  // sprawdź czy wszystko ok

  if (!$error)
  {

    echo msg('<div class="alert alert-success" role="alert">Przesłano formularz</div>');

  } else {

    echo $error;

  }

  // sprawdza czy uzytkownik juz istnieje
  if ($ile != 0) {

      echo "<div class='alert alert-warning' role='alert'>Taki użytkownik już istnieje w bazie danych</div>";
  }




  if (!$error) {


    //dopisanie do bazy danych danych podstawowych(imie, nazwisko, adres, adres korespondencyjny, miasto, kod pocztowy, pesel)
    mysqli_query($con,"INSERT INTO dane_podstawowe (Imie,Nazwisko, Adres_zamieszkania, Miasto, Kod_pocztowy, PESEL)
    VALUES ('$imiedobre','$nazwiskodobre', '$adresok', '$miastodwa', '$postcode1', '$peselok')");

    $id =  mysqli_insert_id($con);



    // dopisanie do bazy danych danych do kontaktu(email, telefon)

    mysqli_query($con,"INSERT INTO kontakt(ID, Telefon, Email)VALUES('$id', '$telefonrep', '$email')");


  }



// zakończenie if'a przy sprawdzeniu czy metoda POST
}


 ?>




 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Osoba prywatna</title>
   </head>
   <body>

<div class="container">

  <form id="add_new_person" action="indexlog.php?rodzajklienta=prywatna&wyslij=Dodaj+nowego+klienta.php" method="post">

      <h1 class="header_search">Osoba prywatna</h1>

  <div class="col-sm-6 col-md-6">
    <div class="new_person_form">
        <label for="imie">Imię: </label>
        <input type="text" name="imie" class="form-control new_company" id="imie" size="30" placeholder="Imie" value="<?php if ($error) echo $imie ?>">
    </div>

    <div class="new_person_form">
        <label for="nazwisko">Nazwisko: </label>
        <input type="text" name="nazwisko" class="form-control new_company" id="nazwisko" size="30" placeholder="Nazwisko" value="<?php if ($error) echo $nazwisko ?>">
    </div>

    <div class="new_person_form">
        <label for="adres">Adres: </label>
        <input type="text" name="adres" class="form-control new_company" id="adres" size="30" placeholder="Ul. Krzywa 210/1" value="<?php if ($error) echo $adres ?>">
    </div>

    <div class="new_person_form">
        <label for="miasto">Miasto: </label>
        <input type="text" name="miasto" class="form-control new_company" id="miasto" size="30" placeholder="Miasto" value="<?php if ($error) echo $miasto; ?>">
    </div>
  </div>

  <div class="col-sm-6 col-md-6">
    <div class="new_person_form">
        <label for="kod">Kod pocztowy: </label>
        <input type="text" name="kod" class="form-control new_company" id="kod" size="10" placeholder="xx-xxx" value ="<?php if ($error) echo $kod; ?>">
    </div>

    <div class="new_person_form">
        <label for="telefon">Telefon: </label>
        <input type="text" name="telefon" class="form-control new_company" id="telefon" size="15" placeholder="123456789" value="<?php if ($error) echo $telefon;  ?>">
    </div>


    <div class="new_person_form">
        <label for="email">Email: </label>
        <input type="text" name="email" class="form-control new_company" id="email" size="30" placeholder="przykladowy@przyklad.pl" value="<?php if ($error) echo $email; ?>">
    </div>


    <div class="new_person_form">
        <label for="pesel">Pesel: </label>
        <input type="text" name="pesel" class="form-control new_company" id="pesel" size="30" placeholder="12345678910" value="<?php if ($error) echo $pesel; ?>">
    </div>
</div>

    <br><br>

    <div class="container">
      <input type="submit" name="wyslij" value="Wyślij" id="sending-btn1">
      <input type="submit" id="clear" name="wyczysc" value="Wyczyść pola">
    </div>


    </form>

    <!-- jQuery -->
    <script src="js/jquery-2.2.3.min.js"></script>

    <!-- Custom -->
    <script src="js/custom.js" charset="utf-8"></script>

   </body>
 </html>
