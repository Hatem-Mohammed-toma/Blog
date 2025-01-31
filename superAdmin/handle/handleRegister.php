<?php
session_start();
require_once '../../inc/connect.php' ;
if(isset($_POST['submit'])){
// catch   // name   // email  // password // phone 
$name =trim(htmlspecialchars($_POST['name']));
$email =trim(htmlspecialchars($_POST['email']));
$password =trim(htmlspecialchars($_POST['password']));
$phone =trim(htmlspecialchars($_POST['phone']));


// validation 

$errors=[];
if( $name==""){
    $errors[] = "name is required";
  }elseif(!is_string( $name)){
    $errors[]="name ust be string";
  }elseif(strlen( $name)>70){
    $errors[]="name must be less than 70 char ";
  }

 
    if( $email==""){
        $errors[] = "email is required";
      }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[]="email not correct";
      }
  

  if( $password==""){
    $errors[] = "password is required";
  }elseif(!is_numeric($password)){
    $errors[]="password must be number";
  }elseif(strlen($password)<6){
    $errors[]="password must be more than 6 ";
  }

  if (empty($phone)) {
    $errors[] = "Phone is required";
  }elseif (!preg_match("/^\d{11}$/", $phone)) {
        $_SESSION['errors'][] = "Phone number must be 11 digits";
    }
///////////////
    $hashedpassword = password_hash($password,PASSWORD_DEFAULT);
/////////// 
if(!empty($errors)){
    $_SESSION['errors']=$errors;
    $_SESSION['name']=$name;
    $_SESSION['email']=$email;
    header('location:../register.php');
}else{
    $query = "INSERT INTO users(`name`,`email`,`password`,`phone`)VALUES('$name','$email','$hashedpassword','$phone')";
    $run=mysqli_query($conn,$query);
    if($run){
        $_SESSION['succes']=["success insert user "];
        header('location:../../login.php');  // login 
    }else{
        $_SESSION['errors']=["not insert the user"];
        header('location:../register.php');
    }   
}
}else{
    header('location:../register.php');
}


