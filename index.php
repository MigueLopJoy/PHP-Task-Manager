<?php
    include "./ASSETS/PHP/MODEL/user.php";
    include "./ASSETS/PHP/MODEL/task.php";
    include "./ASSETS/PHP/authentication.php";
    include "./ASSETS/PHP/tasks-handler.php";

    include "./ASSETS/PHP/INTERFACES/header.php";

    session_start();

    if (!isset($_SESSION['logged-user'])) {
        renderAuthenticationLayer();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['register'])) {
                registerUser();
            } else if (isset($_POST['login'])) {
                authenticateUser();
            }
        }    
    } else {
        if (isset($_GET['task']) && $_GET['task'] == "create-task") {
            createNewTask();
        }

        if (isset($_GET['task']) && $_GET['task'] == "delete-task") {
            deleteTask();
        }

        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: ?");
            exit();
        }

        renderProgramLayer();
    }

    include "./ASSETS/PHP/INTERFACES/footer.php";

?>  