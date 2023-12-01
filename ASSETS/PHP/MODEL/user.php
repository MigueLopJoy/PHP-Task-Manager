<?php

class User implements JsonSerializable {
    private int $userId;
    private string $firstName;
    private string $surName;
    private string $email;
    private string $password;
    private array $tasks;

    public function __construct(
            int $userId, 
            string $firstName, 
            string $surName, 
            string $email, 
            string $password, 
            array $tasks = array()
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->surName = $surName;
        $this->email = $email;
        $this->password = $password;
        $this->tasks = $tasks;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getSurName(): string {
        return $this->surName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getTasks(): array {
        return $this->tasks;
    }

    public function setUserId(string $userId): void {
        $this->userId = $userId;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setSurName(string $surName): void {
        $this->surName = $surName;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function addNewTask(Task $task) :void {
        $this->tasks[] = $task;
    }

    public function deleteTask(int $taskId): void {
        foreach ($this->tasks as $key => $task) {
            if ($task->getTaskId() == $taskId) {
                unset($this->tasks[$key]);
                $this->tasks = array_values($this->tasks);
                break;
            } 
        }
    }

    public function jsonSerialize(): mixed {
        return [
            "userId" => $this->userId,
            "firstName" => $this->firstName,
            "surName" => $this->surName,
            "email" => $this->email,         
            "password" => $this->password,
            "tasks" => $this->tasks
        ];
    }
}

?>
