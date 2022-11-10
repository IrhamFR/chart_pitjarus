<?php
class Chart_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function chart_database() {
        return  $this->db->get('product')->result();
    }

    public function select_area(){
		$this->db->select('*');
		$this->db->from('store_area');
		$this->db->order_by('area_id','asc');
		$query = $this->db->get();
		return $query->result();
	}

    public function get_dataChart($area_id,$start_date,$end_date){
        $this->db->select('store_area.area_name,
            SUM(report_product.compliance) / COUNT(report_product.compliance) * 100 as percent');
        $this->db->from('report_product');
        $this->db->join('product','product.product_id = report_product.product_id', 'left');
        $this->db->join('store','store.store_id = report_product.store_id', 'left');
        $this->db->join('product_brand','product_brand.brand_id = product.brand_id', 'left');
        $this->db->join('store_area','store_area.area_id = store.area_id', 'left');
        $this->db->where('report_product.tanggal >=', $start_date);
        $this->db->where('report_product.tanggal <=', $end_date);
        $this->db->like('store_area.area_id',$area_id);
        $this->db->group_by('store_area.area_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data($area_id,$start_date,$end_date){
        $this->db->select('product_brand.brand_name, store_area.area_name,
            SUM(report_product.compliance) / COUNT(report_product.compliance) * 100 as percent');
        $this->db->from('report_product');
        $this->db->join('product','product.product_id = report_product.product_id', 'left');
        $this->db->join('store','store.store_id = report_product.store_id', 'left');
        $this->db->join('product_brand','product_brand.brand_id = product.brand_id', 'left');
        $this->db->join('store_area','store_area.area_id = store.area_id', 'left');
        $this->db->where('report_product.tanggal >=', $start_date);
        $this->db->where('report_product.tanggal <=', $end_date);
        $this->db->like('product_brand.brand_id');
        $this->db->like('store_area.area_id',$area_id);
        $this->db->group_by('product_brand.brand_name');
        $this->db->group_by('store_area.area_id');
        $query = $this->db->get();
        print_r($query->result_Array());
        return $query->result_Array();
        // $this->db->get();
        // echo $this->db->last_query();die;
    }
}