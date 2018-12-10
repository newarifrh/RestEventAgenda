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

    public function process_post(){
        $name = $this->post('name');
        $email = $this->post('email');

        $this->response([
            'status' => $name,
            'message' => $email
        ]); 
    }

    public function QnA_get(){
        $id = $this->get('id');
        $nim = $this->get('nim');

        $data = $this->agenda_model->getQnA($id, $nim);

        $this->response($data);
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

    public function sendImg_POST(){
        $img = $this->post('img');
        if($img == ""){
         $this->response([
            [
                'status' => 'false',
                'message' => "fail upload image"
            ]    
        ]); 
     } else{
        $id = $this->agenda_model->getJumlahEvent();
        $digits = 9;
        $id = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT)."_".str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $path = "assets/img/" . $id . ".png";
        file_put_contents($path,base64_decode($img));

        $this->response([
            [
                'status' => 'true',
                'message' => $id
            ]    
        ]); 
    }
}

public function user_get(){
    $nim = $this->get('nim');
    $data = $this->agenda_model->getUser($nim);


    $this->response($data);
}

public function login_post(){
    $nim = $this->post('nim');
    $password = $this->post('password');



    $verification = $this->agenda_model->verification($nim, $password);



    if($verification == 1){

        $data = $this->agenda_model->getUser($nim);


        $this->response($data);


    } else {
        $this->response([
            [
                'status' => 'FALSE',
                'message' => 'No user were found'
            ]    
        ]); 

    }
}

public function manageEvent_get(){
    $nim = $this->get('nim');
    $data = $this->agenda_model->getEvent_by_nim($nim);
    $this->response($data);
}

public function listUserJoinEvent_get(){
    $idEvent = $this ->get('idEvent');
    $data = $this->agenda_model->getUser_by_idEvent($idEvent);
    $this->response($data);
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
    $idPertanyaan =  $this->post('id');

    $test = $this->agenda_model->registerEvent($nim, $idPertanyaan);

    if($test){
        $this->response([[

           'status' => TRUE,
           'message' => 'Success'
       ]
   ]);
    }else{
        echo "gagal blog";
    }
}

public function row_get(){
    echo $this->agenda_model->getJumlahJawaban();
}

public function addPertanyaan_post(){
    $idEvent = $this->post('idEvent');
    $pertanyaan =  $this->post('pertanyaan');
    $this->agenda_model->tambahPertanyaan($idEvent, $pertanyaan );

    $this->response([[
       'status' => TRUE,
       'message' => 'Success'
   ] 
]);
    
}

public function addJawaban_post(){
    $idPertanyaan = $this->post('idPertanyaan');
    $nim =  $this->post('nim');
    $jawaban =  $this->post('jawaban');

    $row = $this->agenda_model->getJumlahJawaban();

    $testing = $this->agenda_model->tambahJawaban($idPertanyaan, $nim, $jawaban );
    if($testing){
        $this->response([[

           'status' => TRUE,
           'message' => 'Success'
       ]
   ]);
    }else{
        echo "GAGAL INI";
    }
}

public function event_post(){

    $nama = $this->input->post('nama');
    $cp = $this->input->post('cp');
    $tanggalMulai = $this->post('tanggalMulai');
    $jamMulai = $this->post('jamMulai');
    $tanggalSelesai = $this->post('tanggalSelesai');
    $lokasi = $this->post('lokasi');
    $deskripsi = $this->post('deskripsi');
    $gambar = $this->post('gambar');


    $row = $this->agenda_model->getJumlahEvent();

    if ($row < 9){
        $row = $row + 1;
        $id = "E00" . $row;
    } else if ($row < 99){
        $row = $row + 1;
        $id = "E0" . $row;
    } else if ($row < 999){
        $row = $row + 1;
        $id = "E" . $row;
    } 

    $gambar = "/ppk/assets/img/" . $gambar . ".png";

    $this->agenda_model->tambahEvent($id, $nama, $tanggalMulai, $jamMulai, $tanggalSelesai, $lokasi, $deskripsi, $cp, $gambar);

    $this->response($id);
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



    if($data == "true"){
        $this->response([[
           'status' => TRUE,
           'message' => 'Success'
       ] 
   ]);
    } else{
        $this->response([[

            'status' => FALSE,
            'message' => 'Failed'
        ]
    ]);
    }
}

public function changeinformasi_post(){
    $nim = $this->post('nim');
    $nohp1 = $this->post('nohp1');
    $nohp2 = $this->post('nohp2');
    $nohp3 = $this->post('nohp3');

    $data = $this->agenda_model->gantihp($nim, $nohp1, $nohp2, $nohp3);
    if($data){
        $this->response([[

           'status' => TRUE,
           'message' => 'Success'
       ]
   ]);

    }else{
        $this->response([
            [
                'status' => FALSE,
                'message' => 'Failed'
            ]      
        ]); 

    }        


}



}