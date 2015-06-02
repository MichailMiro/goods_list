<?php
/*
 * Сохранение записи в базу данных
 */
$conn = databaseConnect(DB_NAME);
$data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'url' => $_POST['url']
        ];
databaseSave($conn,$data);
databaseDisconnect($conn);
   
header("Location: ".$_SERVER['HTTP_REFERER']);
die();