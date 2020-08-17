<?php


$do = isset($_GET['do'])?$_GET['do']:'Manage' ; 




if($do=='Manage'){

echo 'Welcome You are In manage category page';

}elseif($do=='Add'){


 echo 'Welcome you are in ADD Page';

}elseif($do=='Delete'){

echo 'Welcome you are in Delete Page';

}else{

     echo ' Error This Page Is Not Found';

}