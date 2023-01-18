<?php
    include("./db/db_connector.php");  
    //1.데이타베이스 include 
    //2. 전역변수선언 한줄
    //3. $_POST isset()
    //4. 보안코딩
    //5. 에러코딩 체크
    //6. 패스워드 hash code
    //7. insert 진행함.
    $id   = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

              
    // $con = mysqli_connect("localhost", "root", "12345", "sample");

	$sql = "insert into members(id, pass, name, email, regist_day, level, point) ";
	$sql .= "values('$id', '$pass', '$name', '$email', '$regist_day', 9, 0)";

	$result = mysqli_query($con, $sql) or  die("데이타베이스 보여주기 실패". mysqli_error($con));
      // $sql 에 저장된 명령 실행
    
    if(!$result){
        echo $dbcon; 
        echo "회원가입실패 ";
        exit(); 
    }
    
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>