<?php
    require('db_connect.php');
    session_start();
     if (isset($_POST['email']) && isset($_POST['password']))
     {
         $my_username=$_POST['email'];
         $my_password=$_POST['password'];
         $query_login="SELECT * FROM `users` WHERE `email` = '$my_username' AND `password` = '$my_password'";
         $result_login_verify=mysqli_query($connection, $query_login);
         if($result_login_verify->num_rows==1)
         {
             $is_active_query="SELECT * FROM `users` WHERE `email` = '$my_username'  AND `active` = 1";
             $is_active_result=mysqli_query($connection, $is_active_query);
             if($is_active_result->num_rows==1)
             {
                 $_SESSION['username']=$my_username;
                 $login_mgs="Logat cu succes";
                 header("Location: index.php");
             }
             else($login_mgs="Contul nu a fost activat");
         }
         else
         {
             $login_msg="Username sau parola gresita";
         }
     }  
?>






<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

<style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
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



<div class="container" style=" width:50%;">
    
     <div class="row">
     <div class="col-lg-12 text-center">
      <form class="form-signin" method="POST">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus style="width:40%">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required style="width:40%">
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;width: 20%;">Log in</button>
      </form>
          <?php if(isset($login_mgs)){       ?><div class="alert alert-danger" role="alert" style="margin-top: 10px;width: 20%;"> <?php echo $login_mgs; ?> </div><?php } ?>
     </div>
     </div>
</div>

<!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
