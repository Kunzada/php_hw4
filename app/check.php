<?php
if (isset($_POST['id'])) {
    require '../db_conn.php';
    $id = $_POST['id'];
    if (empty($id)) {
        echo "error";
    } else {
       
        $todos=$conn->prepare("Select id,checked from tasks where id=?");
       $todos->execute([$id]);
        $todo=$todos->fetch();
        $uId=$todo['id'];
        $checked=$todo['checked'];
        $uChecked=$checked?0:1;
        $res=$conn->query('UPDATE tasks SET checked ='.$uChecked.' WHERE id ='.$uId);
        if($res){   
            echo $checked;
        }
        else{
            echo "error";
        }

        $conn = null;
        exit();
    }
} else {
    header('Location: ../index.php?mes=success');
}
