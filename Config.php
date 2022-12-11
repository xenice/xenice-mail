<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\mail;

class Config extends Options
{
    protected $key = 'mail';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'mail',
            'name'=> __('Mail','xenice-mail'),
            'submit'=>__('Save Changes','xenice-mail'),
            'title'=> __('Mail Settings', 'xenice-mail'),
            'tabs' => [
                [
                    'id' => 'setting',
                    'title' => __('Mail Settings', 'xenice-mail'),
                    'fields'=>[
                        [
                            'id'   => 'mail_from_name',
                            'name' => __('From Name', 'xenice-mail'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_host',
                            'name' => __('SMTP Host', 'xenice-mail'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_port',
                            'name' => __('SMTP Port', 'xenice-mail'),
                            'type'  => 'number',
                            'value' => 465
                        ],
                        [
                            'id'   => 'mail_username',
                            'name' => __('Mail Account', 'xenice-mail'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_password',
                            'name' => __('Mail Password', 'xenice-mail'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_smtp_auth',
                            'name' => __('SMTP Auth', 'xenice-mail'),
                            'label' => __('Enable SMTP Auth service', 'xenice-mail'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'   => 'mail_smtp_secure',
                            'name' => __('SMTP Secure', 'xenice-mail'),
                            'desc' => __('Fill in ssl if SMTP Auth service is enabled, leave blank if not','xenice-mail'),
                            'type'  => 'text',
                            'value' => 'ssl'
                        ],
                    ]
                ],
                [
                    'id' => 'send',
                    'title' => __('Send Mail', 'xenice-mail'),
                    'submit'=> __('Send', 'xenice-mail'),
                    'fields'=>[
                        [
                            'id'   => 'mail_title',
                            'name' => __('Mail Title', 'xenice-mail'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_content',
                            'name' => __('Mail Content', 'xenice-mail'),
                            'type'  => 'textarea',
                            'value' => '',
                            'style' => 'regular',
                            'rows' => 10
                        ],
                    ]
                ]
            ]
        ];
	    parent::__construct();
    }
    
    /**
     * update options
     */
     /*
    public function update($id, $tab, $fields)
    {
        if($key == 'mail' && $tab == 1){
            global $current_user;
            //$bool = wp_mail($current_user->user_email, $fields['mail_title']??'', $fields['mail_content']??'');
            $bool = true;
            if($bool)
                $result = ['key'=>$id, 'return' => 'success', 'message'=>__('Send successfully', 'xenice-mail')];
            else
                $result = ['key'=>$id, 'return' => 'error', 'message'=>__('Send failure', 'xenice-mail')];
            Theme::call('xenice_options_result', $result);
        }
        else{
            parent::update($id, $tab, $fields);
        }
        
       
    }*/


}