<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
  header('Location: index.php');
  exit();
}

if($_GET['action'])
{
  $action = htmlspecialchars(trim($_GET['action']));
}

if (isset($_GET['nowyklient'])) {
  session_unset();

}


 ?>

<!-- Head HTML -->
<?php require_once("head.html") ?>
<!-- / head HTML  -->

   <body id="indexlog">



<?php

  $currenttime = date("H:i:s");

  // $newtime = new DateTime($_SESSION['czas']);
  // $utime = $newtime->format('U');

  $resulttime =  $currenttime - $utime;

  $lastlogintime = (int)($currenttime/60);

  echo $newtime;

  ?>

<div id="modal_dialog">
  <div class="cd-nugget-info">
    <h1>Witaj! Nie wiesz o co tu chodzi? Kliknij poniżej!</h1>
    <button id="cd-tour-trigger" class="cd-btn">Start tour</button>
  </div>
</div>


  	<ul class="cd-tour-wrapper">
  		<li class="cd-single-step">
  			<span>Step 1</span>

  			<div class="cd-more-info bottom">
  				<h2>Profil</h2>
  				<p>W tym miejscu znajdują się informacje o Twoim profilu, możesz również z tego miejsca się wylogować</p>
  				<img src="img/step-1.png" alt="step 1">
  			</div>
  		</li> <!-- .cd-single-step -->

  		<li class="cd-single-step">
  			<span>Step 2</span>

  			<div class="cd-more-info top">
  				<h2>Menu nawigacyjne</h2>
  				<p>Z tego elementu będziesz korzystał najczęściej. Tutaj możesz dodać nowego klienta do bazy danych, wyszukać osobę bądź firmę, a także znaleźć informacje kontaktowe czy wrócić do strony głównej.</p>
  				<img src="img/step-2.png" alt="step 2">
  			</div>
  		</li> <!-- .cd-single-step -->

  		<li class="cd-single-step">
  			<span>Step 3</span>

  			<div class="cd-more-info right">
  				<h2>Social panel</h2>
  				<p>W tym miejscu możesz zajrzeć na inne moje projekty na githubie czy obejrzeć mój profil na linkedIn.</p>
  				<img src="img/step-3.png" alt="step 3">
  			</div>
  		</li>

  	</ul>



      <div class="profile">
        <div class="profile-panel">
            <h1>Profile</h1>
        </div>
            <h1><i class="fa fa-user-secret" aria-hidden="true"></i>
            Witaj, <?php echo $_SESSION['login']  ?> !</h1>
            <p>Zalogowałeś się o: </p> <?php echo $currenttime; ?>
            <p>Od ostatniego logowania minęło: <?php echo $lastlogintime ?> minut!</p>

            <a href='logout.php'>Wyloguj się</a>
      </div>

<hr>



    <div class="social">
      <div class="social-panel">
        <h1>Social</h1>
      </div>
      <h1>Znajdź mnie na:</h1>
        <a href="https://pl.linkedin.com/in/krzysztoflen" target="_blank"><i class="fa fa-linkedin-square linkedin" aria-hidden="true"></i></a>
        <a href="https://github.com/KrzysztofLen" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>
    </div>


  <header>
        <div>

          <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                        <li class="add" role="presentation"><a href="indexlog.php?action=nowyklient" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus" aria-hidden="true"></i>Nowy klient</a></li>

                        <li class="search_person" role="presentation"><a href="indexlog.php?action=szukajosoby" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i>Szukaj osoby</a></li>

                        <li class="search_company" role="presentation"><a href="indexlog.php?action=szukajfirmy" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-industry" aria-hidden="true"></i>Szukaj firmy</a></li>

                        <!-- <li><a href="indexlog.php?action=dodajuzytkownika">Dodaj użytkownika</a></li> -->

                        <li class="contact" role="presentation"><a href="#" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-mobile" aria-hidden="true"></i>Kontakt</a></li>

                        <li class="return" role="presentation"><a href="indexlog.php" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-backward" aria-hidden="true"></i>Powrót</a></li>

                      </ul>

        </div>
      </header>

     <?php



     switch ($action) {
       case 'nowyklient':
         require_once("add.php");

         break;

       case 'szukajosoby':
         require_once("wyszukajosoba.php");
         break;

       case 'szukajfirmy':
         require_once("wyszukajfirma.php");
         break;
     }


     if ($_GET['rodzajklienta'] == "firma" ) {

       require_once('firma.php');

     } elseif ($_GET['rodzajklienta'] == "prywatna") {

       require_once('prywatna.php');

     }

      ?>


      <script>

      $(document).ready(function() {

        $("#cd-tour-trigger").on('click', function() {
          $(this).off('click');
        });

        $(".social").fadeIn(1000);
        $(".social").slideDown();
      });

      </script>



   </body>
  </html>
