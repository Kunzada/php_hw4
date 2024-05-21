<?php
if (isset($_POST['title'])) {
    require '../db_conn.php';
    $title = $_POST['title'];
    if (empty($title)) {
        header('Location: ../index.php?mes=error');
    } else {
        $stmt = $conn->prepare("INSERT INTO tasks(title) VALUES(?)");
        $res = $stmt->execute([$title]);
        if ($res) {
            header('Location: ../index.php?mes=success');
        } else {
            header('Location: ../index.php');
        }
        $conn = null;
        exit();
    }
} else {
    header('Location: ../index.php?mes=success');
}
