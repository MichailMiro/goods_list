<?php
/*
 *����� ����� � ����������  
 */

/* 
 * ���������� ���������������� ���� � ���� ������
 * ���� ������������ �������� �������� ��������� (����������� � ���� ������ � �.�)
 * ���� ������ �������� ������ ����������� �������������� � ������� � ���� ������
 */
require_once('config.php');
require_once('model/model.php');

/*
 * ���������� ������� - ��� ����� ����������� ��� ��������������� ������
 */
if(($helperDir=@opendir('helper'))!==false)
{
    while(($helperFileName=readdir($helperDir))!==false)
    {
        if($helperFileName!='.' && $helperFileName!='..')
        {
            if(!is_dir('helper/'.$helperFileName))
            require_once('helper/'.$helperFileName);
        }
    }
    closedir($helperDir);
}

/*
 * ������� ������������� - ������������ ���������
 * ���� ��������� � ����� ����� �� ��������� ��������� �� ���������
 * ���� ��������� �� ����� �� �����c������� exeption
 */
$currentRoutes = explode('/', $_SERVER['REQUEST_URI']);
/*
 * �������� �� ������� GET � ������
 */
$str = strpos($currentRoutes[2], "?");
if($str !== FALSE)
{
    $currentRoutes[2]=substr($currentRoutes[2], 0, $str);
}
if(!empty($currentRoutes[2]))
{
    /*
    * ���������� GET ����������
    */
    foreach($_GET as $name=>$param){
        $_GET[$name] = trim($_GET[$name]);
        $_GET[$name] = stripslashes($_GET[$name]);
        $_GET[$name] = htmlspecialchars($_GET[$name]);
    }
    /*
     * ����������� ����������
     */
    try {    
        if (!file_exists('controller/'.$currentRoutes[2].'.php' ))
            throw new Exception ($currentRoutes[2].'.php does not exist');
        else
            require_once('controller/'.$currentRoutes[2].'.php' ); 
    }
    catch(Exception $e) {
        echo "Message : " . $e->getMessage();
        echo "Code : " . $e->getCode();
    }
}
else
{
    /*
     * ��������� �� ���������
     */
    require_once('controller/main.php');
}

