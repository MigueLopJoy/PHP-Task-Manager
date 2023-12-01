<?php 
    function renderProgramLayer() {
        renderTaskCreationForm();
        renderUserTasks();
    }

    function renderTaskCreationForm() {
        echo 
        '
                <div class="box form-box">
                    <form class="form task-form" action="?task=create-task" method="POST">
                        <label for="title">Task Title:</label>
                        <input type="text" id="title" name="title" required>

                        <label for="description">Task Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>

                        <label for="deadline">Task Deadline:</label>
                        <input type="date" id="deadline" name="deadline" required>

                        <input type="submit" value="Create Task">
                    </form>
                    <div class="logout-icon">
                        <a href="?logout"><span class="material-symbols-outlined">logout</span></a>
                    </div>
                </div>
        ';
    }

    function renderUserTasks() {
        echo '<div class="box tasks-box">';
            
        $userTasks = $_SESSION['logged-user']->getTasks();

        foreach ($userTasks as $userTask) {
            echo getNewTaskTemplate($userTask);
        }
        echo '</div>';
    }

    function createNewTask() {
        $newTask = getNewTask($_POST);
        $_SESSION['logged-user']->addNewTask($newTask);
        storeNewTask($newTask);
        reloadPage();
    }

    function storeNewTask($newTask) {
        $savedUsers = getSavedUsers();
        $loggedUserData = findLoggedUser($savedUsers);    
        $loggedUserData['tasks'][] = $newTask;
    
        foreach ($savedUsers as &$user) { 
            if ($user['userId'] === $loggedUserData['userId']) {
                $user = $loggedUserData;
                break;
            }
        }
        $updatedUsersJSON = json_encode($savedUsers, JSON_PRETTY_PRINT);
        file_put_contents("./ASSETS/JSON/users.json", $updatedUsersJSON);
    }


    function deleteTask() {
        $taskId = intval($_GET['id']);
        $loggedUser = $_SESSION['logged-user'];
        $loggedUser->deleteTask($taskId);   
        $savedUsers = getSavedUsers();
        $loggedUserData = findLoggedUser($savedUsers);        
        foreach ($loggedUserData['tasks'] as $key => &$task) {
            if ($task['taskId'] == $taskId) {
                unset($loggedUserData['tasks'][$key]);
                $loggedUserData['tasks'] = array_values($loggedUserData['tasks']);
                foreach ($savedUsers as $key => &$savedUser) {
                    if ($savedUser['userId'] == $loggedUser->getUserId()) {
                        $savedUsers[$key] = $loggedUserData;
                        $updatedUsersJSON = json_encode($savedUsers, JSON_PRETTY_PRINT);
                        file_put_contents("./ASSETS/JSON/users.json", $updatedUsersJSON);
                        header("Location: ?");
                        exit();                    
                    }   
                }
            }
        }    
    }

    function getSavedUsers() {
        $usersFile = "./ASSETS/JSON/users.json";
        $savedUsersData = file_get_contents($usersFile);
        $savedUsers = json_decode($savedUsersData, true);
        return $savedUsers;
    }

    function reloadPage() {
        header("Location: ?");
        exit(); 
    }
    
    function getNewTask($newTaskData) {
        return new Task(
            count($_SESSION['logged-user']->getTasks()) + 1,
            $newTaskData['title'],
            $newTaskData['description'],
            $newTaskData[ 'deadline']
        );
    }

    function findLoggedUser($savedUsers) {
        $loggedUser = $_SESSION['logged-user'];
        foreach ($savedUsers as $savedUser) {
            if ($savedUser['userId'] == $loggedUser->getUserId()) {
                return $savedUser;
            }
        }
    }

    function getNewTaskTemplate($task) {
        return
        '
        <div class="card-container">
            <div class="box task-box">
                <div class="task-title">
                    <h3>'.$task->getTitle().'</h3>
                </div>
                <div class="task-description">
                    <label><b>Description:</b></label>
                    <p>'.$task->getDescription().'</p>
                </div>
                <div class="task-deadline">
                    <label><b>Deadline:</b></label>
                    <p>'.$task->getDeadLine().'</p>
                </div>
                <div class="task-icons">
                    <a href="?task=delete-task&id='.$task->getTaskId().'"><span class="material-symbols-outlined">delete</span></a>
                </div>
            </div>
        </div>
        ';
    }
?>