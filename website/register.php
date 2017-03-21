<?php
	require('db_connect.php');
        session_start();

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['captcha_code']))
    {
	$email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $password=filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $password2=filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
        $kap=filter_var($_POST['captcha_code'],FILTER_SANITIZE_STRING);
          
        if($password==$password2)
        {
            if(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password))
            { echo $kap . "<>". $_SESSION["captcha_code"];
                 if(strcasecmp($_SESSION['captcha_code'], $kap) == 0) 
                 {
                     $query_verify="SELECT * FROM `users` WHERE `email` = '$email'";
                     $result_verify=mysqli_query($connection, $query_verify);
                     if($result_verify->num_rows == 0)
                     {
                            $key= (string)rand(10000000, 99999999);         
                            $query ="INSERT INTO `users` (`userID`, `email`, `password`, `reg_date`, `active`, `key`) VALUES (NULL, '$email', '$password', CURRENT_TIMESTAMP, '0', '$key')";
                            $result = mysqli_query($connection, $query); 
                            $headers = 'From: webmaster@example.com' . "\r\n" .  'Reply-To: webmaster@example.com';
                            $aaa=mail("user@localhost", "Activare cont cantina", $key, $headers);   
                            if($result)
                                {
                                    $smsg = "Cont creat cu succes, am trimis un mail pe $email ce contine codul de activare.";
                                }
                     }
                     else
                     {
                         $fmsg="Exista deja un cont cu acest e-mail.";
                     }
                 }
                 else
                 {  
                     $fmsg="Captcha gresit."; 
                 } 
            }
            else
            {
                $fmsg="Parola trebuie sa contina minum : un numar , o litera mare , o litera mica si un simbol special."; 
            }
        }
        else 
        {
            $fmsg="Parolele introduse nu sunt identice.";
        }       
    }
    else
    {
        $fmsg="Toate campurile sunt obligatorii.";
    }
    ?>



<html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Unitbv.ro</title>
    <link href="./css/style.css" rel="stylesheet">
    <script type='text/javascript'>
        function refreshCaptcha()
        {
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        }
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

   <!-- Navigation -->
     <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">HomePage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php if(isset($_SESSION['username'])){  ?> <li><a href="comanda.php">Comanda acum</a></li><?php } ?>
                    <?php if(isset($_SESSION['username'])){  ?> <li><a href="comenzile_mele.php">Comaenzi active</a></li><?php } ?>
                    <?php if(!isset($_SESSION['username'])){  ?> <li><a href="login.php">Log in</a><?php } ?>
                    <?php if(isset($_SESSION['username'])){  ?><?php } ?>
                    <?php if(!isset($_SESSION['username'])){  ?> <li><a href="register.php">Inregistrare</a><?php } ?>
                    <?php if(!isset($_SESSION['username'])){  ?> <li><a href="activare.php">Activare cont</a><?php } ?>
                    <li><a href="about.php">Contact</a></li>
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 5%" class="list-group-item" > <?php echo $_SESSION['username']; ?> </div><?php } ?></li>
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 10%" class="list-group-item" > <form method="POST" action="logout.php" ><button type="submit"> Log out</button></form> </div><?php } ?></li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
  
    
<div class="container">
      <form class="form-signin form-horizontal" method="POST">
          
          <div class="form-group">
        <label for="inputEmail">Email address</label>
              <div class="col-sm-4">
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address"   >
              </div>
          </div>
          
          <div class="form-group">
        <label for="inputPassword">Password</label>
            <div class="col-sm-4">
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" >
            </div>
         </div>
          
          <div class="form-group">
        <label for="inputPassword2">Password</label>
            <div class="col-sm-4">
            <input type="password" name="password2" id="inputPassword2" class="form-control" placeholder="Re-enter password" >
            </div>
         </div>
          
           <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
           
          
          <div class="form-group">
               <label for="inputCaptcha">Captcha</label>
               <div class="col-sm-4">
            <input type="text" name="captcha_code" id="captcha_code" class="form-control" placeholder="Enter ccaptcha" >
            </div>
          </div>
           
            <br>
            <p>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.</p>
          
          <div class="form-group col-sm-4">
          <button class="btn btn-lg btn-primary btn-block" name="Submit" type="submit" onclick="return validate();" value="Submit" >Register</button>
          </div>

      </form>
    
      <?php if(isset($smsg)){       ?>  <div class="alert alert-success col-sm-10 center-block" role="alert">  <?php echo $smsg; ?> <a href="activare.php">Click aici pentru activare</a> </div><?php } ?>
      <?php if(isset($fmsg)){       ?><div class="alert alert-danger col-sm-10" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>

      
</div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>