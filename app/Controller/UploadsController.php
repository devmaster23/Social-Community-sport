<?php
App::uses('AppController', 'Controller');

/**
 * Uploads Controller
 *
 * @property Upload $Upload
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 */
class UploadsController extends AppController
{
    public $View;

    /**
     * Components
     *
     * @var array
     */
    public $components = [
        'Paginator',
        'Flash',
        'Session',
        'File'
    ];

    /**
     * Uses
     *
     * @var array
     */
    public $uses = [
        'Upload'
    ];

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->View = new View($this, false);
    }

    /**
     * index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_index()
    {
        if (! empty($this->data))
        {
            // pr($this->data);die;
            // get the file type data from submitted form
            $files_data = $this->data['User']['file_id'];
            // Upload the file using file component
            $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/');
            // Use the returned id as foreign key
            prx($upload_info);
        }
    }
}