<?php


session_start();
$nonavbar = '';
$pageTitle = 'log in '; 
if(isset($_SESSION['username'])){
    
    header('location:dashboard.php');
    
}

include 'init.php';





// check if user coming from http post request
  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hassh = sha1($password);
            
   

    // check if  the user exist in database
       
     $stmt = $con->prepare("SELECT userid , username , password FROM users WHERE username=? AND password=? AND group_id=1 ");
     $stmt->execute(array($username ,$hassh ));
     $count = $stmt->rowCount() ; 
     $row = $stmt->fetch();
        
     

   
    // check if count > 0 


  if($count>0){
      
      $_SESSION['username'] = $username ; 
      $_SESSION['ID'] = $row['userid'];
      header('location:dashboard.php');
         
  }
 
 }



?>


<form class="login" action = "<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <h2 class="text-center">Admin Login</h2>

    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
    <input class="form-control"  type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="login"/>



</form>




