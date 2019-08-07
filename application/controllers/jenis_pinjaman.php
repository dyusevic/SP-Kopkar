<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_pinjaman extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['jenis_pinjaman_m','akun_m']);
  }

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Pinjaman';

		$this->data['data_jpinjam'] = $this->jenis_pinjaman_m->get_data_jpinjam()->result();
		$this->data['coa'] = $this->akun_m->get_data_akun_where_aktif()->result();
		$this->data['isi'] = $this->load->view('jenis_pinjaman_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function post_jenis_pinjam(){
		$this->form_validation->set_rules('kd_jns_pinjam2', 'kd_jns_pinjam2', 'required');
		$this->form_validation->set_rules('jns_pinjam2', 'jns_pinjam2', 'required');
		$this->form_validation->set_rules('vcCOACode2', 'vcCOACode2', 'required');
		$this->form_validation->set_rules('coapb2', 'coapb2', 'required');
		$this->form_validation->set_rules('coaba2', 'coaba2', 'required');
		$this->form_validation->set_rules('coada2', 'coada2', 'required');
		$this->form_validation->set_rules('tampil2', 'tampil2', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'kode_jenis_pinjam'=> $this->input->post('kd_jns_pinjam2'),
				'jns_pinjam'=> $this->input->post('jns_pinjam2'),
				'vcCOACode' => $this->input->post('vcCOACode2'),
				'tampil' 	=> $this->input->post('tampil2'),
				'COAPB'		=> $this->input->post('coapb2'),
				'namaCOAPB' => $this->input->post('namacoapb2'),
				'COABA'		=> $this->input->post('coaba2'),
				'namaCOABA'	=> $this->input->post('namacoaba2'),
				'COADA'		=> $this->input->post('coada2'),
				'namaCOADA'	=> $this->input->post('namacoada2'),
			);

			if($this->jenis_pinjaman_m->insert($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function post_update_jenis_pinjaman(){
		$this->form_validation->set_rules('jns_pinjam', 'jns_pinjam', 'required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode','coapb','coaba', 'required');
		$this->form_validation->set_rules('tampil','tampila', 'required');
		$this->form_validation->set_rules('id','ID', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'jns_pinjam' 	=> $this->input->post('jns_pinjam'),
				'vcCOACode' 	=> $this->input->post('vcCOACode'),
				'tampil' 	    => $this->input->post('tampil'),
				'COAPB'		=> $this->input->post('coapb'),
				'namaCOAPB' => $this->input->post('namacoapb'),
				'COABA'		=> $this->input->post('coaba'),
				'namaCOABA'	=> $this->input->post('namacoaba'),
				'COADA'		=> $this->input->post('coada'),
				'namaCOADA'	=> $this->input->post('namacoada'),
			);
			$id = $this->input->post('id');
			if($this->jenis_pinjaman_m->update($id, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete($id) {
		if($this->jenis_pinjaman_m->delete($id)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
		}
	}
}
