<?php

include '../includes/auth.php';
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location: classes.php");
    exit();
}

/*==================================
GET FORM DATA
===================================*/

$class_name = trim($_POST['class_name']);
$instructor = trim($_POST['instructor']);
$description = trim($_POST['description']);
$schedule = $_POST['schedule'];
$duration = intval($_POST['duration']);
$capacity = intval($_POST['capacity']);
$difficulty = $_POST['difficulty'];
$status = $_POST['status'];

if(
    empty($class_name) ||
    empty($instructor) ||
    empty($schedule)
){
    echo "<script>
    alert('Please fill all required fields.');
    window.location='classes.php';
    </script>";
    exit();
}

/*==================================
CHECK DUPLICATE CLASS
===================================*/

$check = $conn->prepare("
SELECT id
FROM classes
WHERE class_name=?
");

$check->bind_param("s",$class_name);
$check->execute();

if($check->get_result()->num_rows > 0){

    echo "<script>
    alert('A class with this name already exists.');
    window.location='classes.php';
    </script>";

    exit();

}

/*==================================
UPLOAD IMAGE
===================================*/

$imageName = "";

if(
!empty($_FILES['class_image']['name'])
){

$allowed = [
'jpg',
'jpeg',
'png',
'gif',
'webp'
];

$extension = strtolower(
pathinfo(
$_FILES['class_image']['name'],
PATHINFO_EXTENSION
)
);

if(in_array($extension,$allowed))
{

$imageName =
time().'_'.uniqid().'.'.$extension;

move_uploaded_file(

$_FILES['class_image']['tmp_name'],

"../assets/images/classes/".$imageName

);

}

}

/*==================================
INSERT CLASS
===================================*/

$stmt = $conn->prepare("

INSERT INTO classes

(

class_name,

instructor,

description,

schedule,

duration,

capacity,

difficulty,

class_image,

status

)

VALUES

(

?,

?,

?,

?,

?,

?,

?,

?,

?

)

");

$stmt->bind_param(

"ssssiisss",

$class_name,

$instructor,

$description,

$schedule,

$duration,

$capacity,

$difficulty,

$imageName,

$status

);

if($stmt->execute())
{

echo "

<script>

alert('Fitness Class Created Successfully!');

window.location='classes.php';

</script>

";

}
else
{

echo "

<script>

alert('Database Error: ".$stmt->error."');

window.location='classes.php';

</script>

";

}

$stmt->close();

$conn->close();

?>