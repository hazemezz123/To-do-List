<!DOCTYPE html>
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "todoapp");

if (!$conn) {
    die("Connection error has occurred: " . mysqli_connect_error());
}

if (isset($_GET['id']) && isset($_GET['title'])) {
    $the_id = intval($_GET['id']);
    $the_title = htmlspecialchars($_GET['title']);
} else {
    die("Invalid parameters.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
    $New_title = mysqli_real_escape_string($conn, $_POST['title']);

    $sql = "UPDATE tasks SET title = '$New_title' WHERE id = $the_id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Task updated successfully.";
        header("Location: ../src/index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>My PHP Tailwind Project</title>
    <style>
        body {
            font-family: Montserrat;
            background: linear-gradient(45deg, #000, #333);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        section {
            height: 100vh;
            overflow-x: hidden;
        }

        main>form>button {
            -webkit-box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
            -moz-box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
            box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
        }

        .Custom {
            font-weight: 700;
        }

        section>p {
            font-weight: 600;
            font-size: large;
        }

        section form {
            background: rgba(255, 255, 255, 0.05);
            -webkit-backdrop-filter: blur(9px);
            backdrop-filter: blur(9px);
            border: 1px solid rgba(255, 255, 255, 0.025);
            border-radius: 10px;
        }

        section {
            overflow-x: hidden;

        }
    </style>
</head>

<body>
    <section class="w-screen  items-center flex flex-col mt-10 mx-10">
        <h1 class="text-center text-7xl text-[#5f6eb1] mt-5 uppercase ">Update your task</h1>
        <p class="text-center text-5xl text-[#5f6eb1] mt-5 uppercase"><span class="Custom">Your Task : </span> " <?php echo $the_title;  ?> "</p>
        <form action="" method="POST" class="border border-1 p-6 flex justify-center items-center flex-col w-96 my-20 gap-4 shadow-lg">
            <input name="title" class="w-full bg-transparent placeholder:text-white text-white text-lg border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow-lg  hover:shadow-md  placeholder:opacity-75 placeholder:transition-all" placeholder="Type here...">
            <button class="border-1 border bg-transparent text-white px-4 py-3 rounded-lg w-full text-lg transition-all hover:bg-[#171717e1]">Update</button>
        </form>
    </section>
</body>