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
		$this->db->select('*,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, productsubcategory.description as descriptions');
		$this->db->from($table);
		$this->db->join('productcategory', 'productcategory.id = productsubcategory.catId');
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

/* ************* get single   data *************** */	
	function getSingle_product($table,$where,$field)
	{
		$this->db->select($field);
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
/* ************* get all data as where class *************** */     
    function getCount($table, $where) 
    { 
	    $this->db->where($where);
        $q = $this->db->get($table); 

			return $q->num_rows();

    }	
/* ************* Delete in data *************** */	
	function update_multiple($table,$where, $data, $id){
	    $this->db->where_in($id,$where);
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
	
/* ************* Delete data with images in folder *************** */	
	function delete_image($table,$where){
	
	    $this->db->where($where);
        $query = $this->db->get($table);
		foreach($query->result() as $row)
         {
          
  
		if($row->Product_image!='')
		    { 
             unlink("Product/".$row->Product_image);
			}
             
        }
		
		$this->db->where($where);
		$del = $this->db->delete($table);
		if($del){
			return true;
		}else{
			return false;
		}
	}
/* ************* get all data as where class *************** */     
    function getAll($table, $id) 
    { 
       $this->db->order_by($id,'asc');
        $data = $this->db->get($table); 
        $get = $data->result(); 
        if($get){ 
            return $get; 
        }else{ 
            return FALSE; 
        } 
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

/* ************* get all data as   *************** */	
	function get_allrow($table)
	{   
		$data = $this->db->get($table); 
		$get = $data->row();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}
	
/* ************* get all data as   *************** */	
	function get_all_selected($table,$field)
	{   
		$this->db->select($field);
		$data = $this->db->get($table); 
		$get = $data->result();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}		
    
/* ************* get all data as where class *************** */     
    function getById($table, $where) 
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
    
/* ************* get all data as where class *************** */     
    function getAllLimit($table, $id) 
    {
		$this->db->limit(1, 0);
		$this->db->order_by($id,'desc');
		
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
	    	
        
    
/* ************* get all data as where class *************** */     
    function getAllById($table, $id, $where, $num, $offset) 
    { 
		
		$this->db->where($where);
        $this->db->order_by($id,'desc');
        $q = $this->db->get($table,$num,$offset); 
     
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
           
    
/* ************* get all data as where class *************** */     
    function getCountById($table, $id, $where) 
    {
	    $this->db->where($where);
	    $this->db->order_by($id,'desc');
        $q = $this->db->get($table); 

        if($q->num_rows() > 0)
		{		 
			return $q->num_rows();		
		}		
		else
		{
		return false;	
		}
    }	        
 		
/* *************  count all data as where class *************** */     
    function getAll_num_rows($table) 
    { 
        $q = $this->db->get($table);    
        if($q->num_rows() > 0)
		{		 
			return $q->num_rows();		
		}		
		else
		{
		return false;	
		}
    } 
    /* ************* truncate data *************** */	
  function truncate($table)
  {
	   $del = $this->db->truncate($table);
		if($del){
			return true;
		}else{
			return false;
		}	
  }  
    
 /* *************  count all data as where class *************** */     
    function getAll_num_rows_where($table,$where) 
    { 
		$this->db->where($where); 
        $q = $this->db->get($table); 
   
        if($q->num_rows() > 0)
		{
		 
			return $q->num_rows();
		
		}
		
		else
		{
		return false;	
		}
 	}    
 	
 	/* ************* get all data as where class *************** */     
    function getAll_user($table,$id,$num,$offset, $var_serch,$var_new,$var_serch2) 
    {		
		if($var_new == 'search')
		{		  
			if($var_serch != '')
			{
				foreach ($var_serch as $key => $value)
				{      
					  if($value !='')
				      {
						$this->db->like("$key", "$value");
					  }
				}
			 }
		}
		if($var_serch2 != '')
		{
			foreach ($var_serch2 as $key => $value)
			{      
				  if($value !='')
				  {
					$this->db->where('('.USERS.'.first_name LIKE "%'.$value.'%" or  '.USERS.'.last_name LIKE "%'.$value.'%")');
				  }
			}
	    }
        $this->db->order_by($id,'desc');
        $q = $this->db->get($table,$num,$offset); 
     
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

	function Getall_user_count($table,$id, $var_serch,$var_new,$var_serch2)
	{	
		if($var_new == 'search')
		{		  
			if($var_serch != '')
			{
				foreach ($var_serch as $key => $value)
				{      
					  if($value !='')
				      {
						$this->db->like("$key", "$value");
					  }
				}
			 }
		}
		if($var_serch2 != '')
		{
			foreach ($var_serch2 as $key => $value)
			{      
				  if($value !='')
				  {
					$this->db->where('('.USERS.'.first_name LIKE "%'.$value.'%" or  '.USERS.'.last_name LIKE "%'.$value.'%")');
				  }
			}
	    }
		$this->db->order_by($id,'asc');
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
  /* ************* get all users data*************** */     
    function getAll_users($table,$id,$num,$offset) 
    { 
	    $this->db->where("userType",0);
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

/* get all  users count */ 
	function getAll_users_count($table,$id)
	{
        $this->db->where("userType",0);
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
	
	/* ************* get all merchants data*************** */     
    function getAll_merchants($table,$id,$num,$offset) 
    { 
	    $this->db->where("userType",2);
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
        $this->db->where("userType",2);
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
	
	/* ************* get all subcategory data*************** */     
    function getAll_subcategory($table,$id,$num,$offset) 
    { 
	    $this->db->select('*,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, productsubcategory.createDate as createDates, productsubcategory.description as descriptions');
		$this->db->from($table);
		$this->db->join('productcategory', 'productcategory.id = productsubcategory.catId');
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
	
	
/* ************* get all products data*************** */     
    function getAll_products($table,$id,$num,$offset) 
    { 
	    //$this->db->where("userType",1);
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
	
	
/* get all  products Merchant */ 
	function getAll_productsmerchantJoin($table,$id,$num,$offset,$where) 
    { 
	    $this->db->select('*,product.status as status,product.id as pid,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, product.createDate as createDates, productsubcategory.description as descriptions,al.UN as merchantname');
		$this->db->from($table);
		$this->db->join('productcategory', $table.'.categoryId = productcategory.id');
		$this->db->join('productsubcategory', $table.'.subCategoryId = productsubcategory.id');
		$this->db->join('al', $table.'.merchantId = al.id');

		$this->db->where($where);
		$this->db->order_by($id,'desc');
		$this->db->limit($num, $offset);
		$q = $this->db->get();
		
        $num_rows = $q->num_rows();
		
		//echo $this->db->last_query(); die;
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
/* get all  products Merchant count */ 
	function getAll_productsmerachant_count($table,$id,$where)
	{
	    $this->db->select('*,product.status as status,product.id as pid,productcategory.id as catid, productsubcategory.id as subcatid,productcategory.categoryname as categoryname, productsubcategory.subcatname as subcategoryname, product.createDate as createDates, productsubcategory.description as descriptions,al.UN as merchantname');
		$this->db->from($table);
		$this->db->join('productcategory', $table.'.categoryId = productcategory.id');
		$this->db->join('productsubcategory', $table.'.subCategoryId = productsubcategory.id');
		$this->db->join('al', $table.'.merchantId = al.id');
		$this->db->where($where); 
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
	
/* get all  products Merchant count */ 
	function getAll_oredrsmerachantonly_count($table,$id,$where)
	{
		$this->db->from($table);
		$this->db->where($where); 
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
	
  /* ************* get all Coupon data*************** */     
    function getAll_coupon($table,$id,$num,$offset) 
    { 	  
	    $this->db->select(COUPON.'.*,'.USERS.'.name');
		$this->db->from(COUPON);
        $this->db->join(USERS,''.USERS.'.id='.COUPON.'.userId');	
		
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

/* get all Coupon count */ 
	function getAll_coupon_count($table,$id)
	{      
	    $this->db->select(COUPON.'.*,'.USERS.'.name');
	    $this->db->from(COUPON);
        $this->db->join(USERS,''.USERS.'.id='.COUPON.'.userId');
		
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
/* ************* get all USER  *************** */	
	function get_all_user($table)
	{   
	    $this->db->where("userType",0);
		$data = $this->db->get($table); 
		$get = $data->result();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}
/* ************* get all merchant  *************** */	
	function get_all_merchant($table)
	{   
	    $this->db->where("userType",1);
		$data = $this->db->get($table); 
		$get = $data->result();
		if($get){
			return $get;
		}else{
			return FALSE;
		}
	}	
	
  /* ************* get all Order data*************** */     
    function getAll_orders($table,$id,$num,$offset) 
    { 	  
	    $this->db->select(ORDERS.'.*,'.USERS.'.name');
		$this->db->from(ORDERS);
        $this->db->join(USERS,''.USERS.'.id='.ORDERS.'.userId');	
		
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

/* get all Coupon count */ 
	function getAll_orders_count($table,$id)
	{      
	    $this->db->select(ORDERS.'.*,'.USERS.'.name');
		$this->db->from(ORDERS);
        $this->db->join(USERS,''.USERS.'.id='.ORDERS.'.userId');	
		
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
  /* ************* get all Order Detail data*************** */     
    function getAll_ordersdetail($table,$where,$id) 
    { 	  
	    $this->db->select(ORDERSDETAILS.'.*,'.PRODUCTS.'.productName,price,imageGallery');
		$this->db->from(ORDERSDETAILS);
		$this->db->join(ORDERS,''.ORDERSDETAILS.'.orderId='.ORDERS.'.orderId');	
        $this->db->join(PRODUCTS,''.PRODUCTS.'.id='.ORDERSDETAILS.'.productId');	
		
	    $this->db->order_by($id,'desc');
        $q = $this->db->get();
		//echo $this->db->last_query();
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
  /* ************* get all Order Detail data*************** */     
    function getAll_ordersmerchantdetail($table,$where,$id) 
    { 	  
	    $this->db->select(ORDERSDETAILS.'.*,'.PRODUCTS.'.productName,price,imageGallery');
		$this->db->from(ORDERSDETAILS);
		$this->db->join(ORDERS,''.ORDERSDETAILS.'.orderId='.ORDERS.'.orderId');	
        $this->db->join(PRODUCTS,''.PRODUCTS.'.id='.ORDERSDETAILS.'.productId');	

		$this->db->where($where); 
	    $this->db->order_by($id,'desc');
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

  /* ************* get all Order data*************** */     
    function getAll_ordersmerchant($table,$id,$num,$offset) 
    { 	  
	    $where = array('merchantId'=>$this->session->userdata('admin_id'));
	    $this->db->select(ORDERS.'.*,'.USERS.'.name');
		$this->db->from(ORDERS);
        $this->db->join(USERS,''.USERS.'.id='.ORDERS.'.userId');	
		
	    $this->db->order_by($id,'desc');
        $this->db->limit($num, $offset);
		
		$this->db->where($where);		
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

/* get all Coupon count */ 
	function getAll_ordersmerchant_count($table,$id)
	{      
	    $where = array('merchantId'=>$this->session->userdata('admin_id'));
	    $this->db->select(ORDERS.'.*,'.USERS.'.name');
		$this->db->from(ORDERS);
        $this->db->join(USERS,''.USERS.'.id='.ORDERS.'.userId');		
		$this->db->where($where); 
		
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

	function getAll_sliderJoin($table,$id,$num,$offset) 
    { 
	    $this->db->select('*');
		$this->db->from($table);
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
	function getAll_slider_count($table,$id)
	{
         $this->db->select('*');
		$this->db->from($table);
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


}
?>
