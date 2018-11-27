<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {


	public function getEvent($id = FALSE, $khusus = FALSE){
		if($khusus === FALSE){

			$this->db->select(array('e.*', 'p.pertanyaan'));
			$this->db->from('event e');
			$this->db->join('pertanyaantambahan p', 'e.id = p.idEvent');
			$this->db->where('e.id', $id);
			
			return $this->db->get()->result_array();
			
		} else if($khusus == 1){
			$this->db->select(array('id','nama','gambar'));
			return $this->db->get('event')->result_array();
		}
	}

	public function getUser($nim){
		$this->db->select(array('u.nim', 'u.nama', 'u.kelas', 'u.password', 'u.kode', 'n.noHP1', 'n.noHP2', 'n.noHP3'));
		$this->db->from('user u');
		$this->db->join('nohp n', 'u.nim = n.nim');
		$this->db->where('u.nim', $nim);
		return $this->db->get()->result_array();

		//$data = $this->db->get_where('user', array('nim' => $nim))->result_array();
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
		$querry = $this->db->insert('myevent', $data);
		
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
		$this->db->select('*');
		$this->db->like('nama', $search);
		return $this->db->get('event')->result_array();


	}

	public function gantipw($nim, $pwl, $pwb){

		$this->db->set('password', $pwb);
		$this->db->where(array('nim' => $nim, 'password' => $pwl));
		$this->db->update('user');

		return TRUE;




	}



}
