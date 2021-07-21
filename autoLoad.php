<?php

function autoLoader($className){

    $classFile = __DIR__ . "/$className.php";
    if(!file_exists($classFile) && !is_readable($classFile))
        echo " File Not Found !";
    
    include $classFile ;
    // echo "From $classFile : $className Used !";

}

spl_autoload_register('autoLoader');