<?php
include 'config.php';
$login = false;
$showError= false;




if(isset($_POST['save']))
{
    $fname= $_POST['fname'];
    $Lname= $_POST['Lname'];
    $address= $_POST['address'];
    $age= $_POST['age'];
    $Email_reg= $_POST['Email_reg'];
    $password_reg= $_POST['password_reg'];
    $phnumber= $_POST['phnumber'];
    $gender= $_POST['gender'];


    $sql_query = "INSERT INTO registerinfo (fname,Lname,address,age,Email_reg,password_reg,phnumber,gender)
    VALUES('$fname','$Lname','$address','$age','$Email_reg','$password_reg','$phnumber', '$gender')";

    if (mysqli_query($conn, $sql_query));
        echo "register successfully";
    // }else{
    //     echo "Error: " .$sql_query ."" .mysqli_error($conn);
    // }
}
mysqli_close($conn);
?>