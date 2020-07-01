<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resi extends MY_Controller
{
	public function index()
	{
		$this->db->order_by('id','desc');
		$data['resi'] = $this->db->get('tbl_sales')->result_array(); 
		
		$this->load->view('resi', $data);
	}

}
