<?php
    function renderAuthenticationLayer() {
        echo 
        '
        <div class="box authentication-box">
            <div class="authentication-menu">
                <a href="?login"><button class="tab">Login</button></a>
                <a href="?register"><button class="tab">Register</button></a>
            </div>
        ';
        if (isset($_GET['register'])) {
            renderRegisterForm();
        } else {
            renderLoginForm();
        }
        echo "</div>";
    }

    function renderLoginForm() {
        echo 
        '
        <div id="login" class="tab-content">
            <h2>Login</h2>
        ';

            if (isset($_GET['registration_success']) && $_GET['registration_success'] === 'true') {
                echo '<p style="color: green;">User registered successfully. Please, login.</p>';
            }
            echo '<form method="POST" id="login-form">';

                if (isset($_GET['error']) && $_GET['error'] === 'unknown-email') {
                    echo '<p style="color: red;">Unknown email</p>';
                }
                
                echo '<input type="text" name="email" placeholder="Email" required>';

                
                if (isset($_GET['error']) && $_GET['error'] === 'wrong-password') {
                    echo '<p style="color: red;">Wrong password</p>';
                }

        echo 
        '
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="login" value="SUBMIT">
            </form>
        </div>
        ';
    }

    function renderRegisterForm() {
        echo
        '
        <div id="register" class="tab-content register-form">
            <h2>Register</h2>
            <form method="POST" id="register-form">
                <input type="text" name="firstName" placeholder="Firstname" required>
                <input type="text" name="surName" placeholder="Surname" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="register" value="REGISTER">
            </form>
        </div>
        ';
    }

    function authenticateUser() {
        $usersFile = "./ASSETS/JSON/users.json";
        $savedUsersData = file_get_contents($usersFile);
        $savedUsers = json_decode($savedUsersData, true);
    
        $email = $_POST['email'];
        $password = $_POST['password'];

        $validationResult = validateUserData($savedUsers, $email, $password);

        if ($validationResult == "success") {
            header("Location: ?");
            exit();
        } else {
            header("Location: ?error=".$validationResult);
            exit();
        }   
    }

    function validateUserData($savedUsers, $email, $password): string {
        $validationResult = "";
        foreach ($savedUsers as $user) {
            if ($user['email'] == $email) {
                if ($user['password'] == $password) {                    
                    $_SESSION['logged-user'] = getNewUser($user);
                    $validationResult = "success";   
                    break;
                } else {
                    $validationResult = "wrong-password";
                }
            } else {
                $validationResult = "unknown-email";
            }
        }    
        return $validationResult;
    }

    function getNewUser($userData): User {
        return new User(
            $userData['userId'],
            $userData['firstName'],
            $userData['surName'],
            $userData['email'],
            $userData['password'],
            getUserTasks($userData['tasks'])
        );
    } 

    function getUserTasks($tasksList): array {
        $userTasks = [];
        foreach ($tasksList as $task) {
            $userTask = new Task(
                (count($userTasks) + 1),
                $task['title'],
                $task['description'],
                $task['deadLine']
            );
            $userTasks[] = $userTask;
        }
        return $userTasks;
    }

    function registerUser() {
        $usersFile = "./ASSETS/JSON/users.json";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newUser = new User(
                    getNewUserId(),
                    $_POST['firstName'],
                    $_POST['surName'],
                    $_POST['email'],
                    $_POST['password'] 
            );
        }
        $savedUsersData = file_get_contents($usersFile);
        $savedUsers = json_decode($savedUsersData, true);
        $savedUsers[] = $newUser;
        $updatedUsersJSON = json_encode($savedUsers, JSON_PRETTY_PRINT);
        file_put_contents($usersFile, $updatedUsersJSON);
        header("Location: ?registration_success=true");
        exit();
    }

    function getNewUserId(): int {
        $usersJSON = file_get_contents("./ASSETS/JSON/users.json");
        $usersDATA = json_decode($usersJSON, true);
        $users = $usersDATA;
        return count($users) + 1;
    }
?>