<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/database.php';

if(!isset($_GET['id']))
{
    die("Membership ID Missing");
}

$id = intval($_GET['id']);

$check = $conn->prepare("
SELECT COUNT(*) AS total
FROM members
WHERE plan_id=?
");

$check->bind_param("i",$id);
$check->execute();

$result = $check->get_result();
$row = $result->fetch_assoc();

if($row['total'] > 0)
{
    die("Cannot delete. Members are using this plan.");
}

$stmt = $conn->prepare("
DELETE FROM membership_plans
WHERE id=?
");

$stmt->bind_param("i",$id);

if($stmt->execute())
{
    header("Location: ../admin/memberships.php?deleted=1");
    exit();
}
else
{
    echo "Delete Failed: ".$stmt->error;
}
?>