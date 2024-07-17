<?php
require_once "inc/functions.php";
$successInfo = "";
$task = $_GET["task"] ?? "report";

if ("seed" == $task) {
    putData(DB_NAME);
    $successInfo = "file create successful";
}
$allStudents = [];
if ("report" == $task) {
    $allStudents = getAllStudents(DB_NAME);
}

$info = "";
if (isset($_POST["submit"])) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, "roll", FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);

    if ($id) {
        if ($name != "" && $age != "" && $roll != "") {
            updateStudentData($id, $name, $age, $roll);
            header("location: index.php?task=report");
        }
    } else {
        if ($name != "" && $age != "" && $roll != "") {
            $addNewStudent = addStudent($name, $age, $roll);
            if ($addNewStudent) {
                header("location: index.php?task=report");
            } else {
                $info = "Roll is Unique";
            }
        }
    }
}

if ("delete" == $task && isset($_GET["id"])) {
    $id = $_GET["id"];
    deleteStudentsData($id);
    header("location: index.php?task=report");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CURD - Project</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>

<body>

    <section class="container">
        <h1>CURD - Project</h1>
        <?php
        include_once "inc/templates/nav.php"
        ?>
        <?php
        if ($successInfo != "") {
        ?>
            <blockquote style="color: green">
                <?php echo $successInfo; ?>
            </blockquote>
        <?php
        }
        ?>
    </section>

    <section class="container">
        <?php
        if ($info != "") {
        ?>
            <blockquote style="color: red">
                <?php echo $info; ?>
            </blockquote>
        <?php
        }
        ?>
    </section>

    <!-- Get All Students Data Start  -->
    <section class="container">
        <?php
        if ("report" == $task && $allStudents != "") {
        ?>
            <table>
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($allStudents as $student) {
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $student["id"] ?></td>
                            <td><?php echo $student["name"] ?></td>
                            <td><?php echo $student["roll"] ?></td>
                            <td><?php echo $student["age"] ?></td>
                            <td>
                                <a href="index.php?task=edit&id=<?php echo $student["id"] ?>">Edit</a> |
                                <a class="delete" href="index.php?task=delete&id=<?php echo $student["id"] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    } ?>

                </tbody>
            </table>
        <?php
        }
        ?>
    </section>
    <!-- Get All Students Data End  -->

    <!-- Add Student Form Start  -->
    <section class="container">
        <?php
        if ("add" == $task) {
        ?>
            <form action="index.php?task=report" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="enter name">
                <label for="age">Age</label>
                <input type="text" id="age" name="age" placeholder="enter age">
                <label for="roll">Roll</label>
                <input type="text" id="roll" name="roll" placeholder="enter roll">
                <input type="submit" value="Submit" name="submit">
            </form>
        <?php
        }
        ?>
    </section>
    <!-- Add Student Form End  -->

    <!-- Edit Student Form Start  -->
    <section class="container">
        <?php
        if ("edit" == $task) {
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

            $getStudentData = getStudent($id);
            if ($getStudentData) {
        ?>
                <form action="index.php?task=edit" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="enter name" value="<?php echo $getStudentData['name'] ?>">
                    <label for="age">Age</label>
                    <input type="text" id="age" name="age" placeholder="enter age" value="<?php echo $getStudentData['age'] ?>">
                    <label for="roll">Roll</label>
                    <input type="text" id="roll" name="roll" placeholder="enter roll" value="<?php echo $getStudentData['roll'] ?>" readonly>
                    <input type="submit" value="Update" name="submit">
                </form>
        <?php
            }
        }
        ?>
    </section>
    <!-- Edit Student Form End  -->

    <script src="assets/js/script.js"></script>
</body>

</html>