<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
     $this->data['CI'] =& get_instance();
     $this->load->helper(array('form', 'url'));
     $this->load->model('M_Admin');
		if($this->session->userdata('masuk_aplikasi') != TRUE){
				$url=base_url('login');
				redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['Motor'] =  $this->db->query("SELECT * FROM tbl_motor ORDER BY id_motor DESC");
        $this->data['title_web'] = 'Data Motor';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/buku_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function motordetail()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_motor','id_motor',$this->uri->segment('3'));
		if($count > 0)
		{
			$this->data['motor'] = $this->M_Admin->get_tableid_edit('tbl_motor','id_motor',$this->uri->segment('3'));
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['showroom'] =  $this->db->query("SELECT * FROM tbl_showroom ORDER BY id_showroom DESC")->result_array();

		}else{
			echo '<script>alert("MOTOR TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data Motor Detail';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/detail',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function motoredit()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$count = $this->M_Admin->CountTableId('tbl_motor','id_motor',$this->uri->segment('3'));
		if($count > 0)
		{
			
			$this->data['motor'] = $this->M_Admin->get_tableid_edit('tbl_motor','id_motor',$this->uri->segment('3'));
	   
			$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
			$this->data['showroom'] =  $this->db->query("SELECT * FROM tbl_showroom ORDER BY id_showroom DESC")->result_array();

		}else{
			echo '<script>alert("MOTOR TIDAK DITEMUKAN");window.location="'.base_url('data').'"</script>';
		}

		$this->data['title_web'] = 'Data Motor Edit';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/edit_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function motortambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
		$this->data['showroom'] =  $this->db->query("SELECT * FROM tbl_showroom ORDER BY id_showroom DESC")->result_array();


        $this->data['title_web'] = 'Tambah Motor';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}


	public function prosesmotor()
	{
		if($this->session->userdata('masuk_aplikasi') != TRUE){
			$url=base_url('login');
			redirect($url);
		}

		// hapus aksi form proses motor
		if(!empty($this->input->get('motor_id')))
		{
        
			$motor = $this->M_Admin->get_tableid_edit('tbl_motor','id_motor',htmlentities($this->input->get('motor_id')));
			
			$sampul = './assets/image/buku/'.$motor->sampul;
			if(file_exists($sampul))
			{
				unlink($sampul);
			}
			
			$lampiran = './assets/image/buku/'.$motor->lampiran;
			if(file_exists($lampiran))
			{
				unlink($lampiran);
			}
			
			$this->M_Admin->delete_table('tbl_motor','id_motor',$this->input->get('motor_id'));
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus Motor !</p>
				</div></div>');
			redirect(base_url('data'));  
		}

		// tambah aksi form proses motor
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$motor_id = $this->M_Admin->buat_kode('tbl_motor','BK','id_motor','ORDER BY id_motor DESC LIMIT 1'); 
			$data = array(
				'motor_id'=>$motor_id,
				'id_kategori'=>htmlentities($post['kategori']), 
				'id_showroom' => htmlentities($post['showroom']), 
				'no_rangka' => htmlentities($post['no_rangka']), 
				'merk'  => htmlentities($post['merk']), 
				'pabrikan'=> htmlentities($post['pabrikan']), 
				'penerbit'=> htmlentities($post['penerbit']),    
				'thn_motor' => htmlentities($post['thn']), 
				'isi' => $this->input->post('ket'), 
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			$this->load->library('upload','$config');
			if(!empty($_FILES['gambar']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('sampul', $file1['upload_data']['file_name']);
				}else{
					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Motor Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			if(!empty($_FILES['lampiran']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'pdf'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				}else{

					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Motor Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			$this->db->insert('tbl_motor', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah motor Sukses !</p>
			</div></div>');
			redirect(base_url('data')); 
		}

		// edit aksi form proses buku
		if(!empty($this->input->post('edit')))
		{
			$post = $this->input->post();
			$data = array(
				'id_kategori'=>htmlentities($post['kategori']), 
				'id_showroom' => htmlentities($post['shoroom']), 
				'no_rangka' => htmlentities($post['no_rangka']), 
				'merk'  => htmlentities($post['merk']),
				'pabrikan'=> htmlentities($post['pabrikan']), 
				'penerbit'=> htmlentities($post['penerbit']),  
				'thn_motor' => htmlentities($post['thn']), 
				'isi' => $this->input->post('ket'), 
				'jml'=> htmlentities($post['jml']),  
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			if(!empty($_FILES['gambar']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$gambar = './assets/image/buku/'.htmlentities($post['gmbr']);
					if(file_exists($gambar)) {
						unlink($gambar);
					}
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('sampul', $file1['upload_data']['file_name']);
				}else{
					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Motor Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			if(!empty($_FILES['lampiran']['name']))
			{
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'pdf'; 
				$config['encrypt_name'] = TRUE;
				 //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$lampiran = './assets_style/image/buku/'.htmlentities($post['lamp']);
					if(file_exists($lampiran)) {
						unlink($lampiran);
					}
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				}else{

					$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Motor Gagal !</p>
						</div></div>');
					redirect(base_url('data')); 
				}
			}

			$this->db->where('id_motor',htmlentities($post['edit']));
			$this->db->update('tbl_motor', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
					<p> Edit Motor Sukses !</p>
				</div></div>');
			redirect(base_url('data/motoredit/'.$post['edit'])); 
		}
	}

	public function kategori()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['kategori'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_kategori','id_kategori',$id);
			if($count > 0)
			{			
				$this->data['kat'] = $this->db->query("SELECT *FROM tbl_kategori WHERE id_kategori='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/kategori').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Kategori ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('kategori/kat_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function katproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);

			$this->db->insert('tbl_kategori', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);
			$this->db->where('id_kategori',htmlentities($post['edit']));
			$this->db->update('tbl_kategori', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 		
		}

		if(!empty($this->input->get('kat_id')))
		{
			$this->db->where('id_kategori',$this->input->get('kat_id'));
			$this->db->delete('tbl_kategori');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 
		}
	}

	public function showroom()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['showroom_motor'] =  $this->db->query("SELECT * FROM tbl_showroom ORDER BY id_showroom DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_showroom','id_showroom',$id);
			if($count > 0)
			{	
				$this->data['showroom'] = $this->db->query("SELECT *FROM tbl_showroom WHERE id_showroom='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/showroom').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Showroom Motor ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('rak/rak_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function showroomproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_showroom'=>htmlentities($post['showroom']),
			);

			$this->db->insert('tbl_showroom', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Showroom Motor Sukses !</p>
			</div></div>');
			redirect(base_url('data/showroom'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_showroom'=>htmlentities($post['showroom']),
			);
			$this->db->where('id_showroom',htmlentities($post['edit']));
			$this->db->update('tbl_showroom', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit showroom Sukses !</p>
			</div></div>');
			redirect(base_url('data/showroom')); 		
		}

		if(!empty($this->input->get('showroom_id')))
		{
			$this->db->where('id_showroom',$this->input->get('showroom_id'));
			$this->db->delete('tbl_showroom');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Showroom Motor Sukses !</p>
			</div></div>');
			redirect(base_url('data/showroom')); 
		}
	}
}
