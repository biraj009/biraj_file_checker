<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UsersController extends Controller
{
    
    public function actionUsers(){
        $session = Yii::$app->session;
        if(!isset($session['user_name']) && !isset($session['type'])){
            Yii::$app->response->redirect(['login/index']);
        }
        /* deleted Files */
        $last_cron_time = (new \yii\db\Query())
                    ->select(['*'])
                    ->from('cron_history')
                    ->where('status = :status ',['status' => 1 ])
                    ->orderBy('cron_hit_at DESC')
                    ->one();          

        if($last_cron_time){
        	$time = strtotime($last_cron_time['cron_hit_at']);
        } else {
        	$time = time();
        }             
        /* deleted Files */            
        $deleted_files = (new \yii\db\Query())
            ->select(['*'])
            ->from('file_system')
            ->where('status= :status', [':status' => 3])
            ->all(); 
        

        $deleted_files_array = array();
        if($deleted_files){
        	foreach ($deleted_files as $key => $value) {
                $file_updated_time = $value['last_updated_at'];
        		if($time - strtotime($file_updated_time) <  \Yii::$app->params['time'] ){
        			$deleted_files_array[] =  $value ;
        		}
        	}
        } 

        /* new  Files */            
        $new_files = (new \yii\db\Query())
            ->select(['*'])
            ->from('file_system')
            ->where('status= :status', [':status' => 1])
            ->orderBy('last_updated_at DESC')
            ->limit(20)
            ->all(); 
        $new_files_array = array();
        if($new_files){
        	foreach ($new_files as $key => $value) {
                $file_updated_time = $value['last_updated_at'];
        		if($time - strtotime($file_updated_time) <  \Yii::$app->params['time'] ){
        			$new_files_array[] =  $value ;
        		}
        	}
        } 
        /* Updated  Files */            
        $updated_files = (new \yii\db\Query())
            ->select(['*'])
            ->from('file_system')
            ->where('status= :status', [':status' => 2])
            ->orderBy('last_updated_at DESC')
            ->all(); 
        $updated_files_array = array();
        if($updated_files){
        	foreach ($updated_files as $key => $value) {
                $file_updated_time = $value['last_updated_at'];
        		if($time - strtotime($file_updated_time) <  \Yii::$app->params['time'] ){
        			$updated_files_array[] =  $value ;
        		}
        	}
        }           

    	return $this->render('users', ['deleted_files_array' => $deleted_files_array, 'new_files_array' => $new_files_array, 'updated_files_array' => $updated_files_array ]);
    }
}


