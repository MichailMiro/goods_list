<?php
/*
 * Составление строки URL с входящими параметрами
 * $parameters - парасетры которые необходимо добавить в исходную строку
 */
function addToUrl($parameters)
{
    /*
     * Адрес без параметров
     */
    $returnUrl = $_SERVER['REQUEST_URI'];
    $returnUrl = explode('?', $_SERVER['REQUEST_URI']);
    $returnUrl = $returnUrl[0];
    /*
     * Разбор GET параметров
     */
    if($_GET)
    {
        $getParameters = $_GET;
        foreach($getParameters as $name=>$param)
        {
            if(isset($parameters[$name]))
            {
                $getParameters[$name] = $parameters[$name];
                unset($parameters[$name]);    
            }
        }
        $parameters = array_merge($parameters,$getParameters);
    }
    
    
    
    /*
     *  Формирование URL
     */
    foreach($parameters as $name=>$param)
    {
        (strpos($returnUrl, '?') === false) ? $returnUrl .= "?" : $returnUrl .= "&";
        $returnUrl .= $name."="."$param";
    }
    return $returnUrl;
}

