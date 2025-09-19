<?php
try {
    $con = mysqli_connect("localhost", "root", "Neel21@&", "php");
} catch (Exception $e) {
    echo "Error in Connecting with Database Server" . $e->getMessage();;
}
