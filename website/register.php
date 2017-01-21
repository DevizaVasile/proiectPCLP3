<?php
	require('db_connect.php');
        session_start();
    // If the values are posted, insert them into the database.
    if (isset($_POST['email']) && isset($_POST['password']))
    {
	$email = $_POST['email'];
        $password = $_POST['password'];
        $query_verify="SELECT * FROM `users` WHERE `email` = '$email'";
        $result_verify=mysqli_query($connection, $query_verify);
        if($result_verify->num_rows > 0)
        {
            $wrong_mail="Aceasta adresa de e-mail e folosita .";
        }
        
        else
        {
            $key= (string)rand(10000000, 99999999);         
            $query ="INSERT INTO `users` (`userID`, `email`, `password`, `reg_date`, `active`, `key`) VALUES (NULL, '$email', '$password', CURRENT_TIMESTAMP, '0', '$key')";
            $result = mysqli_query($connection, $query);   
         
            
            $headers = 'From: webmaster@example.com' . "\r\n" .  'Reply-To: webmaster@example.com';
            $aaa=mail("user@localhost", "Activare cont cantina", $key, $headers);     
            if($result)
                {
                    $smsg = "Cont creat cu succes, am trimis un mail pe $email cu un cod de activare.";
                }
             else
                 {
            $fmsg ="Date introduse gresit";
                }
        }
            
        
 
        
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
                    <li><a href="#">Contact</a></li>
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 5%" class="list-group-item" > <?php echo $_SESSION['username']; ?> </div><?php } ?></li>
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 10%" class="list-group-item" > <form method="POST" action="logout.php" ><button type="submit"> Log out</button></form> </div><?php } ?></li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
  
    
<div class="container" style=" width:50%">
      <form class="form-signin" method="POST">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus style="width:40%">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required style="width:40%">
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;width: 20%;">Register</button>
      </form>
    <a href="activare.php" class="btn btn-lg btn-primary btn-block" style="margin-top: 10px;width: 25%;">Fereastra de activare</a>
</div>
    

      <?php if(isset($smsg)){       ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){       ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
      <?php if(isset($wrong_mail)){ ?><div class="alert alert-danger" role="alert"> <?php echo $wrong_mail; ?> </div><?php } ?>

    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>