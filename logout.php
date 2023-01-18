<?php
  session_start();
  if(!isset($_SESSION["userid"]) || empty($_SESSION["userid"])){
    echo("
    <script>
       alert('비 정상적인 작동감지되었습니다.');
       location.href = 'http://{$_SERVER['HTTP_HOST']}/source/part3/index.php';
    </script>
    ");
    exit;
  }
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["userlevel"]);
  unset($_SESSION["userpoint"]);
  
  header("location: http://{$_SERVER['HTTP_HOST']}/source/part3/index.php");
  exit(); 
  // echo("
  //      <script>
  //         location.href = 'index.php';
  //        </script>
  // ");
?>