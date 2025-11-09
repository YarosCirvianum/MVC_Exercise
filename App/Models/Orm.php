<?php

namespace App\Models;

class Orm
{
    protected $model;

    // Constructor - initialize model in session
    public function __construct($model)
    {
        $this->model = $model;
        if (!isset($_SESSION[$this->model])) {
            $_SESSION[$this->model] = [];
        }
    }

    // Get item by ID
    public function getById($id)
    {
        foreach ($_SESSION[$this->model] as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    // Remove item by ID
    public function removeItemById($id) {
        foreach ($_SESSION[$this->model] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION[$this->model][$key]);
                break;
            }
        }
    }

    // Create new item
    public function create($item)
    {
        array_push($_SESSION[$this->model], $item);
    }

    // Get all items
    public function getAll()
    {
        return $_SESSION[$this->model];
    }

    // Update item by ID
    public function updateItemById($item) {
        foreach ($_SESSION[$this->model] as &$currentItem) {
            if ($currentItem['id'] == $item['id']) {
                $currentItem = $item;
            }
        }
    }

    // Reset model data
    public function reset() {
        $_SESSION[$this->model] = [];
    }

    // Check if session model exists
    public function sessionCreated()
    {
        if (isset($_SESSION[$this->model])) {
            return true;
        }
        return false;
    }

    // Get last ID for new item
    public function getLastId() {
        if (empty($_SESSION[$this->model])) {
            return 0;
        }

        $lastItem = end($_SESSION[$this->model]);
        return $lastItem['id'] + 1;
    }
}