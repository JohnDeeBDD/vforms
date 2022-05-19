<?php

namespace VForms;

class ShortcodeFeature{

    public function renderShortcode($args){

        $content = "<script src='/wp-content/plugins/vforms/src/VForms/form-render.min.js' id='formRender'></script>";
        $content_post = get_post($args['id']);
        $json = $content_post->post_content;
        $hiddenFieldTag = "<input type = 'hidden' name = 'vform-post-id' value = '" . get_the_ID() . "' />";
        $content = $content . <<<OUTPUT
<form method = 'post' id = "vform-form"><div id = "fb-template" class = "fb-render"></div>
$hiddenFieldTag
</form>
<script>
console.log('ShortcodeFeatureClass.php');
jQuery(function($) {
  $('.fb-render').formRender({
    dataType: 'json',
    formData: $json
  });
    $('#vform-form').submit(function(){
          var url = window.location.href.split('?')[0];
          url = url + '?vform-rec-id=' + $('#vform-rec-id').val();
          $('#vform-form').attr('action', url);          
    });
   VFormDataFiller.doFill(); 
});
</script>
OUTPUT;

        return $content;
    }

    public function getJQuery($ID){
        $meta = get_post_meta( $ID );
        $keys = array_keys($meta);
        $js = /** @lang js */
            <<<TAG
<script>
            jQuery( document ).ready(function() {
            console.log( 'getJQuery ready!' );
TAG;

        foreach ($keys as $key){
            $md = $meta[$key][0];
            if(is_array($md)){
                $md = $md[0];
            }
            $output = <<<OUTPUT
var vFormsInputName = '$key';
console.log("input name: " + vFormsInputName);
console.log("data:");

/*
vFormsInputName = "#" + vFormsInputName;
var inputType =  jQuery(vFormsInputName).prop('type');
if(inputType === undefined){
    vFormsInputName = "input[name='$key";
    vFormsInputName = vFormsInputName + "[]'" + "]";
    console.log(vFormsInputName);
    inputType =  jQuery(vFormsInputName).prop('type');
}
console.log("type: " + inputType);
if(inputType === "checkbox"){
    console.log('data...');

}
*/

OUTPUT;
            $js = $js . $output;

            $js = $js . "jQuery(\"[name='$key']\").val('" . $meta[$key][0] . "');";
           // $js = $js . "console.log('" .$key . " " . $meta[$key][0] . "');";
        }

        $js = /** @lang JavaScript */
            $js . <<<OUTPUT
            //alert("hello line 63");
           //jQuery('#vform-form').submit(function(){
             // alert(jQuery('#vform-rec-id').val());
              //var vFormAction = '?vform-rec-id=' + (jQuery('#vform-rec-id').val());
              //jQuery('#vform-form').attr('action', vFormAction);
           //   var myVal = jQuery('#vform-rec-id').val();
            //  jQuery('#vform-form').attr('action', function(i, value) {
            //    return value + '&vform-recss-id=' + myVal;
            //  });
          // });
});
                    </script>
OUTPUT;


        return ($js);
    }

    public function doEnqueuFrontendScripts(){
        //die("wtf");
        //$meta = get_post_meta( $ID );
        //$keys = array_keys($meta);
        \wp_enqueue_script('vform-data-filler', \get_site_url().'/wp-content/plugins/vforms/src/VForms/vform-data-filler.js');
        if(isset($_GET['vform-rec-id'])){

            $mypost = get_page_by_title($_GET['vform-rec-id'], OBJECT, 'vdata');
            $vDataPostID = $mypost->ID;

/*

            //$meta = json_encode($meta);
            $x = $meta['checkbox-group'];
            $x = $x[0];
            $x = unserialize($x);
            var_dump($x);
            die();
  */
          //  $x = get_post_meta($vDataPostID, "")
            $meta = get_post_meta( $vDataPostID);
            //var_dump($meta);die("scf120");
            $fixedMeta = [];
            $keys = array_keys($meta);
            //var_dump($keys);die("line 124");
            foreach($keys as $key){

                //var_dump($key);echo("<br/>");
                $x = \get_post_meta($vDataPostID, $key);
                $y = [];
                $y["$key"] = $x[0];
                array_push($fixedMeta, $y);
            }
            //var_dump($fixedMeta);
            //die("line 130 sc");
            $meta = json_encode($fixedMeta);
            //var_dump($meta);die();
            \wp_localize_script( 'vform-data-filler', 'vFormData', [$meta]);
        }
    }
}