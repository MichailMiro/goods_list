<?php
/*
 * ����������� ������ URL � ��������� �����������
 * $parameters - ��������� ������� ���������� �������� � �������� ������
 */
function addToUrl($parameters)
{
    /*
     * ����� ��� ����������
     */
    $returnUrl = $_SERVER['REQUEST_URI'];
    $returnUrl = explode('?', $_SERVER['REQUEST_URI']);
    $returnUrl = $returnUrl[0];
    /*
     * ������ GET ����������
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
     *  ������������ URL
     */
    foreach($parameters as $name=>$param)
    {
        (strpos($returnUrl, '?') === false) ? $returnUrl .= "?" : $returnUrl .= "&";
        $returnUrl .= $name."="."$param";
    }
    return $returnUrl;
}

