<?php
include ("vendor/autoload.php");
use App\Todo;
$todo = new Todo();
if (isset($_POST['todo']))
{
    $data = $_POST['todo'];
    $test = $todo->insertData($data, 'todos');
}
if (isset($_POST['edit_todo']))
{
    $data = $_POST['edit_todo'];
    $id = $_POST['edit_id'];
    $test = $todo->updateData($id, $data, 'todos');
}
if (isset($_POST['id']))
{
    $data = $_POST['id'];
    $test = $todo->completeData($data, 'todos');
}
if (isset($_POST['clear']))
{
    $test = $todo->clearCompleteData('todos');
}
if (isset($_GET['complete'])){
    $complete_menu = "router-link-exact-active";
    $datas = $todo->getByStatus('1','todos');
    $row = $todo->rowCount('todos');
}
elseif (isset($_GET['active'])){
    $active_menu = "router-link-exact-active";
    $datas = $todo->getByStatus('0','todos');
    $row = $todo->rowCount('todos');
}else{
    $all_menu = "router-link-exact-active";
    $datas = $todo->showData('todos');
    $row = $todo->rowCount('todos');
}

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Todo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3b4174c44f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<div class="content">
    <div id="app">
        <div><h1 class="main-heading">todos</h1>
            <div>
                <div>
                    <form action="" method="post" name="todo_add" id="add">
                        <input type="text" name="todo" placeholder="What needs to be done?">
                    </form>
                </div>
                <div class="list">
                    <?php
                    if (!empty($datas) || isset($datas['todos'])) {
                        foreach ($datas as $data) {
                            if ($data['status'] == 0) {
                                ?>
                                <div class="checkbox">
                                    <form action="" method="post" name="todo_complete" id="todo_complete_<?php echo @$data['id'];?>">
                                        <input type="checkbox" value="<?php echo @$data['id']; ?>" name="id"
                                               onclick="completeFunction(this.value)">
                                        <label id="<?php echo @$data['id'];?>" onclick="editData(this.id)">
                                            <?php echo @$data['todos']; ?>
                                        </label>
                                        <a href="#">
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                    <form action="" method="post"class="edit_data" name="todo_edit_form" id="todo_edit_form_<?php echo @$data['id'];?>" style="display: none">
                                        <input type="text"  value="<?php echo @$data['todos']; ?>" name="edit_todo" id="edit_data_<?php echo @$data['id'];?>"/>
                                        <input type="hidden" value="<?php echo @$data['id']; ?>" name="edit_id">
                                    </form>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="checkbox">
                                    <input type="checkbox" checked disabled>
                                    <label value="2" class="">
                                        <del><?php echo @$data['todos']; ?></del>
                                    </label>
                                    <a href="#">
                                        <i class="fas fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <ul>
                        <li><?php echo @$row?> items left</li>
                        <div class="links">
                            <li ><a href="index.php" class="<?php echo @$all_menu;?> router-link-active">All</a>
                            </li>
                            <li>
                                <a href="index.php?active" class="<?php echo @$active_menu;?> router-link-active">Active</a>
                            </li>
                            <li><a href="index.php?complete" class="<?php echo @$complete_menu;?> router-link-active">Completed</a></li>
                        </div>
                        <li >
                            <a href="#" onclick="clearComplete()">Clear Completed</a>
                            <form action="" method="post" name="clear" id="clear">
                                <input type="hidden" name="clear">
                            </form>
                        </li>
                    </ul>
                    <div class="first"></div>
                    <div class="second"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.input').keypress(function (e) {
        if (e.which == 13) {
            $('form#add').submit();
            return false;
        }
    });

    function completeFunction(id)
    {
        var form = "form#todo_complete_"+id;
        $(form).submit();
        return false;
    }
    function clearComplete()
    {
        $("form#clear").submit();
        return false;
    }
    function editData(id)
    {
        var checkbox_form = "todo_complete_"+id;
        var edit_text = "edit_data_"+id;
        var edit_form = "todo_edit_form_"+id;
        document.getElementById(checkbox_form).style.display = "none";
        document.getElementById(edit_form).style.display = "block";
        document.getElementById(edit_text).style.display = "block";
    }

    $('.edit_data').keypress(function (e) {
        var id = 'form#'+$(this).attr('id');
        if (e.which == 13) {
            $(id).submit();
            return false;
        }
    });
</script>

</body>
</html>
