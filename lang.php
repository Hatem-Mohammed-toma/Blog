<?php

session_start();

if(isset($_GET['lang']) && $_GET['lang']=='ar'){
    $_SESSION['lang']="ar";
}else{
    $_SESSION['lang']="en";
}


header('Location:'.$_SERVER['HTTP_REFERER']); // دي ميثود بترجعني على نفس الصفحه اللي غيرت اللغه فيها