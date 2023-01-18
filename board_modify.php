<?php
    include("./db/db_connector.php");  
    $num     = $_POST["num"];
    $page    = $_POST["page"];
    $subject = $_POST["subject"];
    $content = $_POST["content"];
        
    $sql = "update board set subject='$subject', content='$content'  where num=$num";
    mysqli_query($con, $sql);
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'board_list.php?page=$page';
	      </script>
	  ";
?>