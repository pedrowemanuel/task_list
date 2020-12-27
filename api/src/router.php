<?php
    include_once 'controllers/ControllerTasks.php';
    include_once 'models/Tasks.php';
    $controllerTask = new ControllerTasks();

    // Tasks
    
    if (isset($_GET['indexTask'])) $controllerTask->index();
    if (isset($_GET['showTask'])) $controllerTask->show($_GET);
    if (isset($_POST['storeTask'])) $controllerTask->store($_POST); 
    if (isset($_POST['updateTask'])) $controllerTask->update($_POST); 
    if (isset($_POST['deleteTask'])) $controllerTask->destroy($_POST);

        
    