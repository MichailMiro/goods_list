<?php
/*
 * Удаление записи из базы данных
 */
if(isset($_GET['id'])){
    $conn = databaseConnect(DB_NAME);
    databaseDelete($conn,$_GET['id']);
    databaseDisconnect($conn);
}

header("Location: ".$_SERVER['HTTP_REFERER']);
die();