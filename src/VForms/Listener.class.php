<?php

namespace VForms;

class Listener{

    public function doCaptureSubmission(){
        $data = $_POST;
        $vDataPostID = $this->isExistingForm($data);
        //var_dump($vDataPostID);die("101010");
        if($vDataPostID){
            $data['vdata-post-id'] = $vDataPostID->ID;
            $this->updateVForm($data);
        }else{
            //die("creating new");
            $this->createNewVForm($data);
        }
    }

    public function createNewVForm($data){
         $content = json_encode($data);

        $my_post = array(
            'post_title'    => $data['vform-rec-id'],
            'post_type'     => 'vdata',
            'post_content'  => $content,
            'post_status'   => 'publish',
        );
        $ID = wp_insert_post( $my_post );
        $keys = array_keys($data);
        foreach ($keys as $key){
            $d = $data[$key];
            if(is_array($d)){
                //var_dump($key);echo("<br />");
                //var_dump($d);echo("<br />");
                //die("arrayadd35");
                //$z = ["xxxxxxxx", "yyyyy", "zzzzz"];
                \add_post_meta( $ID, $key, $d);
                //die("adding array");
                //$E = \get_post_meta($ID, $key);
                //$E = $E[0];
                //var_dump($E);die('xxxxxxxxxxx');
            }

            \update_post_meta( $ID, $key,$data[$key]);
        }
    }
    public function updateVForm($data){
        $content = json_encode($data);

        $my_post = array(
            'ID'           => $data['vdata-post-id'],
            'post_title'    => $data['vform-rec-id'],
            'post_type'     => 'vdata',
            'post_content'  => $content,
            'post_status'   => 'publish',
        );
        wp_update_post( $my_post );
        //var_dump($data);die("listener 58");
        $keys = array_keys($data);
        foreach ($keys as $key){
           // echo($key . "<br />");
            //var_dump ($data[$key]);
            //echo "<br/><br/>";
            $d = $data[$key];

            update_post_meta( $data['vdata-post-id'], $key, $d);
        }
        //die();
    }

    public function isExistingForm($data){
        $mypost = get_page_by_title($data['vform-rec-id'], OBJECT, 'vdata');
        return $mypost;
    }

}