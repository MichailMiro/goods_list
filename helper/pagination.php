<?php
/*
 * Helper ��� ���������� ������������ ���������
 * $dbName - ��� ���� ������
 */
function showPagination($dbName)
{
    /*
     * ������� ��������
     */
    if(isset($_GET['page'])){
        $currentPage = $_GET['page'];
    }else{
        $currentPage = 1;
    }
    
    $conn = databaseConnect($dbName);
    $recordsCount = databaseGetCount($conn); // ����� ���������� �������
    $recordOnPage = LIMIT_ON_PAGE; // ������� �� ��������
    $maxPages = 10; // ���������� ������� ������� �� 

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
     * ����������� view
     */
    require('view/pagination.php');
    }
}
