<?php
session_start();
require_once '../inc/connect.php';
if(isset($_POST['submit'])){
    $email =trim(htmlspecialchars($_POST['email']));
    $password =trim(htmlspecialchars($_POST['password']));
  

    $errors = [];
    if( $email==""){
        $errors[] = "email is required";
      }elseif(is_numeric($email)){
        $errors[]="password must be number";
      }
      elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[]="email not correct";
      }
      if( $password==""){
        $errors[] = "password is required";
      }elseif(!is_numeric($password)){
        $errors[]="password must be number";
      }elseif(strlen($password)<6){
        $errors[]="password must be more than 6 ";
      }

      if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header('Location:../login.php');
      }else{  
        $query= "select * from users where `email`='$email'";
        /// check admin 
        $run = mysqli_query($conn,$query);

        if(mysqli_num_rows($run)==1){
            $user=mysqli_fetch_assoc($run);
// مهم انك ت catch
            $id =$user['id'];
            $user_name =$user['name']; //welcome
            $oldpassword =$user['password'];

           $password_verified= password_verify($password,$oldpassword);  // طلاما عملت الباسور ون واي)(هاشد) يبقي لازم افقو ب verify 
           // بتقارن اللي دخلتو ب اللي موجود في الداتا بيز
           // بترجعلي ي true  or false
           if($password_verified){
            $_SESSION['user_id']= $id; //(مهم جدا)  // انا هنا بخزن ال user / عشان اعرف افرق بين كل مستخدم عمل لوجين // استخدمها عشان اعمل لوجين و لوج اوت
            $_SESSION['success'] = ["welcome $user_name"]; // welcome 
            header("location:../index.php");
            exit;
           }else{
                 $_SESSION['errors'] = ["credentials are not correct"];
                header("location:../login.php");
           }

        }else{
            $_SESSION['errors'] = ["email doesn't exit"];
            header("location:../login.php"); 
        }
        // Fetch user data from the database

// $query = "SELECT * FROM users WHERE email = '$email'";
// $result = mysqli_query($conn, $query);

// if ($result) {
//     $user = mysqli_fetch_assoc($result);
//     if ($user) {
//         // Verify the password
//         if (password_verify($password, $user['password'])) {
//             // Password is correct, set session and redirect
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['user_name'] = $user['name'];
//             header("Location: ../index.php");
//             exit;
//         } else {
//             // Incorrect password
//             $_SESSION['errors'] = ["Incorrect password"];
//             header("Location: ../login.php");
//             exit;
//         }
//     } else {
//         // Email not found
//         $_SESSION['errors'] = ["Email not found"];
//         header("Location: ../login.php");
//         exit;
//     }
// } else {
//     // Database error
//     $_SESSION['errors'] = ["Database error: " . mysqli_error($conn)];
//     header("Location: ../login.php");
//     exit;
// }


      }

}else{
     header('Location:../login.php');
   
}