<?php
$lang = 'includes/languages/';
$temp = 'includes/temp/' ;
$functions = 'includes/functions/';
$css = 'layout/css/';
$js = 'layout/js/';



include 'config.php';
include  $lang . 'en.php' ;
include $functions .'function.php';
include   $temp . 'header.php';
include   $temp . 'footer.php';


 // include navbar in all the pages without the register form


if(!isset($nonavbar)){
    
    
    include $temp . 'navbar.php';
    
    
}



