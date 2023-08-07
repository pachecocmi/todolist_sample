<?php

class TaskModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Create a new task
    public function createTask($title, $description)
    {
        $sql = "INSERT INTO tasks (title, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $title, $description);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    // Get all tasks
    public function getAllTasks()
    {
        $sql = "SELECT * FROM tasks";
        $result = $this->conn->query($sql);
        $tasks = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        }

        return $tasks;
    }

    // Get a specific task by ID
    public function getTaskById($task_id)
    {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Update a task
    public function updateTask($task_id, $title, $description)
    {
        $sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $description, $task_id);

        return $stmt->execute();
    }

    // Delete a task
    public function deleteTask($task_id)
    {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $task_id);

        return $stmt->execute();
    }
}