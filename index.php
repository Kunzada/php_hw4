<!-- Задания
1. Создайте класс Todo, который будет описывать задачи
пользователя.
2. Создайте базу данных todo для разработки менеджера
по управлению задачами.
3. Создайте таблицу tasks, в которой будут храниться задачи
пользователя.
4. Создайте форму по добавлению задач в базу данных. После
отправки формы задачи добавляются в базу данных.
5. Создайте страницу, которая будет показывать все сохра-
нённые задачи на экране в виде списка.
6. Добавьте возможность изменять названия задач, отмечать
их как выполненные и удалять. При этом они также должны уда-
ляться из базы данных. -->
<?php
require "db_conn.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mes']) && $_GET['mes'] == 'error') { ?>
                    <input type="text"
                    name="title"
                    style="border-color:#ff6666"
                    placeholder="This field is required">
                    <input type="submit"
                    name="submit" 
                    value="Add Task ">

                <?php }else{?>
                    
                <input type="text"
                 name="title"
                placeholder="What do you need to do?">
                <input type="submit" name="submit" value="Add Task ">

                <?php }  ?>
            </form>
        </div>
        <?php
        $todos = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
        ?>
        <div class="show-todo-section">
            <?php if ($todos->rowCount() <= 0) { ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="https://ih1.redbubble.net/image.2969530737.7445/st,small,507x507-pad,600x600,f8f8f8.jpg" alt="" style="width: 90%;">
                    </div>
                </div>
            <?php } ?>
            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>
                    <?php if ($todo['checked']) { ?>
                        <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="check-box" checked />
                        <h2 class="checked"><?php echo $todo['title']; ?></h2>
                        </br>
                        <small>created: <?php echo $todo['date_time']; ?></small>
                    <?php } else { ?>
                        <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>"<?php echo $todo['id']; ?>" class="check-box" />
                        <h2><?php echo $todo['title']; ?></h2>
                        </br>
                        <small>created: <?php echo $todo['date_time']; ?></small>

                    <?php } ?>

                </div>
            <?php } ?>


        </div>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.remove-to-do').click(function(e) {
                    const id = $(this).attr('id');
                     e.preventDefault();
                    $.post('app/remove.php', {
                        id: id
                    }, (data) =>{
                        if (data){
                            $(this).parent().hide(600);
                        }
                        window.location.reload();
                    })
                })
                $('.check-box').click(function(e) {
                    const id = $(this).attr('data-todo-id');
                    $.post('app/check.php', {
                        id: id
                    }, (data) => {
                        if (data!='error') {
                            const h2=$(this).next();
                            if(data==="1"){
                                h2.removeClass('checked');
                            }else {
                                h2.addClass('checked');
                            }
                        }
                    });
                });
            });
        </script>


</body>

</html>