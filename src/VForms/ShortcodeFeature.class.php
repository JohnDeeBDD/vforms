<?php

namespace VForms;

class ShortcodeFeature{

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function renderShortcode($args){
        $src = \plugin_dir_url(__FILE__) . "form-render.min.js";
        $content = "<script src='$src' id='formRender'></script>";
        $content_post = get_post($args['id']);
        $json = $content_post->post_content;

        //this tells vforms where the data came from:
        $hiddenFieldTag = "<input type = 'hidden' name = 'vform-post-id' value = '" . get_the_ID() . "' />";

        if($this->isDataFillerPage()){
            $vFormRecID = $_GET['vform-rec-id'];
        }else{
            $vFormRecID = $this->generateRandomString(15);
        }
        $hiddenVformRecIDField= "<input type = 'hidden' name = 'vform-rec-id' id = 'vform-rec-id' value = '$vFormRecID' />";

        $content = $content . <<<OUTPUT
<form method = 'post' id = "vform-form"><div id = "fb-template" class = "fb-render"></div>
$hiddenFieldTag
$hiddenVformRecIDField
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
OUTPUT;
        if($this->isDataFillerPage()){
            $content = $content . "
            VFormDataFiller.doFill();
            ";
        }
        $content = $content . " 
});
</script>";

        return $content;
    }

    public function isDataFillerPage(){
        if(isset($_GET['vform-rec-id'])) {
            $mypost = get_page_by_title($_GET['vform-rec-id'], OBJECT, 'vdata');
            if (($_GET['vform-rec-id'] == "") or ($_GET['vform-rec-id'] == "undefined") or ($mypost === null)) {
                return false;
            }else{
                return true;
            }
        }
    }
/*
    public function getJQuery($ID){
        $meta = get_post_meta( $ID );
        $keys = array_keys($meta);
        $js =
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



OUTPUT;
            $js = $js . $output;

            $js = $js . "jQuery(\"[name='$key']\").val('" . $meta[$key][0] . "');";
           // $js = $js . "console.log('" .$key . " " . $meta[$key][0] . "');";
        }

        $js =
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

*/

    public function doEnqueuFrontendScripts(){
        //die("wtf");
        if(!($this->isDataFillerPage())){
            return;
        }

                $mypost = get_page_by_title($_GET['vform-rec-id'], OBJECT, 'vdata');
                \wp_enqueue_script('vform-data-filler', \get_site_url().'/wp-content/plugins/vforms/src/VForms/vform-data-filler.js');
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
            //die("line 121");
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