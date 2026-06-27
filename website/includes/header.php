<?php
require_once __DIR__ . '/../../config/database.php';

$pageTitle = $pageTitle ?? 'FitPro Gym | Premium Fitness Center';
$pageDescription = $pageDescription ?? 'Premium fitness center with expert trainers, modern equipment, dynamic classes, flexible memberships, and member tracking.';
$activePage = $activePage ?? '';

if(!function_exists('h')){
    function h($value){
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if(!function_exists('money')){
    function money($amount){
        return 'KES ' . number_format((float)$amount, 2);
    }
}

if(!function_exists('rows')){
    function rows($result){
        $items = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $items[] = $row;
            }
        }
        return $items;
    }
}

if(!function_exists('table_exists')){
    function table_exists($conn, $table){
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $table)){
            return false;
        }

        $safeTable = $conn->real_escape_string($table);
        $result = $conn->query("SHOW TABLES LIKE '{$safeTable}'");
        if(!$result){
            return false;
        }

        return $result->num_rows > 0;
    }
}

if(!function_exists('website_count')){
    function website_count($conn, $table, $where = '1=1'){
        if(!table_exists($conn, $table)){
            return 0;
        }

        $result = $conn->query("SELECT COUNT(*) total FROM {$table} WHERE {$where}");
        return $result ? (int)$result->fetch_assoc()['total'] : 0;
    }
}

if(!function_exists('website_query_rows')){
    function website_query_rows($conn, $table, $sql){
        if(!table_exists($conn, $table)){
            return [];
        }

        return rows($conn->query($sql));
    }
}

if(!function_exists('image_url')){
    function image_url($file){
        $file = trim((string)$file);
        return $file !== '' ? '../assets/images/' . rawurlencode($file) : 'assets/images/FitPro%20Gym%20Logo.png';
    }
}

if(!function_exists('short_text')){
    function short_text($value, $limit = 130){
        $text = trim(strip_tags((string)$value));
        if(strlen($text) <= $limit){
            return $text;
        }

        return substr($text, 0, $limit - 3) . '...';
    }
}

if(!function_exists('fallback_classes')){
    function fallback_classes(){
        return [
            ['name' => 'Strength Lab', 'category' => 'Strength', 'time' => 'Mon 6:00 AM', 'trainer' => 'FitPro Coach', 'level' => 'Intermediate', 'description' => 'Progressive strength training built around safe form, confidence, and measurable weekly progress.'],
            ['name' => 'HIIT Burn', 'category' => 'Cardio', 'time' => 'Tue 6:30 PM', 'trainer' => 'FitPro Coach', 'level' => 'All Levels', 'description' => 'Fast rounds, smart recovery, and a high-energy room designed to improve endurance.'],
            ['name' => 'Mobility Flow', 'category' => 'Recovery', 'time' => 'Thu 7:00 AM', 'trainer' => 'FitPro Coach', 'level' => 'Beginner', 'description' => 'Move better, breathe deeper, and recover with guided mobility and flexibility work.'],
            ['name' => 'Box Fit', 'category' => 'Conditioning', 'time' => 'Sat 9:00 AM', 'trainer' => 'FitPro Coach', 'level' => 'All Levels', 'description' => 'Boxing-inspired conditioning with pads, footwork, core work, and sweat.'],
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= h($pageDescription) ?>">
<meta name="keywords" content="FitPro Gym, fitness, gym membership, trainers, classes, Nairobi gym">
<meta name="author" content="FitPro Gym">
<meta name="theme-color" content="#dc2626">
<meta property="og:title" content="<?= h($pageTitle) ?>">
<meta property="og:description" content="<?= h($pageDescription) ?>">
<meta property="og:type" content="website">
<title><?= h($pageTitle) ?></title>
<link rel="icon" href="assets/images/FitPro%20Gym%20Logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="loading-screen">
<div class="loader-mark"><i class="fa fa-dumbbell"></i></div>
</div>
<?php include __DIR__ . '/navbar.php'; ?>
