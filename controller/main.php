<?php 
$start = microtime(true);
/*
 * Количество записей на странице
 */
$limit = LIMIT_ON_PAGE;

/*
 * Смотрит номер текущей страницы и считает смещение
 */
$offset = 0;
if(isset($_GET['page']))
{
    $offset = ($_GET['page']-1)*$limit;
    $activePage = $_GET['page'];
}

/*
 * Выбираем данные из базы данных, если требуется отправляем сортировку
 */
$conn = databaseConnect(DB_NAME);
$sort = '';
if(isset($_GET['sort']))
{
    $sort = explode('_',$_GET['sort']);
}
$goods = databaseGetAll($conn,$limit,$offset,$sort);
databaseDisconnect($conn);

/*
 * Время работы скрипта
 */
$time = microtime(true) - $start;

require_once('view/main.php');