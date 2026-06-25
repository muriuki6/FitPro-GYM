<?php

include '../config/database.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("
UPDATE payments
SET status='Paid'
WHERE id=?
");

$stmt->bind_param("i",$id);

if($stmt->execute()){
    header("Location: ../admin/payments.php");
}else{
    echo "Update Failed";
}
?>