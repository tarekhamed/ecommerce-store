<?php
session_start();
$pageTitle = 'Dashboard' ;
if(isset($_SESSION['username'])){
     
    include 'init.php';

    

}else{

   header('location:index.php');
    


}






