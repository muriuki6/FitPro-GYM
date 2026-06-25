<?php

include '../config/database.php';

$member_id = intval($_POST['member_id'] ?? 0);

if($member_id <= 0){
    echo "Select a valid member";
    exit();
}

$today = date('Y-m-d');

$stmt = $conn->prepare("
INSERT INTO attendance
(
member_id,
attendance_date,
status
)
SELECT
?,
?,
'Absent'
WHERE NOT EXISTS
(
    SELECT 1
    FROM attendance
    WHERE member_id=?
    AND attendance_date=?
)
");

$stmt->bind_param(
    "isis",
    $member_id,
    $today,
    $member_id,
    $today
);

if($stmt->execute() && $stmt->affected_rows > 0)
{
    echo "Member marked absent";
}
elseif($stmt->affected_rows === 0)
{
    echo "Attendance already recorded";
}
else
{
    echo "Failed";
}
?>
