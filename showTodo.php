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
<form method="post" action="showTodo.php">
    <label for="sub">Nach Fächern filtern: </label>
    <br>
    <br>
    <select id="sub" name="subjects" multiple="multiple">
        <option value="$fachKuerzel">$fachBezeichnung</option>
        <?php

        ?>
    </select>
</form>
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
            <td class="tooLate">$deadline</td>
            <td><input type="checkbox" name="$fach+#+$bez" checked></td>
        </tr>
    </table>

</form>
</body>
</html>
