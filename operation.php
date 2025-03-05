<?php

$dbConnect = require_once("db.php");

initialize();

function initialize()
{
    global $dbConnect;
    $sql = "CREATE TABLE IF NOT EXISTS todos (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        task TEXT NOT NULL,
        due_date DATE NOT NULL,
        isCompleted BOOLEAN DEFAULT 0
    )";
    mysqli_query($dbConnect, $sql);
}

function getAllTodos()
{
    global $dbConnect;
    $sql = "SELECT * FROM todos WHERE isCompleted = 0 ORDER BY id DESC";
    return mysqli_query($dbConnect, $sql)->fetch_all(MYSQLI_ASSOC);
}

function addTodo($task, $date)
{
    global $dbConnect;
    $sql = "INSERT INTO todos (task, due_date) VALUES (?, ?)";
    $stmt = mysqli_prepare($dbConnect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $task, $date);
    return mysqli_stmt_execute($stmt);
}

function updateTodo($id, $task, $date)
{
    global $dbConnect;
    $sql = "UPDATE todos SET task = ?, due_date = ? WHERE id = ?";
    $stmt = mysqli_prepare($dbConnect, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $task, $date, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteTodo($id)
{
    global $dbConnect;
    $sql = "DELETE FROM todos WHERE id = ?";
    $stmt = mysqli_prepare($dbConnect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

function markCompleted($id)
{
    global $dbConnect;
    $sql = "UPDATE todos SET isCompleted = 1 WHERE id = ?";
    $stmt = mysqli_prepare($dbConnect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_execute($stmt);
}



if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            if (isset($_POST['task']) && isset($_POST['due_date']) && !empty($_POST['task']) && !empty($_POST['due_date'])) {
                addTodo($_POST['task'], $_POST['due_date']);
                header("Location: index.php");
                exit;
            }
            break;

        case 'delete':
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                deleteTodo($_GET['id']);
                header("Location: index.php");
                exit;
            }
            break;

        case 'edit':
            if (isset($_GET['id']) && isset($_POST['task']) && isset($_POST['due_date']) && !empty($_GET['id']) && !empty($_POST['task']) && !empty($_POST['due_date'])) {
                updateTodo($_GET['id'], $_POST['task'], $_POST['due_date']);
                header("Location: index.php");
                exit;
            }
            break;
        case 'marked':
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                markCompleted($_GET['id']);
                header("Location: index.php");
                exit;
            }
            break;
    }
}