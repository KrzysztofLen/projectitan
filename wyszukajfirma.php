<?php
session_start();
  if(!$_SESSION['zalogowany']){ header("Location: index.php"); exit();}

  require_once('classes.php');

  if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $polaczenie = new DbDriver("sql.hakkai.nazwa.pl","hakkai_3","Projectitan123","hakkai_3");


     $query = "SELECT * FROM dane_podstawowe
     LEFT JOIN osoba_do_kontaktu ON osoba_do_kontaktu.ID = dane_podstawowe.ID
     LEFT JOIN mail_kontakt ON mail_kontakt.ID = dane_podstawowe.ID
     LEFT JOIN telefon_kontakt ON telefon_kontakt.ID = dane_podstawowe.ID
     LEFT JOIN adres_siedziby ON adres_siedziby.ID = dane_podstawowe.ID";

     $nazwa = htmlspecialchars(trim($_POST['nazwa']));
     $nip = htmlspecialchars(trim($_POST['nip']));
     $imie = htmlspecialchars(trim($_POST['imie']));
     $nazwisko = htmlspecialchars(trim($_POST['nazwisko']));
     $mail = htmlspecialchars(trim($_POST['mail']));
     $telefon = htmlspecialchars(trim($_POST['telefon']));
     $miasto = htmlspecialchars(trim($_POST['miasto']));
     $adres = htmlspecialchars(trim($_POST['adres']));
     $kod = htmlspecialchars(trim($_POST['kod']));


     if (!empty($nazwa) || (!empty($nip) || (!empty($imie) || (!empty($nazwisko) || (!empty($mail) || (!empty($telefon) || (!empty($miasto) || (!empty($adres) || (!empty($kod)))))))))) {

       $query .= " WHERE";

     }

     if (!empty($nazwa)) {

       $query .= " Nazwa_firmy LIKE '%{$nazwa}%' AND";
       $help = true;

     }

     if (!empty($imie)) {

       $query .= " imie_kontakt LIKE '%{$imie}%' AND";
       $help = true;

     }


     if (!empty($nip)) {

       $query .= " NIP LIKE '%{$nip}%' AND";
       $help = true;

     }

     if (!empty($nazwisko)) {

       $query .= " nazwisko_kontakt LIKE '%{$nazwisko}%' AND";
       $help = true;

     }

     if (!empty($mail)) {

       $query .= " mail_kontakt LIKE '%{$mail}%' AND";
       $help = true;

     }

     if (!empty($telefon)) {

       $query .= " Telefon LIKE '%{$telefon}%' AND";
       $help = true;

     }

     if (!empty($miasto)) {

       $query .= " miasto_siedziby LIKE '%{$miasto}%' AND";
       $help = true;

     }

     if (!empty($adres)) {

       $query .= " adres_siedziby LIKE '%{$adres}%' AND";
       $help = true;

     }

     if (!empty($kod)) {

       $query .= " kod_pocztowy_siedziby LIKE '%{$kod}%' AND";
       $help = true;

     }


     if ($help) {

      $query = substr($query, 0,-3);

     }


     $polaczenie->runQuery($query);
     $row = $polaczenie->getFullList();


     $table = "<tr class='table_label'><td>Nazwa firmy</td>";
     $table .= "<td>NIP</td>";
     $table .= "<td>Imię os. kontakt.</td>";
     $table .= "<td>Nazwisko os. kontakt.</td>";
     $table .= "<td>Mail</td>";
     $table .= "<td>Telefon</td>";
     $table .= "<td>Miasto siedziby</td>";
     $table .= "<td>Adres siedziby</td>";
     $table .= "<td>Kod pocztowy</td></tr>";

     foreach ($row as $value) {



         $table .= "<tr>
         <td class='company_name'>" . $value['Nazwa_firmy'] . "</td>";
         $table .= "<td class='company_name'>" . $value['NIP'] . "</td>";
         $table .= "<td class='company_name'>" . $value['imie_kontakt'] . "</td>";
         $table .= "<td class='company_name'>" . $value['nazwisko_kontakt'] . "</td>";
         $table .= "<td class='company_name'>" . $value['mail_kontakt'] . "</td>";
         $table .= "<td class='company_name'>" . $value['Telefon'] . "</td>";
         $table .= "<td class='company_name'>" . $value['miasto_siedziby'] . "</td>";
         $table .= "<td class='company_name'>" . $value['adres_siedziby'] . "</td>";
         $table .= "<td class='company_name'>" . $value['kod_pocztowy_siedziby'] . "</td>";

         $table .= "</tr>";

      }


  }

  require_once("head.html");


 ?>


  <div class="container">
     <form id="search_company_form" method="post">

        <h1 class="header_search">Firma</h1>

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
               <label for="nazwa">Nazwa firmy: </label>
               <input type="text" class="form-control" name="nazwa" id="nazwa" size="30" value ="<?php echo $nazwa; ?>">
           </div>

        <div class="form-group">
            <label for="nip">NIP: </label>
            <input type="text" class="form-control" name="nip" id="nip" size="30" value ="<?php echo $nip; ?>">
        </div>

        <div class="form-group">
            <label for="imie">Imię os. kontakt.: </label>
            <input type="text" class="form-control" name="imie" id="imie" size="30" value ="<?php echo $imie; ?>">
          </div>

          <div class="form-group">
             <label for="nazwisko">Nazwisko os. kontakt.: </label>
             <input type="text" class="form-control" name="nazwisko" id="nazwisko" size="30" value ="<?php echo $nazwisko; ?>">
           </div>
          </div> <!-- ./col-md-6 -->

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
             <label for="mail">Mail: </label>
             <input type="text" class="form-control" name="mail" id="mail" size="15" value ="<?php echo $mail; ?>">
           </div>

         <div class="col-sm-6 col-md-6">
            <div class="form-group short_value">
                   <label for="telefon">Telefon: </label>
                   <input type="text" class="form-control" name="telefon" id="telefon" value ="<?php echo $telefon; ?>">
            </div>
          </div>

          <div class="col-sm-6 col-md-6">
            <div class="form-group short_value">
              <label for="kod">Kod pocztowy: </label>
              <input type="text" class="form-control" name="kod" id="kod" size="5" value ="<?php echo $kod; ?>">
            </div>
          </div>

        <div class="form-group">
          <label for="miasto">Miasto siedziby: </label>
          <input type="text" class="form-control" name="miasto" id="miasto" value ="<?php echo $miasto; ?>">
        </div>

        <div class="form-group">
          <label for="adres">Adres siedziby: </label>
          <input type="text" class="form-control" name="adres" id="adres" size="15" value ="<?php echo $adres; ?>">
        </div>


      </div>

         </table>

         <br><br>

         <input type="submit" name="wyslij" value="Szukaj" id="search">
         <input type="submit" id="clear" name="wyczysc" value="Wyczyść pola">

         </form>

         <br><br>

         <script>

         $("#clear").click(function() {
          $("input").val('');
         })

         </script>

    <table id="search_company_table" class="table table-hover">

     <?php echo $table; ?>

    </table>
</div> <!-- ./container -->
