<?php
class Task implements JsonSerializable {
    private int $taskId;
    private string $title;
    private string $description;
    private bool $isCompleted;
    private string $deadLine;

    public function __construct(int $taskId, string $title, string $description, string $deadLine) {
        $this->taskId = $taskId;
        $this->title = $title;
        $this->description = $description;
        $this->isCompleted = false;
        $this->deadLine = $deadLine;
    }

    public function getTaskId(): int {
        return $this->taskId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getIsCompleted(): bool {
        return $this->isCompleted;
    }

    public function getDeadLine(): string {
        return $this->deadLine;
    }

    public function setTaskId(int $taskId): void {
        $this->taskId = $taskId;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setIsCompleted(string $isCompleted): void {
        $this->isCompleted = $isCompleted;
    }

    public function setDeadLine(string $deadLine): void {
        $this->deadLine = $deadLine;
    }

    public function jsonSerialize(): mixed {
        return [
            "taskId" => $this->taskId,
            "title" => $this->title,
            "description" => $this->description,
            "completed" => $this->isCompleted,
            "deadLine" => $this->deadLine
        ];
    }
}

?>