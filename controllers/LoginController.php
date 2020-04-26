<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class LoginController extends Controller
{
 
    public function actionIndex(){
         $session = Yii::$app->session;
        // if(isset($session['user_name']) && isset($session['type'])){
        //     Yii::$app->response->redirect(['users/users']);
        // }
    	 return $this->render('login');		
    }

    public function actionLogin(){
    	if($_POST){    
            $username = $_POST['username']; 
    		$password = $_POST['password'];   
    	    $user=(new \yii\db\Query())
	            ->select(['*'])
	            ->from('admin_login')
	            ->where('username= :username AND status = :status', [':username' => $username,':status' => 1])
	            ->one(); 
            if($user){
            	$userId = \app\models\AdminLogin::find()->where(array('id'=>$user['id']))->one();	
            	$result = $userId->validatePassword($password); 
            	if($result){
                    $session = Yii::$app->session;
                    $session['user_name'] = $userId->username;
                    $session['type'] = 'Admin';
                    Yii::$app->response->redirect(['users/users']); 
		        } else {
		            return $this->render('login',[ 'message' => 'username and password does not match' ]);
		        }
            }  else {
            	return $this->render('login',[ 'message' => 'username not found ' ]);	
            } 
    	}  
    }
    public function actionLogout(){
        $session = Yii::$app->session;
        $session->remove('user_name');
        $session->remove('type');
        Yii::$app->response->redirect(['login/index']);
    }
  
}


