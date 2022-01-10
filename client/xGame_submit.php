<?php
include('constant.php');
session_start();

if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}   

if (isset($_POST['answer'])) {
    require('socket_config.php');

    // send result to server
    // send pass minigame message to server
    $token = intval($_SESSION['token']);
    $user_id = intval($_SESSION['user-id']);
    $no_question = intval($_SESSION['no_question']);
    $answer = intval($_POST['answer']);
    $msg = ANSWER . "|" . $token . "|" . $user_id . "|" . $no_question . "|" . $answer;
    socket_write($socket, $msg, strlen($msg));
    echo $answer;
    if ($answer == 1){
        $_SESSION['no_question'] = intval($_SESSION['no_question']) + 1;
        echo "<script>window.location.href = 'game3.php';</script>";
    }
    else {
        echo "<script>window.location.href = 'result.php';</script>";
    }
}

?>