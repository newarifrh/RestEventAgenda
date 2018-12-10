<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

	public function getJumlahJawaban(){
		return $this->db->get('jawabantambahan')->num_rows();
	}

	public function getJumlahEvent(){
		return $this->db->get('event')->num_rows();
	}

	public function tambahJawaban($idPertanyaan, $nim, $jawaban){
		return $this->db->insert('jawabantambahan', array('idPertanyaan'=>$idPertanyaan,'nim'=>$nim,'jawaban'=>$jawaban));
	}
	public function tambahPertanyaan($idEvent, $pertanyaan ){
		return $this->db->insert('pertanyaantambahan', array('idEvent'=>$idEvent,'pertanyaan'=>$pertanyaan));
	}

	public function getEvent_by_nim($nim){
		$this->db->select('*');
		$this->db->where('cp', $nim);
		return $this->db->get('event')->result_array();

	}

	public function getUser_by_idEvent($idEvent){
		$this->db->select(array('u.nim', 'u.nama', 'u.kelas', 'm.idEvent'));
		$this->db->from('user u');
		$this->db->join('myevent m', 'm.nim = u.nim');
		$this->db->where('m.idEvent', $idEvent);
		return $this->db->get()->result_array();
	}

	public function getEvent($id = FALSE, $khusus = FALSE){
		if($khusus === FALSE){


			

			


			$cek = $this->db->get_where('pertanyaantambahan', array('idEvent' => $id))->num_rows();

			if($cek==0){
				$this->db->select(array('e.*', 'p.pertanyaan'));
				$this->db->from('event e');
				$this->db->join('pertanyaantambahan p', 'e.id = p.idEvent', 'left');
				$this->db->where('e.id', $id);




				return $this->db->get()->result_array();

			} else {

				$this->db->select(array('e.*', 'p.pertanyaan','p.idPertanyaan'));
				$this->db->from('event e');
				$this->db->join('pertanyaantambahan p', 'e.id = p.idEvent');
				$this->db->where('e.id', $id);


				return $this->db->get()->result_array();		
			}
		} else if($khusus == 1){
			$this->db->select(array('id','nama','gambar'));
			return $this->db->get('event')->result_array();
		}
	}
//array('Unpaid AS u.status','u.nim', 'u.nama', 'u.kelas', 'u.kode', 'n.noHP1', 'n.noHP2', 'n.noHP3')
	public function getUser($nim){

		
		$this->db->select(array('"true" as status', 'u.nim', 'u.nama', 'u.kelas', 'u.kode', 'n.noHP1', 'n.noHP2', 'n.noHP3', 'm.idEvent'));
		$this->db->from('user u');
		$this->db->join('nohp n', 'u.nim = n.nim');
		$this->db->join('myevent m', 'u.nim = m.nim', 'left');
		$this->db->where('u.nim', $nim);

		return $this->db->get()->result_array();



	}

	public function verification($nim, $password){
		return $this->db->get_where('user', array('nim' => $nim, 'password' => $password))->num_rows();
	}

	public function getEventku($nim){
		$this->db->select(array('e.id','e.nama','e.gambar'));
		$this->db->from('event e');
		$this->db->join('myevent m', 'm.idEvent = e.id');
		$this->db->where('m.nim', $nim);

		return $this->db->get()->result_array();

	}

	public function registerEvent($nim, $id){

		$data = array(
			'nim' => $nim,
			'idEvent' => $id
		);
		return $this->db->insert('myevent', $data);
		
	}

	public function tambahEvent($id, $nama, $tanggalMulai = NULL, $jamMulai = NULL, $tanggalSelesai = NULL, $lokasi = NULL, $deskripsi = NULL, $cp, $gambar= NULL ){
		try {
			$data = array(
				'id' => $id,
				'nama' => $nama,
				'tanggalMulai' => $tanggalMulai,
				'jamMulai' => $jamMulai,
				'tanggalSelesai' => $tanggalSelesai,
				'lokasi' => $lokasi,
				'deskripsi' => $deskripsi,
				'cp' => $cp,
				'gambar' => $gambar
			);

			return $this->db->insert('event', $data);
			
		} catch(Exception $e){
			return FALSE;
		}
	}

	public function search($search){

		$timezone = "Asia/jakarta";
		date_default_timezone_set($timezone);
		$now =  date('Y-m-d');

		
		$this->db->select('*');
		$this->db->like('nama', $search);
		//$this->db->where('tanggalMulai', $now);
		return $this->db->get('event')->result_array();


	}

	public function gantipw($nim, $pwl, $pwb){

		
		$this->db->where(array('nim' => $nim, 'password' => $pwl));
		if($this->db->get('user')->num_rows() == 1){


			$this->db->set('password', $pwb);
			$this->db->where(array('nim' => $nim, 'password' => $pwl));
			$this->db->update('user');
			return "true";
		} else {
			return "false";
		}
		
	}

	public function gantihp($nim, $nohp1, $nohp2, $nohp3){

		$this->db->set(array('noHP1' => $nohp1, 'noHP2' => $nohp2, 'noHP3' => $nohp3));
		$this->db->where('nim', 	$nim);
		
		
		
		return $this->db->update('nohp');

	}

	public function getQnA($id, $nim){
		$this->db->select(array('e.pertanyaan','m.jawaban'));
		$this->db->from('pertanyaantambahan e');
		$this->db->join('jawabantambahan m', 'm.idPertanyaan = e.idPertanyaan');
		$this->db->where(array('m.nim' => $nim, 'e.idEvent' => $id));

		return $this->db->get()->result_array();
	}



}
