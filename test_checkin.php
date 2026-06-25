<?php
include 'config/database.php';

$member_id = 3; // use an existing member ID
$today = date('Y-m-d');

$stmt = $conn->prepare("
INSERT INTO attendance
(member_id, check_in, attendance_date, status)
VALUES
(?, NOW(), ?, 'Present')
");

$stmt->bind_param("is", $member_id, $today);

if($stmt->execute()){
    echo "Success";
}else{
    echo "Error: " . $stmt->error;
}
?>