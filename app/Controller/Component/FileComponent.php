<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('FILE_UPLOAD_SIZE', '10485760');
App::uses('CakeSession', 'Model/Datasource'); App::uses('Component', 'Controller');
class FileComponent extends Component {
        public $csession;
    public $Upload;
        public $path = 'files/';
        public $error = ['There is no error, the file uploaded with success.', 'The uploaded file size exceeds the server limit.', 'The uploaded file exceeds HTML specified size.', 'The uploaded file was only partially uploaded', 'No file was uploaded', 'An undefined error occured', 'Missing a temporary folder', 'Failed to write file to disk', 'A PHP extension stopped the file upload'];
    //    public function __construct(ComponentCollection $collection, $settings = array()) {
    //    $settings = array_merge($this->settings, (array) $settings);
    //    $this->Controller = $collection->getController();
    //    parent::__construct($collection, $settings);
    //}

        public function __Construct(ComponentCollection $collection){
        $this->Controller = $collection->getController();
            $this->csession = CakeSession::read('Auth');
            $this->Upload = ClassRegistry::init('Upload');

        }

        /**
         * upload method
         *
         * @param $files_data: Array of $_FILES super globar variable
         * @param $path: folder location where the file is to be uploaded
         * @param $server_file_name: Name by which uploaded file will be saved on server
         * @param $upload_only: set to true if you don't want to save uploaded file info to database
         * @param $options: for further modifications in this funtion (Developer's purpose)
         *
         * @throws NotFoundException
         *
         * @return (bool)status, [optional](array)files_response
         */
        public function upload($files_data, $path = false, $server_file_name = null, $upload_only = false, $options = []){
                //set path to upload if not specified
                $path = ($path === false) ? WWW_ROOT . $this->path : $path;
                $direcotyPath = $path;

                if(!$server_file_name){
                    $server_file_name = date('YmdHis') . $files_data['name'];
                }
                $newName = $server_file_name;
        //$this->Controller->Auth->Session->write('File.new_name', $newName);

                $path .= $server_file_name; //date("YmdHis").$files_data["name"];
                //Check if file contains error.
                $valid = $this->_validate($files_data);
                if(!$valid){
                    return ['uploaded'=>false, 'message'=>$valid['message']];
                }

                if(move_uploaded_file($files_data['tmp_name'], $path)){
                        if($upload_only){
                            //Don't save to the database and return
                            return ['uploaded'=>true, 'message'=>'Uploaded. No information in database.', 'path'=>$path, 'db_info'=>[]];
                        }

                            //Save to databse and return
                            $save_data = [];
                            if(key_exists('file_id',$files_data) && $files_data['file_id'] != ''){
                                $save_data['Upload']['id'] = $files_data['file_id'];
                                $fileinfo =$this->Upload->find('first',['conditions'=>['Upload.id'=>$files_data['file_id']]]);
                                //pr($fileinfo);
                               //unlink(WWW_ROOT.$fileinfo['Upload']['path']);
                                unlink($direcotyPath . $fileinfo['Upload']['new_name']);
                                if (file_exists($direcotyPath . 'large/' . $fileinfo['Upload']['new_name'])) {
                                    unlink($direcotyPath . 'large/' . $fileinfo['Upload']['new_name']);
                                }
                                if (file_exists($direcotyPath . 'large/' . $fileinfo['Upload']['new_name'])) {
                                    unlink($direcotyPath . 'thumbnail/' . $fileinfo['Upload']['new_name']);
                                }
                            }

                            $save_data['Upload']['new_name'] = $newName;
                            $save_data['Upload']['name'] = $files_data['name'];
                            $save_data['Upload']['path'] = '/' . str_replace(WWW_ROOT, '', $path);
                            $this->Upload->create();
                            if($file_array = $this->Upload->save($save_data)){
                                return ['uploaded'=>true, 'message'=>'Uploaded', 'path'=>$path, 'db_info'=>$file_array];
                            }

                                return ['uploaded'=>true, 'message'=>'Uploaded. No information in database.', 'path'=>$path, 'db_info'=>[]];

                }

                    return ['uploaded'=>false, 'message'=>'Please check the permissions or contact server admin.'];

        }

        public function _validate($data){
                if($data['error']){
                    return ['valid'=>false, 'message'=>$this->error[$data['error']]];
                }
                else if($data['size'] > FILE_UPLOAD_SIZE){
                    $mb = ((FILE_UPLOAD_SIZE/1024)/1024) . ' MB';
                    return ['valid'=>false, 'message'=>'Application allows only ' . $mb];
                }

                return ['valid'=>true, 'message'=>$this->error[0]];
        }
}
