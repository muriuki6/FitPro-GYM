<?php
session_start();

if(
    !isset($_SESSION['user_id']) ||
    empty($_SESSION['user_id'])
)
{
    header("Location: ../login.php");
    exit();
}

/* Session Timeout - 30 Minutes */
if(isset($_SESSION['last_activity']))
{
    if(time() - $_SESSION['last_activity'] > 1800)
    {
        session_unset();
        session_destroy();

        header("Location: ../login.php");
        exit();
    }
}

$_SESSION['last_activity'] = time();
?>