<?php session_start();
$conn = mysqli_connect("localhost", "root", "", "todoapp");
if (!$conn) {
    die("Connection error has occurred: " . mysqli_connect_error());
}
$sql = "SELECT * FROM `tasks` ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="output.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>My PHP Tailwind Project</title>
    <script>
        function markComplete(taskId) {
            var taskRow = document.getElementById(`task-${taskId}`);
            taskRow.classList.toggle('line-through');
        }
    </script>
    <style>
        .line-through {
            text-decoration: line-through;
            color: gray;
        }

        body {
            font-family: "Montserrat", sans-serif;
        }

        section {
            height: 100vh;
            overflow-x: hidden;
            background-image: url("data:image/svg+xml,<svg id='patternId' width='100%' height='100%' xmlns='http://www.w3.org/2000/svg'><defs><pattern id='a' patternUnits='userSpaceOnUse' width='20' height='20' patternTransform='scale(2) rotate(0)'><rect x='0' y='0' width='100%' height='100%' fill='%230e0c0cff'/><path d='M 10,-2.55e-7 V 20 Z M -1.1677362e-8,10 H 20 Z'  stroke-width='1' stroke='%232b2b31ff' fill='none'/></pattern></defs><rect width='800%' height='800%' transform='translate(0,0)' fill='url(%23a)'/></svg>")
        }

        main>form>button {
            -webkit-box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
            -moz-box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
            box-shadow: 0px 0px 262px 23px rgba(79, 91, 147, 0.73);
        }
    </style>
</head>

<body>
    <section>
        <h1 class="text-center text-7xl text-[#5f6eb1] mt-5 ">-- To Do List --</h1>
        <main class="w-screen justify-center items-center flex flex-col">
            <form action="../../my-php-tailwind-project/handlers/storeTask.php" method="POST" class="border border-1 p-6 flex justify-center items-center flex-col w-96 my-20 gap-4 shadow-lg">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="text-white p-10 bg-emerald-500 rounded-2xl w-full">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['delete'])): ?>
                    <div class="text-white p-10 bg-red-500 rounded-2xl w-full">
                        <?php
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="text-white p-4 bg-red-500 rounded-md mb-4">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']); // Remove the message after displaying it
                        ?>
                    </div>
                <?php endif; ?>
                <input name="title" class="w-full  bg-transparent placeholder:text-white text-white text-lg border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow-lg  hover:shadow-md  placeholder:opacity-75 placeholder:transition-all" placeholder="Type here...">
                <button class="border-1 border bg-transparent text-white px-4 py-3 rounded-lg w-full text-lg transition-all hover:bg-[#171717e1]">Add..</button>
            </form>
            <div>
                <table class="w-[800px] text-white   shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-[#4F5B93] text-white ">
                        <tr>
                            <th class="py-2 px-4 text-left font-normal">No</th>
                            <th class="py-2 px-4 text-left font-normal">#</th>
                            <th class="py-2 px-4 text-left font-normal">Task</th>
                            <th class="py-2 px-4 text-center font-normal">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr class="border-b">
                                <td class="py-2 px-4"><?php echo $num; ?></td> <!-- Auto-increment number -->
                                <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                                <td id="task-<?php echo $row['id']; ?>" class="py-2 px-4"><?php echo $row['title']; ?></td>
                                <td class="py-2 px-4 flex justify-center items-center gap-2">
                                    <a href="../handlers/Update-task.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['title']; ?>">
                                        <button class="bg-[#4F5B93] text-white px-4 py-1 rounded-md hover:bg-[#4f5b93c2] transition-all flex gap-x-2 ">Edit
                                            <img src="../assets/image.png" class="w-5" alt="">
                                        </button>
                                    </a>
                                    <a href="../handlers/delete-task.php?id=<?php echo $row['id']; ?>">
                                        <button class="bg-[#c73838] text-white px-4 py-1 rounded-md hover:bg-[#c73838d7] transition-all flex gap-x-2 justify-center items-center">Delete
                                            <img class="w-5" src="../assets/bin.png" alt="">
                                        </button>
                                    </a>
                                    <button onclick="markComplete(<?php echo $row['id']; ?>)" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-500/80 transition-all flex gap-x-2 justify-center items-center">Complete
                                        <img class="w-5" src="../assets/check-mark.png" alt="">
                                    </button>
                                </td>
                            </tr>
                        <?php
                            $num++; // Increment the counter
                        endwhile;
                        ?>

                    </tbody>
                </table>
            </div>
        </main>
    </section>
</body>

</html>