<?php
  include("./db/db_connector.php");
  
    //1.데이타베이스 include 
    //2. 전역변수선언 한줄
    //3. $_POST isset()
    //4. 보안코딩
    //5. 에러코딩 체크
    //6. 패스워드 hash code
    //7. select 진행함.
    $id   = $_POST["id"];
    $pass = $_POST["pass"];

  //  $con = mysqli_connect("localhost", "root", "12345", "sample");
   $sql = "select * from members where id='$id'";

   $result = mysqli_query($con, $sql);

   if(mysqli_num_rows($result) != 1) 
   {
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다!')
             history.go(-1)
           </script>
         ");
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $db_pass = $row["pass"];
        mysqli_close($con);

        if($pass != $db_pass)
        {
           echo("
              <script>
                window.alert('비밀번호가 틀립니다!')
                history.go(-1)
              </script>
           ");
           exit;
        }
        else
        {
            session_start();
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $row["name"];
            $_SESSION["userlevel"] = $row["level"];
            $_SESSION["userpoint"] = $row["point"];
           
            echo("
              <script>
                location.href = 'index.php';
              </script>
            ");
        }
     }        
?>