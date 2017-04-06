<?php
session_start();
  if(!$_SESSION['zalogowany']){ header("Location: index.php"); exit();}
  require_once('classes.php');


  if ($_SERVER['REQUEST_METHOD'] == "POST") {


  $polaczenie = new DbDriver('sql.hakkai.nazwa.pl', 'hakkai_2', 'Projectitan123', 'hakkai_2');


   $query = "SELECT * FROM dane_podstawowe";

   $imie = htmlentities(trim($_POST['imie']));
   $nazwisko = htmlentities(trim($_POST['nazwisko']));
   $adres = htmlentities(trim($_POST['adres']));
   $miasto = htmlentities(trim($_POST['miasto']));
   $kod = htmlentities(trim($_POST['kod']));
   $pesel = htmlentities(trim($_POST['pesel']));



   if (!empty($imie) || (!empty($nazwisko) || (!empty($adres) || (!empty($miasto) || (!empty($kod) || (!empty($pesel))))))) {

     $query .= " WHERE";
   }





  if (!empty($imie)) {

     $query .= " Imie LIKE '%{$imie}%' AND";
     $pomoc = true;

   }

   if (!empty($nazwisko)) {

     $query .= " Nazwisko LIKE '%{$nazwisko}%' AND";
     $pomoc = true;

   }

   if (!empty($adres)) {

     $query .= " Adres_zamieszkania LIKE '%{$adres}%' AND";
     $pomoc = true;

   }
   if (!empty($miasto)) {

     $query .= " Miasto LIKE '%{$miasto}%' AND";
     $pomoc = true;

   }
   if (!empty($kod)) {

     $query .= " Kod_pocztowy LIKE '%{$kod}%' AND";
     $pomoc = true;

   }

   if (!empty($pesel)) {

     $query .= " PESEL LIKE '%{$pesel}%' AND";
     $pomoc = true;

   }



if($pomoc)
{
$query = substr($query, 0,-3);
}


   $polaczenie->runQuery($query);
   $row = $polaczenie->getFullList();


   $table .= "<tr class='table_label'><td>Imie</td>";
   $table .= "<td>Nazwisko</td>";
   $table .= "<td>Adres</td>";
   $table .= "<td>Miasto</td>";
   $table .= "<td>Kod pocztowy</td>";
   $table .= "<td>Pesel</td></tr>";

   foreach ($row as $value) {

       $table .= "<tr>
       <td class='name_table'>" . $value['Imie'] . "</td>";

       $table .= "<td class='surname_table'>" . $value['Nazwisko'] . "</td>";

       $table .= "<td class='adress_table'>" . $value['Adres_zamieszkania'] . "</td>";

       $table .= "<td class='city_table'>" . $value['Miasto'] . "</td>";

       $table .= "<td class='post_code_table'>" . $value['Kod_pocztowy'] . "</td>";

       $table .= "<td class='id_table'>" . $value['PESEL'] . "</td>";

       $table .= "</tr>";

    }


}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
    </title>
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

  </head>
  <body>

    <div class="container">
      <form id="search_person_form" method="post">

        <h1 class="header_search">Osoba prywatna</h1>

          <div class="col-sm-6 col-md-6">
            <div class="form-group">
              <label for="imie">Imie </label>
              <input type="text" class="form-control" name="imie" id="imie" size="30" value ="<?php echo $imie; ?>">
            </div>

            <div class="form-group">
              <label for="nazwisko">Nazwisko: </label>
              <input type="text" class="form-control" name="nazwisko" id="nazwisko" size="30" value ="<?php echo $nazwisko; ?>">
            </div>

            <div class="form-group">
              <label for="adres">Adres: </label>
              <input type="text" class="form-control" name="adres" id="adres" size="30" value ="<?php echo $adres; ?>">
            </div>
          </div> <!-- ./col-md-6 -->

          <div class="col-sm-6 col-md-6">
            <div class="form-group">
              <label for="miasto">Miasto: </label>
              <input type="text" class="form-control" name="miasto" id="miasto" size="30" value ="<?php echo $miasto; ?>">
            </div>

            <div class="form-group">
              <label for="kod">Kod pocztowy: </label>
              <input type="text" class="form-control" name="kod" id="kod" size="10" value ="<?php  echo $kod; ?>">
            </div>

            <div class="form-group">
              <label for="pesel">Pesel: </label>
              <input type="text" class="form-control" name="pesel" id="pesel" size="15" value ="<?php echo $pesel; ?>">
            </div>
          </div><!-- ./col-md-6 -->
        <input type="submit" name="wyslij" value="Szukaj" id="search">
        <input type="submit" id="clear" name="wyczysc" value="Wyczyść pola">

        </form>

<br><br>

  <!-- Custom -->
  <script src="js/custom.js" charset="utf-8"></script>

  <table id="search_person_table" class="table table-hover">

    <?php echo $table; ?>

    </table>
</div> <!-- ./container -->

  </body>
</html>
