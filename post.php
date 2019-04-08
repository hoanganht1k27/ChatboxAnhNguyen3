<?php
   session_start();
   if(isset($_SESSION['name']))
   {
   	  if($_POST['type']==1)
   	  {
   	  $text=$_POST['text'];
   	  $fp=fopen("log.html", "a");
   	  fwrite($fp, date("g:i:A ")."<b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br>");
   	  fclose($fp);
   	  }
   	  if($_POST['type']==2)
   	  {
   	  if(isset($_FILES['filemsg']))
   	  {
   	  	$text=$_POST['text'];
   	  $fp=fopen("log.html", "a");
   	  fwrite($fp, date("g:i:A ")."<b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br>");
   	  fclose($fp);
   	  	move_uploaded_file($_FILES['filemsg']['tmp_name'], "image/".$_FILES['filemsg']['name']);
   	  }
   	  }
   }
?>