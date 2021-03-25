<?php

    if (isset($_COOKIE['jwt'])) {
        unset($_COOKIE['jwt']);  
    } 

    setcookie('jwt', null, -1); 
    header("Location: index.php");
    exit(0);