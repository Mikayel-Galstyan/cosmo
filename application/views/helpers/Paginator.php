<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for generating HTML code for showing page numbers.
 *
 * @package application_core_views_helpers
 **/
class Zend_View_Helper_Paginator extends Zend_View_Helper_Abstract {

    /**
     * Generats HTML code for showing page numbers.
     * 
     * @param Filter_Grid $params
     * @param int $count
     */
    function paginator($params, $count) {
        $limit = $params->getLimit();
        if ($count > $limit){
            $page = $params->getPage();  
            $controllerName = strtolower(Zend_Controller_Front::getInstance()->getRequest()->getControllerName());              
            $pagination = ($page != 1)?'<span><a href=""onclick="Grid.page('.($page-1).'); return false"><<</a></span>':'';    
            if ($page > 10){                
                $pagination .= '<a href="" onclick="Grid.page(1); return false;">1</a>';
                $pagination .= '<span>...</span>';
            }
            $pageSpliter = ($page - 5 >= 1  ? $page - 4 : 1);
            for ($i = $pageSpliter; ($count + $limit) / ($i*$limit) > 1  && $i < $pageSpliter + 10; $i++) {
                $pagination .= '<a href="" onclick="Grid.page('.$i.'); return false;" class="'. ($page == $i ? "active":"") .'">'.$i.'</a>';
            }            
            $lastPage = floor(($count + $limit -1) / $limit);
            if ($page < $lastPage - 10){
                $pagination .= '<span>...</span>';                                    
                $pagination .= '<a href="" onclick="Grid.page('. $lastPage .'); return false;">'.$lastPage .'</a>';
            }
            $pagination .= ($page < ($count/$limit))?'<span><a href=""onclick="Grid.page('.($page+1).'); return false">>></a></span>':'';    
            echo '<div class="pagination">';            
            echo $pagination;                       
            echo '</div>';
        }                                        
    }  
}

?>
