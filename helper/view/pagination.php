<ul class="pagination">
    <?php
    if($currentPage != 1)
    {
        echo '<li><a href ="'.addToUrl(array("page"=>1)).'" >Start</a></li>';
    }
    for ( $i = $firstPage; $i <= $lastPage; $i++ )
    {
        echo '<li '.(($i==$currentPage) ? 'class="active"' : '').'><a href ="'.addToUrl(array("page"=>$i)).'" >'.$i.'</a></li>';
    }
    
    if($currentPage != $countPages)
    {
        echo '<li><a href ="'.addToUrl(array("page"=>$countPages)).'" >End</a></li>';
    }
    ?>
</ul>