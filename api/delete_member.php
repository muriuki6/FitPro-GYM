<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/database.php';

$id = intval($_GET['id']);

$conn->begin_transaction();

try {

    // Delete attendance records
    $stmt = $conn->prepare(
        "DELETE FROM attendance WHERE member_id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete payment records
    $stmt = $conn->prepare(
        "DELETE FROM payments WHERE member_id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete member
    $stmt = $conn->prepare(
        "DELETE FROM members WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->commit();

    echo "Member Deleted Successfully";

} catch (Exception $e) {

    $conn->rollback();

    echo "Delete Failed: " . $e->getMessage();
}
?>