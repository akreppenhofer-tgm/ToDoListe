<?php require_once 'pdo.php';
require_once 'ToDo.php';
require_once 'Fach.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shows Todos</title>
    <style>
        .tooLate {
            color: red;
        }
        .finnished {
            color: green;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
<h1>ToDo-Liste: Anzeigen</h1>
<hr>

<form method="post" action="updateTodos.php">
    <table>
        <tr>
            <th>Fach</th>
            <th>Bezeichnung</th>
            <th>zu machen bis</th>
            <th>gemacht</th>
        </tr>
        <tr>
            <td>$fach</td>
            <td>$todoBez</td>
            <td class="tooLate" name="deadLine_">$deadline</td>
            <td><input type="checkbox" name="gemacht_$fach+#+$bez" checked></td>
        </tr>
        <?php
            $list = new ToDoList();
            $list->setup("localhost","test","testuser","test1234");
            $todos = $list->getAllToDos();
            foreach ($todos as $todo) {
                echo '<tr>'
                . "<td>$todo->getFach()</td>"
                . "<td>$todo->getBezeichnung()</td>"
                . '<td class="';
                if ($todo->isOverdue()) echo 'tooLate';
                else if ($todo->isDone()) echo 'finnished';
                echo '">';
                echo "$todo->getDeadline()</td>".
                     "<td><input  type='checkbox'";
                if($todo->isDone()) echo 'checked';
                echo "></td></tr>";
            }
            ?>
    </table>

</form>
</body>
</html>
