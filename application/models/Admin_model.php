<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model {
    
    function login($userid,$password)
	{
		$this->db->where("EI",$userid);
		$this->db->where("isActive",'1');
		$query=$this->db->get("al");
		if($query->num_rows()>0)
		{
			 $rows = $query->row();
	         $hashed_password = $rows->UP;
	        // $adminAuth = $rows->isActive;
			//if($adminAuth == 1){
						if(password_verify($password, $hashed_password)) 
						{
							//add all data to session
							$newdata = array(
							'admin_id' 	=> $rows->id,
							'admin_name'    => $rows->UN,
							'admin_email'    => $rows->EI,
							'admin_logo'    => $rows->logoimg,
							'userType'    => $rows->userType,
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
	
    function check_email($table, $where)
	{
		$this->db->where($where); 
		$query = $this->db->get($table);			
		return $query->result();
	}
		
    function change_password($table, $where, $data)
	{

	$this->db->where($where);
	 return $this->db->update($table, $data);
		  
	}
	
/* ************* code availiblity *************** */         		
	public function check_code($table, $where)
	{
		$this->db->where($where); 
		$query = $this->db->get($table);			
		return $query->result();		
		}  		    
       
/* ************* add  data *************** */
	function insert_data($table,$data)
	{ 
	
     	$this->db->insert($table,$data);
		$num = $this->db->insert_id();
			return $num;
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
	
	
/* ************* update  data All*************** */	
	function update_data_all($table,$data)
	{
	     $update = $this->db->update($table,$data);
		
			if($update)
			{ 
				return TRUE;
			}
			else
			{ 
				return FALSE;
			}
	}

/* ************* get all category data*************** */     
    function getAll_category($table,$id,$num,$offset) 
    { 
	    //$this->db->where("userType",0);
	    $this->db->order_by($id,'desc');
        $this->db->limit($num, $offset);
        $q = $this->db->get($table); 
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

/* get all  category count */ 
	function getAll_category_count($table,$id)
	{
        //$this->db->where("userType",0);
	    $q = $this->db->get($table); 
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

/* ************* Delete data *************** */	
	function delete($table,$where){
	
	    $this->db->where($where);
		$del = $this->db->delete($table);
		if($del){
			return true;
		}else{
			return false;
		}
	}
	
/* ************* Delete in data *************** */	
	function delete_multipal($table,$where, $id){
	    $this->db->where_in($id,$where);
		$del = $this->db->delete($table);
		if($del){
			return true;
		}else{
			return false;
		}
	}	

    function getAll_subcategory($table,$id,$num,$offset) 
    { 
	    $this->db->select('*,tbl_category.id as catid, tbl_subcategory.id as subcatid,tbl_category.categoryName as categoryname, tbl_subcategory.subcatName as subcategoryname, tbl_subcategory.createDate as createDates, tbl_subcategory.description as descriptions');
		$this->db->from($table);
		$this->db->join('tbl_category', 'tbl_category.id = tbl_subcategory.catId');
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

/* get all  subcategory count */ 
	function getAll_subcategory_count($table,$id)
	{
        //$this->db->where("userType",0);
	    $q = $this->db->get($table); 
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
    function getSingleJoin($table,$where)
	{
		$this->db->select('*,tbl_category.id as catid, tbl_subcategory.id as subcatid,tbl_category.categoryname as categoryname, tbl_subcategory.subcatname as subcategoryname, tbl_subcategory.description as descriptions');
		$this->db->from($table);
		$this->db->join('tbl_category', 'tbl_category.id = tbl_subcategory.catId');
		$this->db->where($where);
		$data = $this->db->get();
		/*$this->db->join('category', 'category.id = subcategory.catId');
		$this->db->where($where);
		$data = $this->db->get($table);*/
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


	/* ************* get all merchants data*************** */     
    function getAll_merchants($table,$id,$num,$offset) 
    { 
	    $this->db->where("isActive",1);
	    $this->db->order_by($id,'desc');
        $this->db->limit($num, $offset);
        $q = $this->db->get($table); 
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

/* get all  merchants count */ 
	function getAll_merchants_count($table,$id)
	{
        $this->db->where("isActive",1);
	    $q = $this->db->get($table); 
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


}
