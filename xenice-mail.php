<?php

/**
 * Plugin Name: Xenice Mail
 * Plugin URI: https://www.xenice.com
 * Description: Simple Mail Plugin
 * Version: 1.2.2
 * Author: Xenice
 * Author URI: https://www.xenice.com
 * Text Domain: xenice-mail
 * Domain Path: /languages
 */


namespace xenice\mail;

 /**
 * autoload class
 */
function __autoload($classname){
    $classname = str_replace('\\','/',$classname);
    $namespace = 'xenice/mail';
    if(strpos($classname, $namespace) === 0){
        $filename = str_replace($namespace, '', $classname);
        require  __DIR__ .  $filename . '.php';
    }
}




 /**
 * get option
 */
function get($name, $key='xenice_mail')
{
    
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}


 /**
 * set option
 */
function set($name, $value, $key='xenice_mail')
{
    $options = get_option($key)?:[];
    foreach($options as $id=>&$o){
        if(isset($o[$name])){
            $o[$name] = $value;
            update_option($key, $options);
            return;
        }
    }
}

/**
* auto execute when active this plugin
*/
register_activation_hook( __FILE__, function(){
    spl_autoload_register('xenice\mail\__autoload');
    (new Config)->active();

});


add_action( 'plugins_loaded', function(){
    spl_autoload_register('xenice\mail\__autoload');
    $plugin_name = basename(__DIR__);
    load_plugin_textdomain( $plugin_name, false , $plugin_name . '/languages/' );
    // add setting menus
    add_action( 'admin_menu', function(){
        add_options_page(__('Mail','xenice-mail'), __('Mail','xenice-mail'), 'manage_options', 'xenice-mail', function(){
            //var_dump(get('enable_title'));
            (new Config)->show();

        });
        
    });
    
    // Add setting button
    $plugin = plugin_basename (__FILE__);
    add_filter("plugin_action_links_$plugin" , function($links)use($plugin_name){
        $settings_link = '<a href="options-general.php?page='.$plugin_name.'">' . __( 'Settings', 'xenice-mail') . '</a>' ;
        array_push($links , $settings_link);
        return $links;
    });
    
    add_action('phpmailer_init', function($phpmailer){
        $phpmailer->IsSMTP();
		$mail_name = get('mail_from_name');
		$mail_host = get('mail_host');
		$mail_port = get('mail_port');
		$mail_smtpsecure = get('mail_smtp_secure');
		
		$phpmailer->FromName = $mail_name ?: 'xenice'; 
		$phpmailer->Host = $mail_host ?:'smtp.qq.com';
		$phpmailer->Port = $mail_port ?: '465';
		$phpmailer->Username = get('mail_username');
		$phpmailer->Password = get('mail_password');
		$phpmailer->From = get('mail_username');
		$phpmailer->SMTPAuth = get('mail_smtp_auth');
		$phpmailer->SMTPSecure = $mail_smtpsecure ?: 'ssl';
		add_filter('wp_mail_from_name', function ($old) {return $mail_name;});
    });
	
	add_action('wp_mail_failed', function ($error){
	    $msg = $error->get_error_message();
	    if($msg){
	        update_option('xenice_mail_error', '<br/>' . $error->get_error_message());
	    }
	    
    });
    
    // change send action results
    add_filter('xenice_mail_options_save', function($key, $tab, $data){
        if($key == 'mail' && $tab == 1){
           global $current_user;
            $bool = wp_mail($current_user->user_email, $data['mail_title']??'', $data['mail_content']??'');
            if($bool){
                $result = ['key'=>$key, 'return' => 'success', 'message'=>__('Send successfully', 'xenice-mail')];
                update_option('xenice_mail_error', '');
            }
            else{
                $msg = get_option('xenice_mail_error', true);
                $result = ['key'=>$key, 'return' => 'error', 'message'=>__('Send failure', 'xenice-mail') . $msg];
            }
                
            apply_filters('xenice_mail_options_result', $result);
        }
        else{
            return $key;
        }
    },10,3);

});


