<?php
session_start();
if (isset($_GET['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "todoapp");

    if (!$conn) {
        die("Connection error has occurred: " . mysqli_connect_error());
    }

    $the_id = intval($_GET['id']);

    $sql = "DELETE FROM `tasks` WHERE `id` = $the_id";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 1) {
        $_SESSION["delete"] = "Data deleted successfully";
    } elseif (mysqli_affected_rows($conn) == 0) {
        $_SESSION["delete"] = "data not Found";
    }

    // Redirect the user back to the index page
    header("Location: ../src/index.php");
}
mysqli_close($conn); // Close the connection
