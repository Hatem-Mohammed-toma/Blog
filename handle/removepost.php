<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../login.php');
  }else{

if(isset($_POST['delete'])){
    require_once '../inc/connect.php' ;
    
    if(isset($_GET['id'])){  
    $postId = $_GET['id'];
         // select with condition///////////
    // check if founded
        $query = "select id,image from posts where id=$postId" ;
        $run =  mysqli_query($conn,$query);
       
       if(mysqli_num_rows($run)==1){
        // fetch
       
        $post=mysqli_fetch_assoc($run);   // انا هنا عملت fetch عشان اعرف اجيب اسم الصوره (امسك البوست)
        $oldimage=$post['image'];
        unlink("../assets/images/postImage/$oldimage");
       // delete 
        $query= "delete from posts where id=$postId";
        $run =  mysqli_query($conn,$query);
            if($run){
                $_SESSION['success']= "deleted successfully";
                header('Location:../index.php');
            }else{
                $_SESSION['error']="deleted failed";
                header('Location:../index.php');
            }
       }else{
        $_SESSION['error']="post no found";
        header('Location:../index.php');
       }        
    }else{
        
        header('Location:../index.php');
    }
}else{
    header('Location:../viewPost.php');
}

  }
