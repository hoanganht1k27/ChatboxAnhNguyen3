<?php
   session_start();
   function loginForm()
   {
   	 echo'
        <div id="loginform">
	    	<form action="index.php" method="post">
	    		<p>Please enter your name to continue:</p>
	    		<label for="name">Name:</label>
	    		<input type="text" name="name" id="name">
	    		<input type="submit" name="enter" value="Enter" id="enter">
	    	</form>
	    </div>
   	 ';
   }
   if(isset($_POST['enter']))
   {
       if($_POST['name']!=""){
       	 $_SESSION['name']=stripcslashes(htmlspecialchars($_POST['name']));
    	$fp=fopen("log.html", "a");
    	fwrite($fp,"<b>".$_SESSION['name']."</b> joined the chat session<br>");
    	fclose($fp);
       }
       else{
       	echo '<span class="error">Please type a name</span>';
       }
   }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat-box</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php
    if(!isset($_SESSION['name']))
    {
    	loginForm();
    }
    else{
    ?>
    <div id="wrapper">
    	<div id="menu">
    		<p class="welcome">Welcome, <b><?php echo $_SESSION['name'] ?></b></p>
    		<p class="logout"><a href="#" id="exit">Exit Chat</a></p>
    	</div>
    	<div id="chatbox">
    	<?php
    	$fp=fopen("log.html", "r");
    	$content=fread($fp, filesize("log.html"));
    	fclose($fp);
    	echo $content;
    	?>
    	</div>	
    	<form name="message" id="message">
    		<input name="usermsg" type="text" id="usermsg" size="63">
        <!-- <form name="dinh-kem" id="dinh-kem" action="dinh-kem.php"> -->
          <label id="labelmsg" for="filemsg">Upload file</label>
          <input type="file" name="filemsg" id="filemsg">
        <!-- </form> -->
    		<input type="submit" name="submitmsg" id="submitmsg" value="Send">
    	</form>
    </div>
    <?php
    }
    ?>
    <?php
       if(isset($_GET['logout']))
       {
       	 $fp=fopen("log.html", "a");
       	 fwrite($fp,$_SESSION['name']." has left the char session<br>");
       	 fclose($fp);
       	 session_destroy();
       	 header("Location: index.php");
       }
    ?>
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('#exit').click(function(event) {
    			var exit=confirm("Are you sure??");
    			if(exit==true){
    				window.location='index.php?logout=true';
    			}
    		});
    		$('#submitmsg').click(function(event) {
    			event.preventDefault();
    			var clientmsg=$('#usermsg').val();
    			$.post('post.php', {text: clientmsg,type: 1},loadLog);
    			$('#usermsg').val('');
    		});
        $('#filemsg').change(function(event) {
          var text="gg";
          $.post('post.php', {text,type: 2},loadLog);
          $('#filemsg').val('');
        });
    	});
      function loadLog()
      {
        $.ajax({
              url: "log.html",
              cache: false,
              success: function(html){    
                $("#chatbox").html(html); //Insert chat log into the #chatbox div       
                },
            });
      }
    </script>
</body>
</html>