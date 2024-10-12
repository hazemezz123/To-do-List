<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "todoapp");

if (!$conn) {
    die("Connection error has occurred: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title  = trim(htmlentities($_POST['title']));

    if (!empty($title)) {
        $sql = "INSERT INTO `tasks` (`title`) VALUES ('$title')";
        $result = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 1) {
            $_SESSION['success'] = "Data inserted successfully";
        } else {
            $_SESSION['error'] = "Failed to insert data: " . mysqli_error($conn);
        }
    } else {
        $_SESSION["error"] = "It's an empty task!";
    }

    header("Location: ../src/index.php");
    exit();
}

mysqli_close($conn);
