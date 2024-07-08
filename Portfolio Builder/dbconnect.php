
<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    $conn = mysqli_connect("localhost","root","","portfolio");
    if(!($conn)){
        die("Connection Failed: " . mysqli_connect_error());
    }

    $database = "portfolio";
    $sql = "SHOW DATABASES";
    $result1 = mysqli_query($conn , $sql);

    $dbExist = false;

    while( $row = mysqli_fetch_assoc($result1) ){

        if( $row['Database'] == $database ){

            $dbExist = true;
            // echo "database exist<br>";
        }

    }
    if ( !($dbExist) ){
        $database = "portfolio";
        $sql = "CREATE DATABASE $database";
        mysqli_query($conn , $sql);
        
    }
    
    $conn = mysqli_connect("localhost","root","","portfolio");
    
        if( !($conn) ){
    
            die("Connection failed: " . mysqli_connect_error());
    
        }
    
?>