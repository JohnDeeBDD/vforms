<?php

namespace VForms;

class ColumnsFeature{

    public function set_custom_edit_vform_columns($columns){
        unset($columns['categories']);
        unset($columns['tags']);
        $columns['shortcode'] = __('Short Code', 'vform');
        return $columns;
    }

    public function custom_vform_column($column, $post_id){
        switch ($column) {
            /*
            case 'vform_author' :
                $terms = get_the_term_list($post_id, 'vform_author', '', ',', '');
                if (is_string($terms))
                    echo $terms;
                else
                    _e('Unable to get author(s)', 'vform');
                break;
            */
            case 'shortcode' :
                echo ("[vform id=" . $post_id . "]");
                break;
        }
    }

    public function renderJQueryForEditScreen(){

        $output = <<<OUTPUT
<script>
jQuery( document ).ready(function() {
    jQuery("span").filter(function() { return (jQuery(this).text() === 'Title') }).text("VForm Rec ID"); 
    jQuery(".column-author").text("Creator");
    
});
</script>
OUTPUT;
        echo $output;
    }

    public function doModifyVDataEditPostLinks($link, $post_id ) {
        global $skipNextOne;
        if ($skipNextOne == TRUE){
            $skipNextOne = FALSE;
            return $link;
        }else{
            $vFormPostID = get_post_meta( $post_id, 'vform-post-id', true );
            $vDataTitle = get_the_title( $post_id);
            $url = get_permalink($vFormPostID);
            $url = $url . "?vform-rec-id=" . $vDataTitle;
            $skipNextOne = TRUE;
            return $url;// ? add_query_arg( 'post', $post_id, $url ) : $link;
        }
    }

    public function doRemoveQuickEditLink( $actions, $post ) {
        //this function should be called from the 'post_row_actions' filter
        unset($actions['inline hide-if-no-js']);
        return $actions;
    }
}