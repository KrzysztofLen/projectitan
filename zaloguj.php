<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<?php
if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {

header('Location: index.php');
    exit();
  }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('dbconnect.php');
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connect->connect_errno !=0)
    {
      echo "Error:" . $connect->connect_errno;

    } else {

      $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");

      $password = $_POST['password'];


      $result = @$connect->query("SELECT * FROM `user` WHERE login = '$login'");
      $row = $result->fetch_assoc();

      $id = $row['ID'];
      // $dbsalt = $row['salt'];
      $dbpassword = $row['password'];


      // $probahasla = $inputpassword;
      // $password = hash("sha256" , $probahasla);

      if($password == $dbpassword)
      {
        $_SESSION['zalogowany'] = true;

        $_SESSION['id'] = $id;
        $_SESSION['login'] = $login;
        unset($_SESSION['blad']);


        $result->close();

        header('Location: indexlog.php');

  //Czas ostatniego logowania

       // $query = mysqli_query($connect, 'UPDATE `user` SET `now_activity` = CURTIME()');

       // $result = mysqli_query($connect, "SELECT `now_activity` FROM `user`");

       // $row = mysqli_fetch_array($result);

      //  foreach ($row as $key => $value) {
      //    $_SESSION['czas'] = $value;
      //   break;
      //  }

//----------------------------------------

        $connect->close();
        exit();

    } else {
        $_SESSION['blad'] = '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Nieprawidłowy login lub hasło</div>';


        header('Location: index.php');

        $connect->close();
        exit();

      }


      if ($result = @$connect->query(sprintf("SELECT * FROM user WHERE login='%s' AND password='%s'",
      mysqli_real_escape_string($connect, $login),
      mysqli_real_escape_string($connect, $password))))
      {
        $ilu_userow = $result->num_rows;


      }



    }
}




$_SESSION['blad'] = false;



?>
</body>
</html>
