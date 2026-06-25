<?php

include '../config/database.php';

$member_id = intval($_POST['member_id'] ?? 0);

if($member_id <= 0){
    echo "Select a valid member";
    exit();
}

$today = date('Y-m-d');

$stmt = $conn->prepare("
UPDATE attendance
SET check_out=NOW()
WHERE member_id=?
AND attendance_date=?
AND status='Present'
AND check_in IS NOT NULL
");

$stmt->bind_param("is",$member_id,$today);

if($stmt->execute() && $stmt->affected_rows > 0)
{
    echo "Check-Out Successful";
}
elseif($stmt->affected_rows === 0)
{
    echo "No active check-in found for this member today";
}
else
{
    echo "Check-Out Failed";
}
?>
