<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Agenda extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('agenda_model');


        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function event_get(){
        $id = $this->get('id');
        $khusus = $this->get('khusus');
        if($khusus == '1'){
            $data = $this->agenda_model->getEvent(FALSE,$khusus);
        }else if($id != ''){
            $data = $this->agenda_model->getEvent($id,FALSE);
        } else {
                // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No event were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $this->response($data);

    }

    public function user_get(){
        $nim = $this->get('nim');
        $data = $this->agenda_model->getUser($nim);
        
        
        $this->response($data);
    }

    public function login_get(){
        $nim = $this->get('nim');
        $password = $this->get('password');

        $verification = $this->agenda_model->verification($nim, $password);



        if($verification == 1){
            $this->response($nim, REST_Controller::HTTP_OK);

        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found'
            ], REST_Controller::HTTP_NOT_FOUND); 

        }

    }

    public function eventku_get(){


        $nim = $this->get('nim');

        if($nim != ''){
            $data = $this->agenda_model->getEventku($nim);
        } else {
                // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No event were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        
        $this->response($data);

    }

    public function register_post(){
       $nim = $this->post('nim');
       $id =  $this->post('id');

       if($nim != '' && $id != ''){

        $result = $this->agenda_model->registerEvent($nim, $id);
    } else {
        $result = FALSE;
    }


    if($result){
        echo 'berhasil';
    } else {
        echo 'ggl';
    }
}

public function event_post(){
    $id =  $this->input->post('id');
    $nama = $this->input->post('nama');
    $cp = $this->input->post('cp');
    $tanggalMulai = $this->post('tanggalMulai');
    $jamMulai = $this->post('jamMulai');
    $tanggalSelesai = $this->post('tanggalSelesai');
    $lokasi = $this->post('lokasi');
    $deskripsi = $this->post('deskripsi');
    $gambar = $this->post('gambar');




    $result = $this->agenda_model->tambahEvent($id, $nama, $tanggalMulai, $jamMulai, $tanggalSelesai, $lokasi, $deskripsi, $cp, $gambar);
    


    if($result){
        echo "brhsl";
    } else {
        echo "ggl";
    }
}

public function search_get(){
    $search = $this->get('key');

    $data =  $this->agenda_model->search($search);

    $this->response($data);

}

public function changepass_post(){
    $nim = $this->post('nim');
    $pwl = $this->post('oldpw');
    $pwb = $this->post('newpw');

    $data = $this->agenda_model->gantipw($nim, $pwl, $pwb);
    if($data){
        echo "berhasil";
    }

}







public function users_get()
{
        // Users from a data store e.g. database
    $users = [
        ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
        ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
        ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
    ];

    $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

    if ($id === NULL)
    {
            // Check if the users data store contains users (in case the database result returns NULL)
        if ($users)
        {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $user = NULL;

        if (!empty($users))
        {
            foreach ($users as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $user = $value;
                }
            }
        }

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function users_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
