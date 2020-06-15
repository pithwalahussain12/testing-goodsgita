<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {
  

    function login($userid,$password)
	{
		$this->db->where("Email",$userid);
		//$this->db->where("isActive",'1');
		$query=$this->db->get("tbl_partner_registration");
		if($query->num_rows()>0)
		{
			 $rows = $query->row();
	         $hashed_password = $rows->password;
	        // $adminAuth = $rows->isActive;
			//if($adminAuth == 1){
						if(password_verify($password, $hashed_password)) 
						{
							//add all data to session
							$newdata = array(
							'admin_id' 	=> $rows->id,
							'admin_name'    => $rows->Name,
							'admin_email'    => $rows->Email,
							'admin_logo'    => $rows->ProfilePic,
							'userType'    => 'partner',
							'logged_in' 	=> TRUE,
								   );
								$this->session->set_userdata($newdata);
								return true;  
						}
						else{
							return false;
							}
			// }else{
			// 	return '3';
			// }	
		}
			return false;
	}
	
    
/* ************* get all data as   *************** */	
	function get_all($table)
	{   
		$data = $this->db->get($table); 
		$get = $data->result();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}

/* ************* get all data as where class *************** */	
	function getwhere($table,$where)
	{
		$this->db->where($where);
		$data = $this->db->get($table);
		$get = $data->result();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}

       
/* ************* add  data *************** */
	function insert_data($table,$data)
	{ 
     	$this->db->insert($table,$data);
		$num = $this->db->insert_id();
			return $num;
	}


	function getAll_productsJoin($table,$id,$num,$offset) 
    { 
	    $this->db->select('*,product.status as status,product.id as pid,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, product.createDate as createDates, productsubcategory.description as descriptions,al.UN as merchantname');
		$this->db->from($table);
		$this->db->join('productcategory', $table.'.categoryId = productcategory.id');
		$this->db->join('productsubcategory', $table.'.subCategoryId = productsubcategory.id');
		$this->db->join('al', $table.'.merchantId = al.id');
		
		$this->db->order_by($id,'desc');
		$this->db->limit($num, $offset);
		$q = $this->db->get();
		
        $num_rows = $q->num_rows();
		if ($num_rows > 0)
        {
            foreach ($q->result() as $rows)
            {
                $data[] = $rows;
            }
            $q->free_result();
		
            return $data; 
			
        } 
		else
		{
			return false;
		}
    }
/* get all  products count */ 
	function getAll_products_count($table,$id)
	{
         $this->db->select('*,product.status as status,product.id as pid,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, product.createDate as createDates, productsubcategory.description as descriptions,al.UN as merchantname');
		$this->db->from($table);
		$this->db->join('productcategory', $table.'.categoryId = productcategory.id');
		$this->db->join('productsubcategory', $table.'.subCategoryId = productsubcategory.id');
		$this->db->join('al', $table.'.merchantId = al.id');
		
	    $q = $this->db->get(); 
		 $num_rows = $q->num_rows();
		if ($num_rows > 0)
        {
          
            return $num_rows; 
        } 
		else
		{
			return false;
		}
    }
	


/* ************* get single   data *************** */	
	function getSingle($table,$where)
	{
		$this->db->where($where);
		$data = $this->db->get($table);
		$get = $data->row();
	   
		$num = $data->num_rows();
		
		if($num){
			return $get;
		}
		else
		{
			return false;
		}
	}


/* ************* update  data *************** */	
	function update_data($table,$where,$data)
	{	
		 $this->db->where($where);
	     $update = $this->db->update($table,$data);
	 //echo $this->db->last_query(); die;
		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}
	
	
	
  }