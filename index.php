<?php
/*
 *Точка входа в приложение  
 */

/* 
 * Подключаем конфигурационный файл и файл модели
 * Файл конфигурации содержит основные константы (подключение к базе данных и т.д)
 * Файл модели содержит методы позваляющие манипулировать с данными в базе данных
 */
require_once('config.php');
require_once('model/model.php');

/*
 * Подключаем хэлперы - там будут содержаться все вспомогательные методы
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
 * Простая маршрутизация - определяется контролер
 * Если обращение к корню сайта то загружаем контролер по умолчанию
 * Если контролер не найдн то выбраcывается exeption
 */
$currentRoutes = explode('/', $_SERVER['REQUEST_URI']);
/*
 * Проверка на наличия GET в адресе
 */
$str = strpos($currentRoutes[2], "?");
if($str !== FALSE)
{
    $currentRoutes[2]=substr($currentRoutes[2], 0, $str);
}
if(!empty($currentRoutes[2]))
{
    /*
    * Фильтрация GET параметров
    */
    foreach($_GET as $name=>$param){
        $_GET[$name] = trim($_GET[$name]);
        $_GET[$name] = stripslashes($_GET[$name]);
        $_GET[$name] = htmlspecialchars($_GET[$name]);
    }
    /*
     * Подключение контролера
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
     * Контролер по умолчанию
     */
    require_once('controller/main.php');
}

