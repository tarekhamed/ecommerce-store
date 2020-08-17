<?php



/*  # manage members page


    # you can Edit & Delete & 


*/


session_start();
$pageTitle = 'Members' ;
if(isset($_SESSION['username'])){
     
    include 'init.php';
    $do = isset($_GET['do'])?$_GET['do']:'Manage' ; 
    
    if($do=='Manage'){
      
        $stmt = $con->prepare("SELECT*FROM users WHERE group_id != 1");               
        $stmt->execute();
         $rows = $stmt->fetchAll();
                      

        
                      




        ?>
    
        <h1 class="text-center">Manage Members</h1>
        <div class = 'container'>
            <div class="table-responsive">
            <table class=" main-table table table-bordered text-center">
                
                <tr>
                
                <td>#ID</td>
                <td>Full Name</td>
                <td>User Name</td>
                <td>Email</td>
                <td>Registerd Date</td>
                <td>Control</td>
                </tr>
                <?php
                
                foreach($rows as $row){
                
                        
                         echo '<tr>';
                         echo "<td>" . $row['userid'] . "</td>";
                         echo "<td>" . $row['fullname'] . "</td>";
                         echo "<td>" . $row['username'] . "</td>";
                         echo "<td>" . $row['email'] . "</td>";
                         echo "<td></td>";
                         echo "<td> 
                         <a href='members.php?do=Edit&userid=".$row['userid']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                         <a href='members.php?do=Delete&userid=".$row['userid']."'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> 
                                     
                                     </td>";
                        echo '</tr>';
                }      
                      
           
                ?>
                </table>
            
            
            
            
            </div>
        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus">ِ Add New Member</i></a>
</div>
    
   <?php } 
    
    /* start Add */ 
    elseif($do=='Add'){?>
    

                 
                  <div class = 'container'>
     
       <h1 class='text-center'> Add Members</h1>    
         
     <form method="post" action="?do=Insert">
  <div class="form-group form-group-lg">
    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-lg">Username</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" class="form-control form-control-lg" id="colFormLabelSm" required="required" placeholder="Add UserName Please" name="username" 
             >
        <input type="hidden" class="form-control form-control-lg" id="colFormLabelSm" placeholder="" name="userid" 
             >
    </div>
  </div>
  <div class="form-group form-group-lg">
    <label for="colFormLabel" class="col-sm-2 col-form-label-lg">Password</label>
    <div class="col-sm-10 col-md-8">
      <input type="password" class="form-control" id="colFormLabel" placeholder="" name="password"  required="required">
        
    </div>
  </div>
  <div class="form-group form-group-lg">
    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
    <div class="col-sm-10 col-md-8">
      <input type="email" required="required" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Add Your Email" name="email" >
    </div>
  </div>
           <div class="form-group form-group-lg">
    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Full Name</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" class="form-control form-control-lg" required="required" id="colFormLabelLg" placeholder="" name="fullname"  
             >
    </div>
  </div>
       
         <div class="form-group form-group-lg">
         <div class="col-sm-offset-2 col-sm-10">
             <input type="submit" value = "ADD" class="btn btn-primary btn-lg"/>
             
             
             
             
       </div>      
         </div>        
            </form>
               </div>
    <!--end Add -->

    <?php
    
    }
    
    
    /* start Insert Page */ 
    
    
        elseif($do=='Insert'){
    
    
        
        echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD']=='POST'){
        
           echo '<h1 class="text-center">Insert Members</h1>';
            $id = $_POST['userid'];
            $UserName = $_POST['username'];
            $email = $_POST['email'];
            $FullName = $_POST['fullname'];
            $pass = $_POST['password'];
            $shapassword = sha1($pass);
          
            
            // * start validate */ 
            
            $FormErrors = array();
            
            if(empty($UserName)){
            
                $FormErrors[] =  'UserName can not be Empty';         
            
            }
            
            if(strlen($UserName)<4){
            
             $FormErrors[] =  'username can not less than 4 chr';
            
            }
            
            if(empty($email)){
            
                $FormErrors[] =  'Email can not be Empty';         
            
            
            }
            if(empty($FullName)){
            
                $FormErrors[] =  'Fullname can not be Empty';         
            
            
            }
                 if(empty($pass)){
            
                $FormErrors[] =  'password can not be Empty';         
            
            
            }        
            
            foreach($FormErrors as $errors){
            
               echo '<div class="alert alert-danger">' . $errors .'</div>' ;
            
            
            
            }
            
            
            
            
            
            
            /* end validate */ 
            
            
            
          
            /* check if $formerrors are empty if it is empaty can you continue the query*/
            if(empty($FormErrors)){
                
             /* check if username is found in database or not */
                
             $check =  Check("username" , "users" , $UserName) ;
                 
                 if($check ==1){?>
                
                
                <div class ='container'>
                    
                   
                         
                       <?php 
                                $TheMessage = '<div class="alert alert-danger">This Name Is Found</div>';
                        redirectHome($TheMessage , $seconds=3 , $url='back');
                        
                        ?>
    
                    </div>


            
                 
                 
                 
                <?php }else{
                
                
                
            $stmt = $con->prepare("INSERT INTO users(username,password,fullname,email) VALUES(:zusername , :zpassword , :zfullname , :zemail)");
            $stmt->execute(array( 
            'zusername'=>$UserName,
            'zpassword'=>$shapassword,
            'zfullname'=>$FullName,
             'zemail'  =>$email,
            
            
            ));
            $count = $stmt->rowCount() ; 

            
             $TheMessage =  '<div class="alert alert-success">' . $count . ' ' .  'Record' . '</div>' ;
                     redirectHome($TheMessage , $seconds=3 , $url = 'back');
            
            }
        
        }
            
        }
       else{
       
           echo 'You must be transfer from othe page';
       
       }
        echo '</div>';
         
    
    }    
    
    /*end Insert Page */
    
    
    
    
    
    
 
    
    
    
    
    
    /* start Edit */ 
    elseif($do=='Edit'){
        
        $user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
          $stmt = $con->prepare("SELECT * FROM users WHERE userid=? ");
          $stmt->execute(array( $user));
          $count = $stmt->rowCount() ; 
          $row = $stmt->fetch();
          
    
          if($count>0){?>
          
              <div class = 'container'>
     
       <h1 class='text-center'> Edit Members</h1>    
         
     <form method="post" action="?do=update">
  <div class="form-group form-group-lg">
    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-lg">Username</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" class="form-control form-control-lg" id="colFormLabelSm" required="required" placeholder="" name="username" 
             value="<?php echo $row['username']?>">
        <input type="hidden" class="form-control form-control-lg" id="colFormLabelSm" placeholder="" name="userid" 
             value="<?php echo $row['userid']?>">
    </div>
  </div>
  <div class="form-group form-group-lg">
    <label for="colFormLabel" class="col-sm-2 col-form-label-lg">Password</label>
    <div class="col-sm-10 col-md-8">
      <input type="password" class="form-control" id="colFormLabel" placeholder="" name="new_password" >
        <input type="hidden" name="old_password" value = "<?php echo $row['password']?>">
    </div>
  </div>
  <div class="form-group form-group-lg">
    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
    <div class="col-sm-10 col-md-8">
      <input type="email" required="required" class="form-control form-control-lg" id="colFormLabelLg" placeholder="" name="email"  value="<?php echo $row['email']?>">
    </div>
  </div>
           <div class="form-group form-group-lg">
    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Full Name</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" class="form-control form-control-lg" required="required" id="colFormLabelLg" placeholder="" name="fullname"  
             value="<?php echo $row['fullname']?>">
    </div>
  </div>
       
         <div class="form-group form-group-lg">
         <div class="col-sm-offset-2 col-sm-10">
             <input type="submit" value = "Save" class="btn btn-primary btn-lg"/>
             
             
             
             
       </div>      
         </div>        
            </form>
               </div>
                
          
          
    <?php      
          
          }else{
          
             $errorMessage = 'This Id is Not found' ; 
               redirectHome($errorMessage , 5);
          
          }
    
    
    }
    /* end edit */ 
    
    
    
    /* start update */ 
    elseif($do=='update'){
        echo '<h1 class="text-center">Update Members</h1>';
        echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD']=='POST'){
        
           
            $id = $_POST['userid'];
            $UserName = $_POST['username'];
            $email = $_POST['email'];
            $FullName = $_POST['fullname'];
            $pass = empty($_POST['new_password'])? $_POST['old_password']:sha1($_POST['new_password']) ; 
            
            // * start validate */ 
            
            $FormErrors = array();
            
            if(empty($UserName)){
            
                $FormErrors[] =  '<div class="alert alert-danger">UserName can not be Empty</div>';         
            
            }
            
            if(strlen($UserName)<4){
            
             $FormErrors[] =  '<div class="alert alert-danger">username can not less than <strong>4</strong> chr</div>';
            
            }
            
            if(empty($email)){
            
                $FormErrors[] =  '<div class="alert alert-danger">Email can not be Empty</div>';         
            
            
            }
            if(empty($FullName)){
            
                $FormErrors[] =  '<div class="alert alert-danger">Fullname can not be Empty</div>';         
            
            
            }
            
            foreach($FormErrors as $errors){
            
               echo $errors . '<br>' ;
            
            
            
            }
            
            
            
            
            
            
            /* end validate */ 
            
            /* check if $formerrors are empty if it is empaty can you continue the query*/
            
          
            
            if(empty($FormErrors)){
            $stmt = $con->prepare("UPDATE users SET username =?,fullname = ?, email = ? , password = ?  WHERE userid = ?");
            $stmt->execute(array($UserName , $FullName , $email , $pass , $id ));
            $count = $stmt->rowCount() ; 

            
            $TheMessage =  '<div class="alert alert-success">' . $count . ' ' .  'Record' . '</div>' ;
                
                 redirectHome($TheMessage , $seconds=3 , $url = 'back');
                
                
            
            }
        
        }    
        
       else{
       
           echo 'You must be transfer from other page';
       
       }
        echo '</div>';
         
    
    }
    
    
     /* end update */ 
    
    
    /*start Delete */ 
    elseif($do=='Delete'){
    
     $user = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     $stmt = $con->prepare("SELECT * FROM users WHERE userid=? ");
          $stmt->execute(array($user));
          $count = $stmt->rowCount() ; 
          if($stmt->rowCount() > 0){
          
        $stmt = $con->prepare("DELETE FROM users WHERE userid =:zuserid");
        $stmt->bindParam(":zuserid",$user);
        $stmt->execute();
              
              echo "<div class='alert alert-success'>" .$stmt->rowCount().'Recorded Deleted </div>';
            
          }
        
        
        else{
        
        echo 'This Id is not Found';
        
        
        }
    
    
    
    
    }
    
    
    
    
    /* end Delete */ 
    
    
    
    
    
    
    
         
     }
    

else{

   header('location:index.php');
    


}