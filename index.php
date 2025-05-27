<!-- Import db connection -->
<?php 

require 'db_conn.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css?v=1.2">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
 
</head>
<body background="media/back.jpg">
    <div class="main">
    <h1>The Handwriting To-Do</h1>
    <br>
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
            <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error') { ?> <!-- empty string -->
                <input  type="text"
                        name="title"
                        style="border:solid #ff6666 "
                        placeholder="Add Task...">
                <button type="submit">Add  <span> <i class="fas fa-plus-circle"></i></span> </button>
            <?php } else { ?>
                <input  type="text"
                        name="title"
                        placeholder="Add Task...">
                <button type="submit">Add <span> <i class="fas fa-plus-circle"></i></span> </button>
            <?php } ?>
            </form>
        </div>
        <?php 
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC")
        ?>
        <div class="todo-section">
            <!-- Default no task -->
            <?php if($todos->rowCount() <= 0) { ?> 
                <div class="todo-item">
                    <div class="no-task">
                        <img src="media/waiting.gif" width="100%" height="225px">
                        <div class="loadingio-spinner-ellipsis-gtgt53yb28o"><div class="ldio-u93ue7y96km">
                        <div></div><div></div><div></div><div></div><div></div>
                        </div></div>
                        
                    </div>     
                </div>
            <?php } ?>

            <!-- Task added -->
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?> <!--every single row --->
                <div class="todo-item">
                    <span   id= "<?php echo $todo['id']; ?>"
                            class="remove">X
                    </span>
                    <!-- todo checked -->
                    <?php if($todo['checked']){?>
                        <input  type="checkbox"
                                class="check-box"
                                todo-id="<?php echo $todo['id']; ?>"
                                checked>
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php } else { ?>
                        <input  type="checkbox"
                                todo-id="<?php echo $todo['id']; ?>"
                                class="check-box">
                        <h2><?php echo $todo['title'] ?></h2>   
                    <?php } ?>
                    <br>
                    <small>created <?php echo $todo['date_time'] ?></small>      
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove').click(function(){
                const id = $(this).attr('id');

                $.post("app/remove.php",
                    {
                        id:id
                    },
                    (data) => {
                        if(data) {
                            $(this).parent().hide(400) // hide item
                        }
                    }  
                );
            });
            
            $(".check-box").click(function(e){
                const id = $(this).attr('todo-id'); //return index of item
                
                $.post('app/check.php',
                    {
                        id:id
                    },

                    (data) => {
                        if(data != 'error'){ //not empty
                            const h2 = $(this).next(); //return h2 after checkbox // to remove or add Class
                            if(data === '1'){ //not done
                                h2.removeClass('checked');
                            }else { //done
                                h2.addClass('checked');
                            }
                        }
                    }

                );
            });
        });
    </script>
</body>
</html>