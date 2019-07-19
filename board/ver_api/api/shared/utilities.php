<?php
class Utilities{

    const ALLOWED_EXT = array('jpg','jpeg','png','gif');

    public function getPaging($page, $total_rows, $records_per_page, $page_url){
        
        // paging array
        $paging_arr = array();

        // button for first page
        $paging_arr["first"] = $page > 1 ? "{$page_url}page=1" : "";

        // count all topics in the database to calculate total pages
        $total_pages = ceil($total_rows / $records_per_page);

        // range of links to show
        $range = 2;

        // display links to 'range of pages' around 'current page'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range) + 1;

        $paging_arr['pages'] = array();
        $page_count = 0;

        for($x = $initial_num; $x < $condition_limit_num; $x++ ){
            // be sure '$x is greater than 0 'AND' less or equal to the $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"] = $x;
                $paging_arr['pages'][$page_count]["url"] = "{$page_url}page = {$x}";
                $paging_arr['pages'][$page_count]["current_page"] = ($x == $page) ? "yes" : "no";

                $page_count++;
            }
        }

        // button for last page
        $paging_arr["last"] = ($page < $total_pages) ? "{$page_url}page={$total_pages}" : "";
        
        // json foramt
        return $paging_arr;
    }

    public function imageFileCheck($image_file, $ext){

        $error = $image_file['error'];
        $result["bool"] = true;

        if( $error != UPLOAD_ERR_OK ) {
            switch( $error ) {
                case UPLOAD_ERR_INI_SIZE:

                case UPLOAD_ERR_FORM_SIZE:
                    $result["message"] = "파일이 너무 큽니다. ($error)";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $result["message"] = "파일이 첨부되지 않았습니다. ($error)";
                    break;
                default:
                    $result["message"] = "파일이 제대로 업로드되지 않았습니다. ($error)";
            }
        } 
        if ( !in_array($ext, $this::ALLOWED_EXT) ) {
            $result["message"] = "허용되지 않는 확장자입니다.";            
        }
        
        if(count($result) == 2){
            $result["bool"] = false;
        }

        return $result;
    }
}
?>
