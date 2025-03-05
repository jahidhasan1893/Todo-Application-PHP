<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Todo List Application</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="operation.php?action=add" method="POST" class="mb-4">
                    <div class="input-group mb-3">
                        <input type="text" name="task" class="form-control" placeholder="Enter your task" required>
                        <input type="date" name="due_date" class="form-control" style="width: 150px; flex: 0 0 auto;"
                            required>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">My Tasks</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        include 'operation.php';
                        $todos = getAllTodos();
                        foreach ($todos as $todo): 
                            if ($todo['isCompleted'] == 0):
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="todo-<?php echo $todo['id']; ?>" <?php echo $todo['isCompleted'] == 1 ? 'checked' : ''; ?> onchange="window.location.href='operation.php?action=marked&id=<?php echo $todo['id']; ?>'">
                                    <label class="form-check-label"
                                        for="todo-<?php echo $todo['id']; ?>"><?php echo htmlspecialchars($todo['task']); ?></label>
                                    <small class="text-muted ms-2">Due:
                                        <?php echo htmlspecialchars($todo['due_date']); ?></small>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $todo['id']; ?>">Edit</button>
                                    <a href="operation.php?action=delete&id=<?php echo $todo['id']; ?>"
                                        class="btn btn-sm btn-danger">Delete</a>
                                </div>
                            </li>

                            <div class="modal fade" id="editModal<?php echo $todo['id']; ?>" tabindex="-1"
                                aria-labelledby="editModalLabel<?php echo $todo['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo $todo['id']; ?>">Edit Task
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="operation.php?action=edit&id=<?php echo $todo['id']; ?>"
                                            method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="task" class="form-label">Task</label>
                                                    <input type="text" class="form-control" name="task"
                                                        value="<?php echo htmlspecialchars($todo['task']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="due_date" class="form-label">Due Date</label>
                                                    <input type="date" class="form-control" name="due_date"
                                                        value="<?php echo htmlspecialchars($todo['due_date']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>