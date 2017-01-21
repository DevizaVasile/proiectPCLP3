<?php

require('db_connect.php');
session_start();
$user=$_SESSION['username'];

function get_prices_array()
{  require('db_connect.php');
    $get_prices=("SELECT `pret` FROM `meniu` WHERE `pret` IS NOT NULL");
    $get_meniu="SELECT * FROM meniu";
    $ask_meniu=mysqli_query($connection,$get_meniu);
    $ask_prices=mysqli_query($connection,$get_prices);
    $price_list=[];
    while($row = $ask_prices->fetch_assoc())
    {
        array_push($price_list, $row['pret']);
    }
    return $price_list;
}

function get_user_sold()
{   
    require('db_connect.php');
    $user=$_SESSION['username'];
    $get_sold="SELECT `sold` FROM `users` WHERE `email` = '".$user."'";
    $ask_sold=mysqli_query($connection,$get_sold);
    $sold = $ask_sold->fetch_assoc();
    $sold = $sold['sold'];
    return $sold;   
}

function plata($de_platit)
{   
    require('db_connect.php');
    $sold=get_user_sold();
    $sold_nou=$sold-$de_platit;
    $user=$_SESSION['username'];
    $update_sold="UPDATE `users` SET `sold` =  '".$sold_nou."' WHERE `users`.`email` = '".$user."'";
    $send_sold=mysqli_query($connection,$update_sold);
}

function pune_comanda_db1($comanda,$mail)
{
    require('db_connect.php');
    $sql_insert="INSERT INTO `comenzi_personale` (`id`, `ora_plasare`, `comanda`, `status`, `email`) VALUES (NULL, CURRENT_TIMESTAMP, '" .$comanda. "', '0','".$mail."')";
    $plaseaza_comanda=mysqli_query($connection,$sql_insert);
}

function pune_comanda_db2()
{
    
}






?>
