<?php 
$con = mysqli_connect("localhost", "root", "12345"); 
if(!$con){
  die("database connect fail". mysqli_connect_errno()); 
}

// sample 
$database_flag = false; 
$sql = "show databases";
$result = mysqli_query($con, $sql) or  die("데이타베이스 보여주기 실패". mysqli_error($con)); 
while($row = mysqli_fetch_array($result)){
  if($row["Database"] == "sample"){
    $database_flag = true;
    break; 
  }
}


if($database_flag == false){
  $sql = "create database sample";
  $result = mysqli_query($con, $sql) or  die("데이타베이스 생성 실패". mysqli_error($con));   
  if($result == true){
    echo "<script>alert('sample 데이타베이스가 생성되었습니다.')</script>";
  }
}

$dbcon = mysqli_select_db($con, "sample") or  die("데이타베이스 선택 실패". mysqli_error($con)); 
if($dbcon == false){
  echo "<script>alert('sample 데이타베이스 선택이 실패했습니다.')</script>";
}

//$write_pages = 10 : 보여주는 페이지수 10
//$current_page : 현재페이지
//$total_page : 전체페이지
//$url : 'message_box.php?mode=$mode&page=7'
function get_paging($write_pages, $current_page, $total_page, $url) { 

  // URL = 'message_box.php?mode=send&page=123' → 'message_box.php?mode=send&page='
  // $url = preg_replace('/&page=[0-9]*/', '', $url) . '&amp;page=';
  $url = preg_replace('/page=[0-9]*/', '', $url) . 'page=';

  //0. 페이징 시작
  $str = '';

  //1. 2페이지부터 '처음(<<<)' 가기 표시
  // 'PHP_EOL' = \n
  ($current_page > 1) ? ($str .= '<a href="' . $url . '1" > <<< </a>' . PHP_EOL) : ''; 

  //2. 시작 페이지와 끝 페이지를 정한다.(= 정하기만 한다.)
  $start_page = (((int)(($current_page - 1) / $write_pages)) * $write_pages) + 1;
  $end_page = $start_page + $write_pages - 1;
  if ($end_page >= $total_page) $end_page = $total_page;

  //3. 11페이지부터 '이전(<)' 가기 표시
  if ($start_page > 1) $str .= '<a href="' . $url . ($start_page - 1) . '" > <- </a>' . PHP_EOL;

  //4. (총 페이지가 2페이지 이상일 경우부터) 시작 페이지와 끝 페이지를 등록한다.
  if ($total_page > 1) {
      for ($k = $start_page; $k <= $end_page; $k++) {
          if ($current_page != $k)
              $str .= '<a href="' . $url . $k . '">' . $k . '</a>' . PHP_EOL;
          else
              $str .= '<span style="color:blue">' . $k . '</span>' . PHP_EOL;
      }
  }
  // 5. 총 페이지가 마지막 페이지보다 클 경우, '다음(>>)' 가기 표시
  // 예) 20페이지에서 다음을 누르면 21페이지로 이동
  if ($total_page > $end_page) $str .= '<a href="' . $url . ($end_page + 1) . '"> -> </a>'.PHP_EOL;

  // 6. 현재 페이지가 총 페이지보다 작을 경우, '마지막(>>)' 가기 표시
  if ($current_page < $total_page) {
      $str .= '<a href="' . $url . $total_page . '" > >>> </a>' . PHP_EOL;
  }

  // 7. 페이지 등록
  if ($str)
      return "<li><span >{$str}</span></li>";
  else
      return "";
}

function get_paging2($write_pages, $current_page, $total_page, $url) { 
}

//공백제거, 슬래쉬제거, 특수문자타입 변경하기
function input_set($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

    //경고 메시지 
function alert_back($message){
  echo("
    <script>
      alert('$message');
      history.go(-1)
    </script>
  ");
}
?>