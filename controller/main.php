<?php 
$start = microtime(true);
/*
 * ���������� ������� �� ��������
 */
$limit = LIMIT_ON_PAGE;

/*
 * ������� ����� ������� �������� � ������� ��������
 */
$offset = 0;
if(isset($_GET['page']))
{
    $offset = ($_GET['page']-1)*$limit;
    $activePage = $_GET['page'];
}

/*
 * �������� ������ �� ���� ������, ���� ��������� ���������� ����������
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
 * ����� ������ �������
 */
$time = microtime(true) - $start;

require_once('view/main.php');