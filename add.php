<?php
session_start();
  if(!$_SESSION['zalogowany']){ header("Location: index.php"); exit();}


 ?>

<div class="container">
  <form action="indexlog.php?action=nowyklient" method="get">
    <div>
    <input type="radio" name="rodzajklienta" value="firma" id="firma" class="radio" checked>
      <label for="firma">Firma</label><br>
    </div>
<div>
    <input type="radio" name="rodzajklienta" value="prywatna" id="prywatna" class="radio">
      <label for="prywatna">Osoba prywatna</label><br>
</div>

  <input type="submit" id="add_new" name="wyslij" value="Dodaj nowego klienta">


  </form>
</div>
