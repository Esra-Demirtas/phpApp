<?php
class Product_model extends CI_Model
{
    public $tableName = "products";
    public function product_list(){
        parent::__construct();
    }

    public function get($where = array()){
        return $this->db->where($where)->get($this->tableName)->row();
    }

    /**Tüm kayıtları bana getirecek olan metod**/
    public function get_all(){

        return $this->db->get($this->tableName)->result();
    }
    public function add($data = array()){

        return $this->db->insert($this->tableName, $data);
    }

    public function update($where = array(), $data = array()){

        return $this->db->where($where)->update($this->tableName, $data);
    }
}