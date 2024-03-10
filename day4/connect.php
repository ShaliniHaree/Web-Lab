<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='brainbruster';
$conn=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
if($conn) {
    //echo "SUCCESSFULL";
}
else {
    die(mysqli_error($conn));
}
?>