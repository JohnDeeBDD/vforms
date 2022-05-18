<?php

namespace VForms;

class VEditor{

    public function JSHandler(){

    }

    public function doEnqueueAdminScript(){
        //die("doEnqueueAdminScript");
        \wp_enqueue_script('veditor', \get_site_url().'/wp-content/plugins/vforms/src/VForms/VEditor.js');
        //\wp_enqueue_script('veditor', \get_site_url().'/wp-content/plugins/vforms/src/VForms/VEditor.js');
        \wp_enqueue_script('fb1', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js');
        \wp_enqueue_script('fb2', 'https://formbuilder.online/assets/js/form-builder.min.js');

        if(isset($_GET['post'])){
            //here we can assume "post" is a VForm
            $formData = \get_the_content($_GET['post']);
            \wp_localize_script( 'veditor', 'formData', [$formData]);
        }else{
           \wp_localize_script( 'veditor', 'formData', []);
        }

        add_action("admin_footer", [new VEditor, 'doEchoAdminFooter']);
    }

    public function doEchoAdminFooter(){
        $output = <<<OUTPUT
<style>
#postdivrich{display:none;}
#minor-publishing{display:none;}
.get-data{display:none !important;}
.save-template{display:none !important;}
.formbuilder-icon-autocomplete{display:none !important;}
.input-control-10{display:none !important;}
</style>
OUTPUT;
        echo($output);
    }
    public function doBackFillContentToJSEditor($postID){
        $content = \get_the_content($postID);
        $output = <<<OUTPUT
<script>
//var fbEditor = document.getElementById('build-wrap');
//var formBuilder = $(fbEditor).formBuilder();
jQuery(function($) {
    var formData = $content;
    formBuilder.actions.setData(formData);
});
</script>
OUTPUT;
    echo $output;

    }
    public function returnScriptHTML(){
        $output = <<<OUTPUT
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
OUTPUT;
        echo $output;
    }

    public function doRenderJS(){
        $output = $this->returnScriptHTML();
        $output = $output . <<<OUTPUT


  <script>
    jQuery(function($) {
        $(document.getElementById('fb-editor')).formBuilder();
        $("#jimslinebr").appendTo("#titlewrap");
        $("#fb-editor").appendTo("#titlewrap");
        $("#vform-getjson").appendTo("#titlewrap");

        let fbEditor = document.getElementById('build-wrap');
        let formBuilder = $(fbEditor).formBuilder();
        document.getElementById('vform-getjson').addEventListener('click', function() {
            //alert(formBuilder.actions.getData('json', true));
            $("#content").val(formBuilder.actions.getData('json', true));
        });
        $(document).submit(function(e) {
            e.preventDefault()
            $("#content").val(formBuilder.actions.getData('json', true));
            $(this).unbind('submit').submit();
            $("#post, #save").submit();
        });
        
    });
</script>
<script>
jQuery( document ).ready(function() {
    console.log( "ready again!" );
    var vFormContent = $("#content").val();
    console.log(vFormContent);
});
</script>
<style>
#fb-editor{margin-top;15px;}
#minor-publishing{display:none;}
/*#postdivrich{display:none;}*/
.formbuilder-icon-autocomplete{display:none;}
</style>
OUTPUT;
        echo $output;
    }
}
//wp-post-new-reload=true