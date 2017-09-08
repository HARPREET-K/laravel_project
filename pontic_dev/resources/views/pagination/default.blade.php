<?php
$linkCount = 3;
 $pageCount = $paginator->lastPage();

if ($pageCount > 1)
{
    $currentPage = $paginator->currentPage();
    $pagesEitherWay = floor($linkCount / 2);
    $paginationHtml = '<ul class="pagination">';

    // Previous item
    $previousDisabled = $currentPage == 1 ? 'disabled' : '';
    $paginationHtml .= '<li class="page-item '.$previousDisabled.'">
                            <a class="page-link" href="'.$paginator->url($currentPage - 1).'" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> 
								 </a>
                        </li>';

    // Set the first and last pages
    $startPage = ($currentPage - $pagesEitherWay) < 1 ? 1 : $currentPage - $pagesEitherWay;
    $endPage = ($currentPage + $pagesEitherWay) > $pageCount ? $pageCount : ($currentPage + $pagesEitherWay);

    // Alter if the start is too close to the end of the list
    if ($startPage > $pageCount - $linkCount)
    {
        $startPage = ($pageCount - $linkCount) + 1;
        $endPage = $pageCount;
    }

    // Alter if the end is too close to the start of the list
    if ($endPage <= $linkCount)
    {
        $startPage = 1;
        $endPage = $linkCount < $pageCount ? $linkCount : $pageCount;
    }

    // Loop through and collect
    for ($i = $startPage; $i <= $endPage; $i++)
    {
        $disabledClass = $i == $currentPage ? 'disabled' : '';
        $paginationHtml .= '<li class="page-item '.$disabledClass.'">
                                <a class="page-link" href="'.$paginator->url($i).'">'.$i.'</a>
                            </li>';
    }

    // Next item
    $nextDisabled = $currentPage == $pageCount ? 'disabled' : '';
    
    $paginationHtml .= '<li class="page-item '.$nextDisabled.'">';
    
     if($currentPage == $pageCount){
        
    $paginationHtml .= '<a class="page-link"  aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                 
                            </a>';
     }else{
         $paginationHtml .= '<a class="page-link" href="'.$paginator->url($currentPage + 1).'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                 
                            </a>';
     }
  
    $paginationHtml .= '</li>';
    
    $paginationHtml .= '</ul>';

    echo $paginationHtml;
}

?>