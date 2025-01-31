<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../login.php');
  }else{

 $user_id=$_SESSION['user_id'];   
if(isset($_POST['submit'])){
    require_once '../inc/connect.php' ;
    // catch data 
    // extract($_POST);
    $title = trim(htmlspecialchars($_POST['title']));
    $body =trim(htmlspecialchars($_POST['body']));
 // catch image 
   
    // validaton 
    $errors=[];
      
    if($title==""){
        $errors[] = "title is required";
    }elseif(is_numeric($title)){
        $errors[]="title must be string";
    }
    if($body==""){
        $errors[] = "body is required";
    }elseif(is_numeric($body)){
        $errors[]="body must be string";
    }elseif(strlen($body)<100){
        $errors[]="body must greater than 100 character";
    }
   
//   
 if(isset($_FILES['file']) && $_FILES['file']['name'] ){
    
    $image=$_FILES['file'];
    $image_name= $image['name'];
    $tamp_name=$image["tmp_name"];
    $ext=strtolower(pathinfo($image_name,PATHINFO_EXTENSION));
   
       $arr=["png","jpg","jpeg"];
       if( $image['error']!=0){
           $errors[]="image is required"; 
        }elseif(! in_array($ext,$arr)){
            $errors[]="choose correct image"; 
        }        
        $newName=uniqid().".".$ext;
         
    }else{
        $newName = null ; 
    }

  if(!empty($errors)){
    $_SESSION["errors"] = $errors;
    $_SESSION['title']=$title;
    $_SESSION['body']=$body;
    header('Location:../addPost.php');
    exit ;
  }else{
    $query= "select * from users where `email`='$email'";
        /// check admin 
        $run = mysqli_query($conn,$query);

        if(mysqli_num_rows($run)==1){
            $user=mysqli_fetch_assoc($run);
        }
        // if($ser['email']=="hatemze233@gmail.com"){

            
            $query = "INSERT INTO posts (`title`, `user_id`, `image`, `body`) VALUES ('$title','$user_id','$newName','$body')";
            $run=mysqli_query($conn,$query);
            if($run){
                // if(isset($_FILES['file'])){
                    move_uploaded_file($tamp_name,"../assets/images/postImage/$newName");
                    
                    // }
                    $_SESSION['success'][] = "product inserted successfully";
                    header('Location:../index.php');
                    exit ;
                }else{
                    $_SESSION['errors'] = ["failed to insert product"];
                    header("location:../addPost.php");
                }
            // }else{

            //     header('Location:../index.php');
            //     $_SESSION['errors'] = ["failed not admin"];
            // }
  }


}else{
    header('Location:../addPost.php');
}
}