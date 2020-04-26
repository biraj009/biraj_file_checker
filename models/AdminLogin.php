<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
/**
 * ContactForm is the model behind the contact form.
 */
class AdminLogin extends \yii\db\ActiveRecord implements IdentityInterface
{
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['password', 'validatePassword'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    public  function validatePassword($password) {
       return \Yii::$app->security->validatePassword($password, $this->password);
    }  
   
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        
    }

    /**
    * Get the identity by access_token
    * Added JWT Decoding to get the access_token
    * @param $token, $type = null
    * @return mixed array $identity;
    */
    public static function findIdentityByAccessToken($token, $type = null)
    { 
       
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username, $isDelivery = 0)
    {
        
    }
    
    public static function findById($id)
    {

    }

    public function getId(){

    }

    public function validateAuthKey($authKey){

    }

    public function getAuthKey(){
        
    }

}
