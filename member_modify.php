<?php
    //1.데이타베이스 include 
    //2. 전역변수선언 한줄
    //3. $_POST isset()
    //4. 보안코딩
    //5. 에러코딩 체크
    //6. 패스워드 hash code
    //7. update 진행함.

    $id = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
    
    $user_info = "id={$id}&name={$name}";

    $con = mysqli_connect("localhost", "root", "12345", "sample");
    //해당되는 아이디가 존재하는지 점검해서 처리해줄것

   
    $sql = "update members set pass='$pass', name='$name' , email='$email'";
    $sql .= " where id='$id'";
    $result = mysqli_query($con, $sql);
    mysqli_close($con);     
    if(!$result){
        header("location: member_modify.php?error=가입에 실패했습니다&$user_info"); 
        exit(); 
    }
    header("location: index.php");
    exit();  
?>