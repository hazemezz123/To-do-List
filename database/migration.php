<?php


$conn = mysqli_connect("localhost", "root", "", "todoapp");

if ($conn->connect_error) {
    echo "error";
}

$sql = "CREATE TABLE tasks (
`id` INT primary key AUTO_INCREMENT,
`title` VARCHAR(200) NOT NULL
)";

$result  = mysqli_query($conn, $sql);


if ($result) {
    echo "table add";
} else {
    mysqli_error($conn);
}
