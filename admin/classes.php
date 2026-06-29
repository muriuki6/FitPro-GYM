<?php
include '../includes/auth.php';
include '../config/database.php';

if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit();
}

/* ===============================
   CLASS STATISTICS
================================ */

$totalClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
")->fetch_assoc()['total'];

$activeClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
WHERE status='Active'
")->fetch_assoc()['total'];

$inactiveClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
WHERE status='Inactive'
")->fetch_assoc()['total'];

$totalCapacity = $conn->query("
SELECT IFNULL(SUM(capacity),0) AS total
FROM classes
")->fetch_assoc()['total'];

$todayClasses = $conn->query("
SELECT COUNT(*) AS total
FROM classes
WHERE DATE(schedule)=CURDATE()
")->fetch_assoc()['total'];

/* ===============================
   LOAD CLASSES
================================ */

$classes = $conn->query("
SELECT *
FROM classes
ORDER BY schedule ASC
");


include '../includes/header.php';
?>



<!-- ==========================================
     ADD CLASS MODAL
========================================== -->

<div class="modal fade"
id="addClassModal"
tabindex="-1">

<div class="modal-dialog modal-xl">

<div class="modal-content border-0 shadow-lg">

<div class="modal-header bg-primary text-white">

<h4 class="modal-title">

<i class="fa-solid fa-dumbbell"></i>

Create New Fitness Class

</h4>

<button
type="button"
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<form
action="add_class.php"
method="POST"
enctype="multipart/form-data">

<div class="modal-body">

<div class="row">

<!-- Class Image -->

<div class="col-md-4 text-center">

<img
id="previewImage"
src="../assets/images/default-class.jpg"
class="img-fluid rounded shadow mb-3"
style="height:250px;width:100%;object-fit:cover;">

<input
type="file"
name="class_image"
class="form-control"
accept="image/*"
onchange="previewClassImage(event)">

<small class="text-muted">
Recommended: 800 × 600 pixels
</small>

</div>

<!-- Details -->

<div class="col-md-8">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Class Name

</label>

<input
type="text"
name="class_name"
class="form-control"
placeholder="e.g Weight Training"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Instructor

</label>

<input
type="text"
name="instructor"
class="form-control"
placeholder="Instructor Name"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">

Description

</label>

<textarea
name="description"
class="form-control"
rows="4"
placeholder="Describe this class..."
required></textarea>

</div>

<div class="row">

<div class="col-md-4 mb-3">

<label>

Schedule

</label>

<input
type="datetime-local"
name="schedule"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label>

Duration (Minutes)

</label>

<input
type="number"
name="duration"
class="form-control"
value="60"
min="15"
required>

</div>

<div class="col-md-4 mb-3">

<label>

Capacity

</label>

<input
type="number"
name="capacity"
class="form-control"
value="20"
min="1"
required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Difficulty

</label>

<select
name="difficulty"
class="form-select">

<option>Beginner</option>

<option>Intermediate</option>

<option>Advanced</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>

Status

</label>

<select
name="status"
class="form-select">

<option value="Active">
Active
</option>

<option value="Inactive">
Inactive
</option>

</select>

</div>

</div>

</div>

</div>

</div>

<div class="modal-footer">

<button
type="button"
class="btn btn-secondary"
data-bs-dismiss="modal">

Cancel

</button>

<button
type="submit"
class="btn btn-primary">

<i class="fa fa-save"></i>

Save Class

</button>

</div>

</form>

</div>

</div>

</div>

<script>

function previewClassImage(event){

const reader = new FileReader();

reader.onload = function(){

document
.getElementById("previewImage")
.src = reader.result;

};

reader.readAsDataURL(event.target.files[0]);

}

</script>



<!-- ==========================================
     JAVASCRIPT
========================================== -->

<script>

// ===============================
// LIVE SEARCH
// ===============================

document.getElementById("searchClass").addEventListener("keyup", function(){

let value = this.value.toLowerCase();

let cards = document.querySelectorAll(".class-item");

cards.forEach(function(card){

let text = card.innerText.toLowerCase();

if(text.indexOf(value) > -1){

card.style.display = "";

}else{

card.style.display = "none";

}

});

});


// ===============================
// FILTER BY DIFFICULTY
// ===============================

document.getElementById("difficultyFilter").addEventListener("change", filterCards);


// ===============================
// FILTER BY STATUS
// ===============================

document.getElementById("statusFilter").addEventListener("change", filterCards);


// ===============================
// FILTER BY DATE
// ===============================

document.getElementById("dateFilter").addEventListener("change", filterCards);


// ===============================
// MAIN FILTER FUNCTION
// ===============================

function filterCards(){

let difficulty =
document.getElementById("difficultyFilter").value.toLowerCase();

let status =
document.getElementById("statusFilter").value.toLowerCase();

let date =
document.getElementById("dateFilter").value;

let cards =
document.querySelectorAll(".class-item");

cards.forEach(function(card){

let text =
card.innerText.toLowerCase();

let show = true;

if(difficulty !== "" && !text.includes(difficulty))
show = false;

if(status !== "" && !text.includes(status))
show = false;

if(date !== ""){

let formatted =
new Date(date)
.toLocaleDateString("en-GB",{

day:"2-digit",

month:"short",

year:"numeric"

}).toLowerCase();

if(!text.includes(formatted))
show = false;

}

card.style.display = show ? "" : "none";

});

}


// ===============================
// RESET FILTERS
// ===============================

document.getElementById("clearFilters").addEventListener("click",function(){

document.getElementById("searchClass").value="";

document.getElementById("difficultyFilter").value="";

document.getElementById("statusFilter").value="";

document.getElementById("dateFilter").value="";

document.querySelectorAll(".class-item").forEach(function(card){

card.style.display="";

});

});


// ===============================
// DELETE CONFIRMATION
// ===============================

document.querySelectorAll(".deleteClass").forEach(function(button){

button.addEventListener("click",function(e){

if(!confirm("Are you sure you want to delete this class?")){

e.preventDefault();

}

});

});

</script>




<div class="d-flex">

<?php include '../includes/sidebar.php'; ?>

<div class="content flex-grow-1">

<?php include '../includes/navbar.php'; ?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">
<i class="fa-solid fa-dumbbell text-primary"></i>
Fitness Classes
</h2>

<p class="text-muted mb-0">
Manage all gym classes, schedules and instructors.
</p>

</div>

<button
class="btn btn-primary btn-lg rounded-pill"
data-bs-toggle="modal"
data-bs-target="#addClassModal">

<i class="fa fa-plus"></i>

Add Class

</button>

</div>

<!-- =============================
     STATISTICS
============================= -->

<div class="row g-4 mb-4">

<div class="col-lg-3 col-md-6">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<h6 class="text-muted">
Total Classes
</h6>

<h2 class="fw-bold">
<?= $totalClasses ?>
</h2>

</div>

<i class="fa-solid fa-dumbbell fa-3x text-primary"></i>

</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<h6 class="text-muted">
Active Classes
</h6>

<h2 class="fw-bold text-success">
<?= $activeClasses ?>
</h2>

</div>

<i class="fa-solid fa-circle-check fa-3x text-success"></i>

</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<h6 class="text-muted">
Total Capacity
</h6>

<h2 class="fw-bold text-info">
<?= $totalCapacity ?>
</h2>

</div>

<i class="fa-solid fa-users fa-3x text-info"></i>

</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<h6 class="text-muted">
Today's Classes
</h6>

<h2 class="fw-bold text-warning">
<?= $todayClasses ?>
</h2>

</div>

<i class="fa-solid fa-calendar-day fa-3x text-warning"></i>

</div>

</div>

</div>

</div>

</div>

<!-- =============================
     SEARCH & FILTERS
============================= -->

<div class="card shadow border-0 rounded-4 mb-4">

<div class="card-body">

<div class="row g-3">

<div class="col-lg-4">

<input
type="text"
id="searchClass"
class="form-control"
placeholder="Search class or instructor...">

</div>

<div class="col-lg-2">

<select
id="difficultyFilter"
class="form-select">

<option value="">All Levels</option>

<option>Beginner</option>

<option>Intermediate</option>

<option>Advanced</option>

</select>

</div>

<div class="col-lg-2">

<select
id="statusFilter"
class="form-select">

<option value="">All Status</option>

<option>Active</option>

<option>Inactive</option>

</select>

</div>

<div class="col-lg-2">

<input
type="date"
id="dateFilter"
class="form-control">

</div>

<div class="col-lg-2 d-grid">

<button
class="btn btn-dark"
id="clearFilters">

<i class="fa fa-rotate-left"></i>

Reset

</button>

</div>

</div>

</div>

</div>

<div id="classContainer">

<div class="row g-4">

<?php

if($classes->num_rows > 0):

while($row = $classes->fetch_assoc()):

$image = !empty($row['class_image'])
? "../assets/images/classes/".$row['class_image']
: "../assets/images/default-class.jpg";

$capacity = (int)$row['capacity'];

$duration = (int)$row['duration'];

?>

<div class="col-lg-4 col-md-6 class-item">

<div class="card border-0 shadow-lg rounded-4 h-100 class-card">

<div class="position-relative">

<img
src="<?= $image ?>"
class="card-img-top rounded-top-4"
style="height:220px;object-fit:cover;">

<?php

if($row['status']=="Active"){

echo '<span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">
Active
</span>';

}else{

echo '<span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">
Inactive
</span>';

}

?>

</div>

<div class="card-body">

<h4 class="fw-bold mb-3">

<i class="fa-solid fa-dumbbell text-primary"></i>

<?= htmlspecialchars($row['class_name']) ?>

</h4>

<p class="text-muted mb-3">

<?= nl2br(htmlspecialchars($row['description'])) ?>

</p>

<hr>

<div class="mb-2">

<i class="fa-solid fa-user text-primary"></i>

<strong>Instructor:</strong>

<?= htmlspecialchars($row['instructor']) ?>

</div>

<div class="mb-2">

<i class="fa-solid fa-calendar-days text-success"></i>

<strong>Schedule:</strong>

<?= date("D, d M Y",strtotime($row['schedule'])) ?>

</div>

<div class="mb-2">

<i class="fa-solid fa-clock text-warning"></i>

<strong>Time:</strong>

<?= date("h:i A",strtotime($row['schedule'])) ?>

</div>

<div class="mb-2">

<i class="fa-solid fa-stopwatch text-info"></i>

<strong>Duration:</strong>

<?= $duration ?> Minutes

</div>

<div class="mb-3">

<i class="fa-solid fa-users text-secondary"></i>

<strong>Capacity:</strong>

<?= $capacity ?> Members

</div>

<div class="d-flex justify-content-between align-items-center mb-3">

<span class="badge bg-primary px-3 py-2">

<?= $row['difficulty'] ?>

</span>

<small class="text-muted">

Created

<?= date("d M Y",strtotime($row['created_at'])) ?>

</small>

</div>

<div class="progress mb-3" style="height:10px;">

<div
class="progress-bar bg-success"
style="width:100%">

</div>

</div>

<div class="d-flex justify-content-between">

<a
href="view_class.php?id=<?= $row['id'] ?>"
class="btn btn-info btn-sm">

<i class="fa fa-eye"></i>

View

</a>

<a
href="edit_class.php?id=<?= $row['id'] ?>"
class="btn btn-warning btn-sm">

<i class="fa fa-edit"></i>

Edit

</a>

<a
href="delete_class.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm deleteClass"
onclick="return confirm('Delete this class?')">

<i class="fa fa-trash"></i>

Delete

</a>

</div>

</div>

</div>

</div>

<?php

endwhile;

else:

?>

<div class="col-12">

<div class="card shadow border-0">

<div class="card-body text-center py-5">

<i class="fa-solid fa-dumbbell fa-5x text-secondary mb-4"></i>

<h3>

No Fitness Classes Found

</h3>

<p class="text-muted">

Click the <strong>Add Class</strong> button to create your first class.

</p>

<button
class="btn btn-primary btn-lg"
data-bs-toggle="modal"
data-bs-target="#addClassModal">

<i class="fa fa-plus"></i>

Create First Class

</button>

</div>

</div>

</div>

<?php endif; ?>

</div>

</div>

<style>

.class-card{

transition:.35s;

overflow:hidden;

}

.class-card:hover{

transform:translateY(-10px);

box-shadow:0 20px 40px rgba(0,0,0,.15)!important;

}

.class-card img{

transition:.5s;

}

.class-card:hover img{

transform:scale(1.05);

}

.progress{

border-radius:20px;

}

.badge{

font-size:.8rem;

}

</style>

</div>

</div>

</div>

</div>