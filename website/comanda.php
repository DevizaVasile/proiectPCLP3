<?php
    require('db_connect.php');
    require ('procesare_comanda.php');
    $get_meniu="SELECT * FROM meniu";
    $ask_meniu=mysqli_query($connection,$get_meniu);
    $price_list= get_prices_array();
    $sold= get_user_sold();
    $user=$_SESSION['username'];
    if(isset($_POST['mancare']))
    {
        //variabilele luate de la butonul submit
        $mancare_comandata=$_POST['mancare'];
        $cantitate_comandata=$_POST['cantitate'];
        $la_pachet_comandat=$_POST['la_pachet'];
        $mancare_comandata=array_values($mancare_comandata);
        $cantitate_comandata=array_values($cantitate_comandata);
        $la_pachet_comandat=array_values($la_pachet_comandat);

        if(count($mancare_comandata) == count($cantitate_comandata))
        { 
            //acest array de mai jos trebu pentru a extrage date din el si a trimite informatii tabelului cu comenzi totale
            $special_oreder_nume = [];
            $special_order_cantitate = [];
            $plata=null;
            $comanda_finala="";
           for($i=0;$i<count($mancare_comandata);$i++)
           {  
            if($cantitate_comandata[$i] != 0)
            {
               global $special_oreder_nume;
               global $special_order_cantitate;
               array_push($special_oreder_nume, $mancare_comandata[$i]);
               array_push($special_order_cantitate, $cantitate_comandata[$i]);
                
              $plata+=$cantitate_comandata[$i]*$price_list[$i];
              
              if($la_pachet_comandat[$i] == 'da')
              {  
                  $comanda_finala.=$mancare_comandata[$i]." x " . $cantitate_comandata[$i] ." (la pachet) &&& "; 
              }
              
              else
              {
                 $comanda_finala.=$mancare_comandata[$i]." x " . $cantitate_comandata[$i] ." &&& ";
              }
            }
         
           }
           
           if($sold<$plata)
           {
               echo '<script language="javascript">';
               echo 'alert("Credit insuficient")';
               echo '</script>';
           }
           else
           {
               plata($plata);
               pune_comanda_db1($comanda_finala,$user);
               global $special_oreder_nume;
               global $special_order_cantitate;
               if(count($special_oreder_nume)==count($special_order_cantitate))
               {
                   for($i=0;$i<count($special_oreder_nume);$i++)
                   {
                    global $special_oreder_nume;
                    global $special_order_cantitate;  
                    $sql="UPDATE `comenzi_total` SET  `cantitate` = `cantitate` + ".$special_order_cantitate[$i]." WHERE `mancare` = '".$special_oreder_nume[$i]."'";   
                    mysqli_query($connection,$sql);
                   }
                        
               }
               header("Location: comenzile_mele.php");
           }
           
           
           
           
        } 
        
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Unitbv.ro</title>
    <script src="http://www.w3schools.com/lib/w3data.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {padding-top: 70px;}
    ul { list-style: none; }
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
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 5%" class="list-group-item" >  <?php echo $_SESSION['username']; echo get_user_sold() ?> </div><?php } ?></li>
                    <li><?php if(isset($_SESSION['username'])){  ?><div style="margin-top: 10%" class="list-group-item" > <form method="POST" action="logout.php" ><button type="submit"> Log out</button></form> </div><?php } ?></li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <p> Sold curent : <?php echo $sold; ?> </p> 
        
        
        <?php
        if ($ask_meniu -> num_rows > 0)
        { ?>
        <form method="POST" accept-charset="procesare_comanda.php">
        <table class="table">
            <tr>
                <td>ID</td>
                <td>Nume</td>
                <td>Gramaj</td>
                <td>Pret</td>
                <td>Cantitae</td>
                <td>La pachet?</td>
            </tr>
         
        
       
        <?php
            $id=0;
            while($row = $ask_meniu -> fetch_assoc())
            {   $id+=1;
                echo '<tr id="line'.$id.'"'.'>';
                echo "<td>" . $row['id']        . "</td>";
                echo "<td>" . $row['mancare']   . "</td>";
                echo "<td>" . $row['gramaj']    . "</td>";
                echo "<td>" . $row['pret']      . "</td>";
                echo '<td><input type="number"    name="cantitate[]"  min="0" max="5" value="0"></td>';
                echo '<td>         '
                . '<select name="la_pachet[]">  '
                . ' <option value="nu">Nu</option> '
                . ' <option value="da">Da</option>'
                . '<select></td>';
                echo '<td><input type="hidden"    name="mancare[]" value="' . $row['mancare'] . '"> </td>';
                echo "</tr>";
             }
          ?>
        </table>
            <input type="submit" value="Comanda">
        </form>
        <p> <?php $x;?> </p>
        <?php
        }
        else
        {
            echo "0 results";
        }
        ?>
    </div>
    

    <!-- /.container -->
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
