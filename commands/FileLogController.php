<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;    
use yii\console\Controller;
//use yii\console\ExitCode;
use yii\helpers\Url;
use yii\base\Exception;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FileLogController extends Controller
{
    /*
     * This command echoes what you have entered as the message.
    */
    public function actionFileCheckSystem()
    {
 
        /*  new entry when cron is hit */
        $cron =  new \app\models\CronHistory ;
        $cron->cron_hit_at =  date('Y-m-d G:i:s');
        $cron->status = 0 ;
        $cron->save();

        $dir =  dirname(__DIR__);
        $result = $this->getUrl($dir);

        /* Creating URL  */
        $url = array();
        if($result){
            foreach ($result as $key => $value) {
                $name = pathinfo($value);
                $string = substr($name['basename'], 0, 1);
                $string2 = strpos($value, '.git');
                if($string != '.' && $name != 'HEAD' && $string2 === false ) {
                    $data = $value; 
                    $substring = substr($data, strpos($data, "biraj_file_checker" ) + 0);
                    $create_url = \Yii::$app->params['url'].'/'. $substring ;
                    $url[] =  $create_url;
                }    
            }
        }
        if($url){
            /*. Select all db data   */
            $db_file_data=(new \yii\db\Query())
                ->select(['*'])
                ->from('file_system')
                ->where('status != :status ',['status' => 3 ])
                ->all(); 

            /* this for first time entering all directories file path in db */
            if(!$db_file_data){
                foreach ($url as $key => $value) {
                    $substring = substr($value, strpos($value, "biraj_file_checker" ) + 18);
                    $path = $dir.'/'.$substring ; 
                    $file_updated_time = date("Y-m-d H:i:s", filemtime($path));
                    $name = pathinfo($value);
                    $file =  new \app\models\FileSystem ;
                    $file->file_name =  $name['basename'];
                    $file->file_url = $value;
                    $file->type = $name['extension'] ?? '' ;
                    $file->last_updated_at = $file_updated_time;
                    $file->status = 1 ;
                    if($file->validate() && $file->save()){
                        $log =  new \app\models\FileLogHistory ;
                        $log->file_system_id =  $file->id ;
                        $log->status = 1 ;
                        $log->last_updated_at = $file_updated_time;
                        $log->save();
                    }
                }
            } 
            /*  This for checking deleted file  */
            if($db_file_data){
                $db_file = array();
                foreach ($db_file_data as $key => $value) {
                    $db_file[$value['id']] =  $value['file_url'];
                }    

                $diff_deleted_file = array_diff($db_file, $url);
                if($diff_deleted_file){
                    foreach ($diff_deleted_file as $key => $value) {
                        $files = \app\models\FileSystem::find()->where(array('id'=> $key ))->one();
                        if($files){
                            $files->status = 3;
                            $files->last_updated_at =  date('Y-m-d G:i:s');
                            if($files->validate() && $files->save()){
                                $log =  new \app\models\FileLogHistory ;
                                $log->file_system_id =  $files->id ;
                                $log->status = 3 ;
                                $log->last_updated_at =  date('Y-m-d G:i:s');
                                $log->save();
                            }
                        }
                    }
                } 
            }    

            /*   this is for checking added new file */
            if($db_file_data){
                $db_file = array();
                foreach ($db_file_data as $key => $value) {
                    $db_file[$value['id']] =  $value['file_url'];
                }   
                $diff_new_file = array_diff($url, $db_file);
                if($diff_new_file){
                    foreach ($diff_new_file as $key => $value) {
                        $substring = substr($value, strpos($value, "biraj_file_checker" ) + 18);
                        $path = $dir.'/'.$substring ; 
                        $file_updated_time = date("Y-m-d H:i:s", filemtime($path));
                        $name = pathinfo($value);
                        $file =  new \app\models\FileSystem ;
                        $file->file_name =  $name['basename'];
                        $file->file_url = $value;
                        $file->type = $name['extension'] ?? '' ;
                        $file->last_updated_at =  $file_updated_time;
                        $file->status = 1 ;
                        if($file->validate() && $file->save()){
                            $log =  new \app\models\FileLogHistory ;
                            $log->file_system_id =  $file->id;
                            $log->status = 1 ;
                            $log->last_updated_at =  $file_updated_time; 
                            $log->save();
                        }
                    }
                }
            } 
            /*  This is for checking updated file  */

            if($db_file_data){
                if($diff_new_file){
                    $updated_file = array_diff($url, $diff_new_file);
                    if($updated_file){
                        foreach ($updated_file as $key => $value) {
                            $substring = substr($value, strpos($value, "biraj_file_checker" ) + 18);
                            $path = $dir.'/'.$substring ; 
                            $file_updated_time = date("Y-m-d H:i:s", filemtime($path));
                            $files = \app\models\FileSystem::find()->where(array('file_url'=> $value ))->one();
                            if($files){
                                if((time() - strtotime($file_updated_time) <  \Yii::$app->params['time']) && (strtotime($file_updated_time) != strtotime($files['last_updated_at'])) ){
                                    $files->status = 2 ;
                                    $files->last_updated_at = $file_updated_time;
                                    if($files->validate() && $files->save() ){
                                        $log =  new \app\models\FileLogHistory ;
                                        $log->file_system_id =  $files->id ;
                                        $log->status = 2 ;
                                        $log->last_updated_at = $file_updated_time;
                                        $log->save();
                                    }
                                    
                                } 
                            }    
                        }
                    }
                } else {
                    foreach ($url as $key => $value) {
                        $substring = substr($value, strpos($value, "biraj_file_checker" ) + 18);
                        $path = $dir.'/'.$substring ;
                        $file_updated_time = date("Y-m-d H:i:s", filemtime($path));
                        $files = \app\models\FileSystem::find()->where(array('file_url'=> $value ))->one();
                        if($files){
                            if((time() - strtotime($file_updated_time) <  \Yii::$app->params['time']) && (strtotime($file_updated_time) != strtotime($files['last_updated_at'])) ){
                                $files->status = 2 ;
                                $files->last_updated_at = $file_updated_time;
                                if($files->validate() && $files->save() ){
                                    $log =  new \app\models\FileLogHistory ;
                                    $log->file_system_id =  $files->id ;
                                    $log->status = 2 ;
                                    $log->last_updated_at = $file_updated_time ;
                                    $log->save();

                                }
                            }
                        } 
                    }
                }
            }
        } 
        $cron->status = 1 ;
        $cron->update();  
    } 
    /*  get all file path of all directories  */
    function geturl($dir, &$file_path = array()){

            $files = array_diff(scandir($dir), array('..','.'));
            foreach ($files as $key => $value) {
                $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
               if(is_dir($path)){
                 $this->geturl($path, $file_path);
               } else {
                    $file_path[] =  $path ;
               }
            }
            return $file_path; 
    }    
}
