<?php
include '../includes/auth.php';
include '../config/database.php';

if($_SESSION['role_id'] != 3){
    header("Location: ../login.php");
    exit();
}

include '../includes/member_context.php';

$message = "";
$messageType = "info";
$memberId = $memberProfile['id'] ?? 0;
$userId = $_SESSION['user_id'];

// Fetch current user data
$userStmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();

// Fetch member medical info if exists
$medicalInfo = [];
if($memberId > 0){
    $medStmt = $conn->prepare("
        SELECT * FROM member_medical_info 
        WHERE member_id=? LIMIT 1
    ");
    $medStmt->bind_param("i", $memberId);
    $medStmt->execute();
    $medResult = $medStmt->get_result();
    if($medResult->num_rows > 0){
        $medicalInfo = $medResult->fetch_assoc();
    }
}

// Handle profile update
if(isset($_POST['update_profile'])){
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    
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
                // Refresh user data
                $userData['fullname'] = $fullname;
                $userData['email'] = $email;
                $userData['phone'] = $phone;
            }
            else{
                $message = "Error updating profile. Please try again.";
                $messageType = "danger";
            }
        }
    }
    else{
        // Email unchanged, just update other fields
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
            $message = "Error updating profile. Please try again.";
            $messageType = "danger";
        }
    }
}

// Handle medical info update
if(isset($_POST['update_medical'])){
    $blood_type = $_POST['blood_type'] ?? '';
    $allergies = trim($_POST['allergies'] ?? '');
    $medical_conditions = trim($_POST['medical_conditions'] ?? '');
    $emergency_contact = trim($_POST['emergency_contact'] ?? '');
    $emergency_phone = trim($_POST['emergency_phone'] ?? '');
    
    if(empty($medicalInfo) && $memberId > 0){
        // Insert new medical info
        $insertMed = $conn->prepare("
            INSERT INTO member_medical_info 
            (member_id, blood_type, allergies, medical_conditions, emergency_contact, emergency_phone)
            VALUES(?, ?, ?, ?, ?, ?)
        ");
        $insertMed->bind_param("isssss", $memberId, $blood_type, $allergies, $medical_conditions, $emergency_contact, $emergency_phone);
        if($insertMed->execute()){
            $message = "Medical information saved successfully!";
            $messageType = "success";
            // Refresh medical data
            $medicalInfo = [
                'blood_type' => $blood_type,
                'allergies' => $allergies,
                'medical_conditions' => $medical_conditions,
                'emergency_contact' => $emergency_contact,
                'emergency_phone' => $emergency_phone
            ];
        }
        else{
            $message = "Error saving medical information.";
            $messageType = "danger";
        }
    }
    else if($memberId > 0){
        // Update existing medical info
        $updateMed = $conn->prepare("
            UPDATE member_medical_info 
            SET blood_type=?, allergies=?, medical_conditions=?, emergency_contact=?, emergency_phone=?
            WHERE member_id=?
        ");
        $updateMed->bind_param("sssssi", $blood_type, $allergies, $medical_conditions, $emergency_contact, $emergency_phone, $memberId);
        if($updateMed->execute()){
            $message = "Medical information updated successfully!";
            $messageType = "success";
            $medicalInfo = [
                'blood_type' => $blood_type,
                'allergies' => $allergies,
                'medical_conditions' => $medical_conditions,
                'emergency_contact' => $emergency_contact,
                'emergency_phone' => $emergency_phone
            ];
        }
        else{
            $message = "Error updating medical information.";
            $messageType = "danger";
        }
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

include '../includes/header.php';
?>

<div class="d-flex">
    <?php include '../includes/sidebar.php'; ?>
    <div class="content flex-grow-1">
        <?php include '../includes/navbar.php'; ?>
        
        <div class="container-fluid mt-4">
            
            <div class="card management-hero shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-1"><i class="fa fa-user-circle"></i> My Profile</h3>
                    <p class="mb-0 opacity-75">Manage your account information, medical details, and security settings.</p>
                </div>
            </div>
            
            <?php if($message !== ""): ?>
            <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show shadow" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
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
                
                <!-- Membership Summary -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-info text-white">
                            <i class="fa fa-star"></i> Membership Summary
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Member ID</label>
                                <p class="h5"><?= htmlspecialchars($memberProfile['member_code'] ?? 'N/A') ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Membership Plan</label>
                                <p class="h5"><?= htmlspecialchars($memberProfile['plan_name'] ?? 'No Plan Assigned') ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <p class="h5"><?= member_status_badge($memberProfile['status'] ?? 'Pending') ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Expiry Date</label>
                                <p class="h5"><?= $memberProfile['expiry_date'] ? member_date($memberProfile['expiry_date']) : 'N/A' ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Days Remaining</label>
                                <p class="h5">
                                    <?php 
                                        $daysLeft = member_days_left($memberProfile['expiry_date'] ?? null);
                                        if($daysLeft === null) echo '-';
                                        else if($daysLeft >= 0) echo '<span class="badge bg-success">' . $daysLeft . ' days</span>';
                                        else echo '<span class="badge bg-danger">Expired</span>';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Medical Information -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-success text-white">
                            <i class="fa fa-heart-pulse"></i> Medical Information
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Blood Type</label>
                                    <select name="blood_type" class="form-select">
                                        <option value="">-- Select Blood Type --</option>
                                        <option value="O+" <?= ($medicalInfo['blood_type'] ?? '') == 'O+' ? 'selected' : '' ?>>O+</option>
                                        <option value="O-" <?= ($medicalInfo['blood_type'] ?? '') == 'O-' ? 'selected' : '' ?>>O-</option>
                                        <option value="A+" <?= ($medicalInfo['blood_type'] ?? '') == 'A+' ? 'selected' : '' ?>>A+</option>
                                        <option value="A-" <?= ($medicalInfo['blood_type'] ?? '') == 'A-' ? 'selected' : '' ?>>A-</option>
                                        <option value="B+" <?= ($medicalInfo['blood_type'] ?? '') == 'B+' ? 'selected' : '' ?>>B+</option>
                                        <option value="B-" <?= ($medicalInfo['blood_type'] ?? '') == 'B-' ? 'selected' : '' ?>>B-</option>
                                        <option value="AB+" <?= ($medicalInfo['blood_type'] ?? '') == 'AB+' ? 'selected' : '' ?>>AB+</option>
                                        <option value="AB-" <?= ($medicalInfo['blood_type'] ?? '') == 'AB-' ? 'selected' : '' ?>>AB-</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Allergies</label>
                                    <textarea name="allergies" class="form-control" rows="2" placeholder="List any allergies (e.g., Peanuts, Penicillin)"><?= htmlspecialchars($medicalInfo['allergies'] ?? '') ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Medical Conditions</label>
                                    <textarea name="medical_conditions" class="form-control" rows="2" placeholder="List any conditions (e.g., Asthma, Diabetes)"><?= htmlspecialchars($medicalInfo['medical_conditions'] ?? '') ?></textarea>
                                </div>
                                
                                <button type="submit" name="update_medical" class="btn btn-success w-100">
                                    <i class="fa fa-save"></i> Save Medical Info
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Emergency Contact -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-danger text-white">
                            <i class="fa fa-phone"></i> Emergency Contact
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" name="emergency_contact" class="form-control" value="<?= htmlspecialchars($medicalInfo['emergency_contact'] ?? '') ?>" placeholder="Full name of emergency contact">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="tel" name="emergency_phone" class="form-control" value="<?= htmlspecialchars($medicalInfo['emergency_phone'] ?? '') ?>" placeholder="Phone number">
                                </div>
                                
                                <div class="alert alert-info mb-3">
                                    <i class="fa fa-info-circle"></i> Emergency contact information will be used only in case of medical emergencies at the gym.
                                </div>
                                
                                <button type="submit" name="update_medical" class="btn btn-danger w-100">
                                    <i class="fa fa-save"></i> Update Emergency Contact
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
                
                <!-- Account Activity -->
                <div class="col-lg-6 mb-4">
                    <div class="card management-panel shadow h-100">
                        <div class="card-header bg-dark text-white">
                            <i class="fa fa-history"></i> Account Activity
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Account Created</label>
                                <p class="h6"><?= isset($userData['created_at']) ? date('M d, Y h:i A', strtotime($userData['created_at'])) : 'Unknown' ?></p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Last Login</label>
                                <p class="h6">Today</p>
                            </div>
                            
                            <div class="alert alert-secondary mb-3">
                                <i class="fa fa-shield"></i> Keep your password secure and never share it with anyone. Always log out when using shared devices.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<? include '';