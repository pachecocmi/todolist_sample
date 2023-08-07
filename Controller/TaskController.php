<?php
require_once __DIR__.'/../autoload.php';

class TaskController
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskModel();
    }

    // Function to post
    public function post($params)
    {
        var_dump($params);
    }

    // Function to get
    public function get($id = false)
    {
        var_dump($id);
    }

    // Function to put
    public function put($id, $params)
    {
        if (!$id) {
            throw new Exception("ID is required", 422);
        }
        var_dump($id, $params);
    }

    // Function to delete
    public function delete($id)
    {
        if (!$id) {
            throw new Exception("ID is required", 422);
        }
        
        var_dump($id);
    }
}