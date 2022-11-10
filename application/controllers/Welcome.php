<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$area =  $this->chart_model->select_area();
		$start_date = '2021-01-01';
		$end_date = '2021-01-05';
		$dataTable = $this->chart_model->get_data('',$start_date,$end_date);
		$data = array('area' => $area,'data' => $dataTable, 'area_id' => '','start_date' => $start_date, 'end_date' => $end_date);
		$this->load->view('welcome_message',$data, FALSE);
	}

	public function chart_data() {
		$area_id = $this->input->post('area_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$data = $this->chart_model->get_dataChart($area_id,$start_date,$end_date);
		echo json_encode($data);
	}

	public function filterdata(){
		$area_id = $this->input->post('select_area');
		// var_dump($area_id);
		$start_date = $this->input->post('start_date');
		// var_dump($start_date);
		$end_date = $this->input->post('end_date');
		// var_dump($end_date);
		$data = $this->chart_model->get_data($area_id,$start_date,$end_date);
		// var_dump($data);exit;

		$area =  $this->chart_model->select_area();
		$dataArr = array('area' => $area, 'data' => $data,'area_id' => $area_id, 'start_date' => $start_date, 'end_date' => $end_date);
		$this->load->view('welcome_message',$dataArr, FALSE);
	}


	
	

}
