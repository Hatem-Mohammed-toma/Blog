<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../login.php');
  }
require_once '../inc/connect.php' ;
if(isset($_POST['submit']) && isset($_GET['id'])){
        $id=$_GET['id'] ;

    // catch data 
    $title = trim(htmlspecialchars($_POST['title']));
    $body =trim(htmlspecialchars($_POST['body']));
 
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
    $query = "select * from posts where id=$id";
    $run = mysqli_query($conn ,$query);
    if(mysqli_num_rows($run)==1){
        $post= mysqli_fetch_assoc($run);
        $oldName= $post['image'];
    }else{
        header("location:../index.php");
    }
 // الجزء ده عشان امسك الصوره 
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
            $newName = $oldName ; 
        }

        if(!empty($errors)){
            $_SESSION["errors"] = $errors;
            $_SESSION['title']=$title;
            $_SESSION['body']=$body;
            header('Location:../index.php');
          }else{              
                    // انا كدا خلاص مسكتو مفروض حاليا اعمل ال update
          $query = "update posts set `title`='$title',`body`='$body',`image`='$newName' where `id`=$id" ;
           $run =  mysqli_query($conn,$query);
         if($run){
            if(isset($_FILES['file']) && $_FILES['file']['name'] ){
                unlink("../assets/images/postImage/$oldName");     
                move_uploaded_file($tamp_name,"../assets/images/postImage/$newName");
                // $_SESSION['success'] = ["product updated successfully"];
            }
            $_SESSION['success'] = ["post updated successfully"];
            header("location:../viewPost.php?id=$id");              
         }else{

          $_SESSION['errors']=["updaed failed"];
         header('Location:../editPost.php');
         }           
          }
    }else{
        header('Location:../index.php');
    }

    