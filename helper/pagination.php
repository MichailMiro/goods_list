<?php
/*
 * Helper для постраения постраничной навигации
 * $dbName - имя базы данных
 */
function showPagination($dbName)
{
    /*
     * Текущая страница
     */
    if(isset($_GET['page'])){
        $currentPage = $_GET['page'];
    }else{
        $currentPage = 1;
    }
    
    $conn = databaseConnect($dbName);
    $recordsCount = databaseGetCount($conn); // общее количество записей
    $recordOnPage = LIMIT_ON_PAGE; // записей на странице
    $maxPages = 10; // количество номеров страниц на 

    $countPages = ceil($recordsCount / $recordOnPage);

    if($currentPage <= $countPages)
    {
        
    $firstPage = $currentPage - (int) ($maxPages / 2);
    
    if ( $firstPage <= 1 )
    {
        $firstPage = 1;
    }    
    else 
    {
        if ( $countPages - $firstPage < $maxPages ){
            $firstPage = $countPages - $maxPages + 1;
            if ( $firstPage <= 1 )
            {
                $firstPage = 1;
            }    
        }
    }
    $lastPage = $firstPage + $maxPages - 1;
    
    if ( $lastPage > $countPages )
    {
        $lastPage = $countPages;
    }    

    /*
     * Подключение view
     */
    require('view/pagination.php');
    }
}
