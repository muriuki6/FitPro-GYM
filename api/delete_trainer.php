<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/database.php';

if(!isset($_GET['id']))
{
    die("Trainer ID Missing");
}

$id = intval($_GET['id']);

/* Get trainer photo */
$stmt = $conn->prepare("SELECT photo FROM trainers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0)
{
    die("Trainer not found");
}

$trainer = $result->fetch_assoc();

/* Delete photo file if it exists */
if(
    !empty($trainer['photo']) &&
    file_exists("../assets/images/".$trainer['photo'])
)
{
    unlink("../assets/images/".$trainer['photo']);
}

/* Delete trainer */
$stmt = $conn->prepare("DELETE FROM trainers WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute())
{
    echo "Trainer Deleted";
}
else
{
    echo "Delete Failed: " . $stmt->error;
}
?>