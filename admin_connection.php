<?php

$conn = mysqli_connect("localhost","root","","admin");

if(mysqli_connect_error())
{
    echo"cannot connect";
}
// else {
//     echo"connected";
// }
?>