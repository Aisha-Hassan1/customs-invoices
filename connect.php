<?php

$servername='localhost';
$username='root';
$passward='';
$dbname='work2';

$conn = new mysqli($servername,$username,$passward,$dbname);
if($conn->connect_error){
    die("not connect" . $conn->connect_error );
}
else{
    // echo "successful<br>";
}


?>