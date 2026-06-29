<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 2){
    header("Location: ../login.php");
    exit();
}

$message = "";
$messageType = "info";
$userId = $_SESSION['user_id'];
$trainerId = $_SESSION['trainer_id'] ?? 0;

// Fetch current user data
$userStmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();

// Fetch trainer details
$trainerData = [];
if($trainerId > 0){
    $trainerStmt = $conn->prepare("SELECT * FROM trainers WHERE user_id=? LIMIT 1");
    $trainerStmt->bind_param("i", $userId);
    $trainerStmt->execute();
    $trainerResult = $trainerStmt->get_result();
    if($trainerResult->num_rows > 0){
        $trainerData = $trainerResult->fetch_assoc();
    }
}

// Fetch trainer statistics
$clientCount = 0;
$sessionsThisMonth = 0;
$totalSessions = 0;

if($trainerId > 0){
    // Client count
    $clientStmt = $conn->prepare("
        SELECT COUNT(*) total FROM trainer_members 
        WHERE trainer_id=?
    ");
    $clientStmt->bind_param("i", $trainerId);
    $clientStmt->execute();
    $clientCount = $clientStmt->get_result()->fetch_assoc()['total'];
    
    // Sessions this month
    $monthStmt = $conn->prepare("
        SELECT COUNT(*) total FROM training_sessions 
        WHERE trainer_id=? 
        AND MONTH(session_date)=MONTH(CURDATE())
        AND YEAR(session_date)=YEAR(CURDATE())
    ");
    $monthStmt->bind_param("i", $trainerId);
    $monthStmt->execute();
    $sessionsThisMonth = $monthStmt->get_result()->fetch_assoc()['total'];
    
    // Total sessions
    $totalStmt = $conn->prepare("
        SELECT COUNT(*) total FROM training_sessions 
        WHERE trainer_id=?
    ");
    $totalStmt->bind_param("i", $trainerId);
    $totalStmt->execute();
    $totalSessions = $totalStmt->get_result()->fetch_assoc()['total'];
}

// Handle profile update
if(isset($_POST['update_profile'])){
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    // Validate inputs
    if(empty($fullname) || empty($email)){
        $message = "Full name and email are required.";
        $messageType = "danger";
    }
    else if($email !== $userData['email']){
        // Check if email is already taken
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email=? AND id!=?");
        $checkEmail->bind_param("si", $email, $userId);
        $checkEmail->execute();
        if($checkEmail->get_result()->num_rows > 0){
            $message = "Email already in use by another account.";
            $messageType = "danger";
        }
        else{
            // Update email
            $updateUser = $conn->prepare("UPDATE users SET fullname=?, email=?, phone=? WHERE id=?");
            $updateUser->bind_param("sssi", $fullname, $email, $phone, $userId);
            if($updateUser->execute()){
                $_SESSION['fullname'] = $fullname;
                $message = "Profile updated successfully!";
                $messageType = "success";
                $userData['fullname'] = $fullname;
                $userData['email'] = $email;
                $userData['phone'] = $phone;
            }
            else{
                $message = "Error updating profile.";
                $messageType = "danger";
            }
        }
    }
    else{
        // Email unchanged
        $updateUser = $conn->prepare("UPDATE users SET fullname=?, phone=? WHERE id=?");
        $updateUser->bind_param("ssi", $fullname, $phone, $userId);
        if($updateUser->execute()){
            $_SESSION['fullname'] = $fullname;
            $message = "Profile updated successfully!";
            $messageType = "success";
            $userData['fullname'] = $fullname;
            $userData['phone'] = $phone;
        }
        else{
            $message = "Error updating profile.";
            $messageType = "danger";
        }
    }
    
    // Update trainer details if exist
    if($trainerId > 0 && $messageType === "success"){
        $updateTrainer = $conn->prepare("
            UPDATE trainers 
            SET specialization=?, bio=? 
            WHERE user_id=?
        ");
        $updateTrainer->bind_param("ssi", $specialization, $bio, $userId);
        $updateTrainer->execute();
        $trainerData['specialization'] = $specialization;
        $trainerData['bio'] = $bio;
    }
}

// Handle password change
if(isset($_POST['change_password'])){
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if(!password_verify($current_password, $userData['password'])){
        $message = "Current password is incorrect.";
        $messageType = "danger";
    }
    else if(empty($new_password) || strlen($new_password) < 6){
        $message = "New password must be at least 6 characters.";
        $messageType = "danger";
    }
    else if($new_password !== $confirm_password){
        $message = "Passwords do not match.";
        $messageType = "danger";
    }
    else{
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $updatePass = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $updatePass->bind_param("si", $hashed, $userId);
        if($updatePass->execute()){
            $message = "Password changed successfully!";
            $messageType = "success";
        }
        else{
            $message = "Error changing password.";
            $messageType = "danger";
        }
    }
}

// Fetch recent sessions
$recentSessions = [];
if($trainerId > 0){
    $sessionStmt = $conn->prepare("
        SELECT ts.*, u.fullname as member_name
        FROM training_sessions ts
        LEFT JOIN users u ON ts.member_id = u.id
        WHERE ts.trainer_id=?
        ORDER BY ts.session_date DESC
        LIMIT 5
    ");
    $sessionStmt->bind_param("i", $trainerId);
    $sessionStmt->execute();
    $sessionResult = $sessionStmt->get_result();
    while($row = $sessionResult->fetch_assoc()){
        $recentSessions[] = $row;
    }
}

include '../includes/header.php';
?>

<div class="d-flex">
    <?php include '../includes/sidebar.php'; ?>
    <div class="content flex-grow-1">
        <?php include '../includes/navbar.php'; ?>
        
        <div class="container-fluid mt-4">
            
            <div class="card management-hero shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-1"><i class="fa fa-user-tie"></i> Trainer Profile</h3>
                    <p class="mb-0 opacity-75">Manage your professional information, specializations, and account settings.</p>
                </div>
            </div>
            
            <?php if($message !== ""): ?>
            <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show shadow" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <!-- Trainer Statistics -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card member-stat shadow h-100">
                        <div class="card-body">
                            <i class="fa fa-users text-primary fa-2x mb-3"></i>
                            <h6>Active Clients</h6>
                            <h4><?= number_format($clientCount) ?></h4>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card member-stat shadow h-100">
                        <div class="card-body">
                            <i class="fa fa-calendar-check text-success fa-2x mb-3"></i>
                            <h6>This Month Sessions</h6>
                            <h4><?= number_format($sessionsThisMonth) ?></h4>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card member-stat shadow h-100">
                        <div class="card-body">
                            <i class="fa fa-dumbbell text-warning fa-2x mb-3"></i>
                            <h6>Total Sessions</h6>
                            <h4><?= number_format($totalSessions) ?></h4>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card member-stat shadow h-100">
                        <div class="card-body">
                            <i class="fa fa-star text-danger fa-2x mb-3"></i>
                            <h6>Rating</h6>
                            <h4><?= isset($trainerData['rating']) ? $trainerData['rating'] : 'N/A' ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Account Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-secondary text-white">
                            <i class="fa fa-id-card"></i> Account Information
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($userData['fullname'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($userData['phone'] ?? '') ?>">
                                </div>
                                
                                <button type="submit" name="update_profile" class="btn btn-primary w-100">
                                    <i class="fa fa-save"></i> Update Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Professional Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-info text-white">
                            <i class="fa fa-briefcase"></i> Professional Details
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Specialization</label>
                                    <input type="text" name="specialization" class="form-control" value="<?= htmlspecialchars($trainerData['specialization'] ?? '') ?>" placeholder="e.g., Strength Training, Yoga, HIIT">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Bio / About Me</label>
                                    <textarea name="bio" class="form-control" rows="4" placeholder="Share your expertise and training philosophy..."><?= htmlspecialchars($trainerData['bio'] ?? '') ?></textarea>
                                </div>
                                
                                <button type="submit" name="update_profile" class="btn btn-info w-100">
                                    <i class="fa fa-save"></i> Update Professional Info
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security Settings -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-warning text-dark">
                            <i class="fa fa-lock"></i> Security Settings
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" minlength="6" required>
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                                </div>
                                
                                <button type="submit" name="change_password" class="btn btn-warning w-100 text-dark">
                                    <i class="fa fa-key"></i> Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Trainer Credentials -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-success text-white">
                            <i class="fa fa-certificate"></i> Credentials
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Trainer ID</label>
                                <p class="h6"><?= htmlspecialchars($trainerData['trainer_code'] ?? 'N/A') ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <p class="h6">
                                    <span class="badge <?= isset($trainerData['status']) && $trainerData['status'] == 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($trainerData['status'] ?? 'Inactive') ?>
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Account Created</label>
                                <p class="h6"><?= isset($userData['created_at']) ? date('M d, Y', strtotime($userData['created_at'])) : 'Unknown' ?></p>
                            </div>
                            
                            <div class="alert alert-info mb-0">
                                <i class="fa fa-info-circle"></i> For credential updates or certifications, please contact the administrator.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Training Sessions -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card management-panel shadow">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-history"></i> Recent Training Sessions
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle management-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Member</th>
                                            <th>Duration (mins)</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($recentSessions) > 0): ?>
                                            <?php foreach($recentSessions as $session): ?>
                                            <tr>
                                                <td><?= isset($session['session_date']) ? date('M d, Y h:i A', strtotime($session['session_date'])) : '-' ?></td>
                                                <td><?= htmlspecialchars($session['member_name'] ?? 'Unknown') ?></td>
                                                <td><?= htmlspecialchars($session['duration'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($session['session_type'] ?? 'Standard') ?></td>
                                                <td>
                                                    <span class="badge <?= ($session['status'] ?? '') == 'Completed' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                                        <?= htmlspecialchars($session['status'] ?? 'Pending') ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="5" class="text-center text-muted">No training sessions yet.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
