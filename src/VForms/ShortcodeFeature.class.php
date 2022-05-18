<?php

namespace VForms;

class ShortcodeFeature{

    public function renderShortcode($args){
        $content = "<script src='/wp-content/plugins/vforms/src/VForms/form-render.min.js' id='formRender'></script>";
        $content_post = get_post($args['id']);
        $json = $content_post->post_content;
        $content = $content . <<<OUTPUT
<form method = 'post' id = "vform-form"><div id = "fb-template" class = "fb-render"></div></form>
<script>
console.log('ShortcodeFeatureClass.php');
jQuery(function($) {
  $('.fb-render').formRender({
    dataType: 'json',
    formData: $json
  });
    $('#vform-form').submit(function(){
       //alert($('#vform-rec-id').val());
         var vFormAction = '/?vform-rec-id=' + ($('#vform-rec-id').val());
          $('#vform-form').attr('action', vFormAction);
    });
});
</script>
OUTPUT;


        if(isset($_GET['vform-rec-id'])){
            $mypost = get_page_by_title($_GET['vform-rec-id'], OBJECT, 'vdata');
            $vDataPostID = $mypost->ID;
            $JS = ShortcodeFeature::getJQuery($vDataPostID);
            $content = $content . $JS;
        }

        return $content;
    }

    public function getJQuery($ID){
        $meta = get_post_meta( $ID );
        $keys = array_keys($meta);
        $js = "<script>
            jQuery( document ).ready(function() {
            console.log( 'getJQuery ready!' );
            ";

        foreach ($keys as $key){
            $js = $js . "jQuery(\"[name='$key']\").val('" . $meta[$key][0] . "');";
            $js = $js . "console.log('" .$key . " " . $meta[$key][0] . "');";
        }

        $js = $js . "
         //   jQuery('#vform-form').submit(function(){
         //       alert(jQuery('#vform-rec-id').val());
         //      var vFormAction = '/?vform-rec-id=' + (jQuery('#vform-rec-id').val());
         //       jQuery('#vform-form').attr('action', vFormAction);
         //   });
});
                    </script>";


        return ($js);
    }
}