<?php
try {
    $con = mysqli_connect("localhost", "root", "", "php");
} catch (Exception $e) {
    echo "Error in Connecting with Database Server" . $e->getMessage();;
}
