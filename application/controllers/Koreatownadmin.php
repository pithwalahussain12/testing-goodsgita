<?php
class Koreatownadmin extends CI_Controller {

    function __construct() 
    {
			parent::__construct();
			
			$this->load->model('Admin_model','',TRUE);
			$this->load->library('pagination');
    }
   function _chk_if_login()
	{
		if($this->session->userdata('logged_in') == false && $this->session->userdata('admin_id') == '')
			{
			$array_items = array('admin_id' =>'', 'admin_email' =>'','logged_in' =>false);

            $this->session->unset_userdata($array_items);
			  redirect('koreatown-administrator/index');
				exit();   
			
			}
	}
/*check user login or not  Start*/
	public function index()
	{
			if(($this->session->userdata('admin_id')!=""))
			{
				$this->home();
			}
			else{
				$this->load->view("admin/login");

			}
	}
/*check user login or not  End*/
/*login for  user  Start*/
	public function login()
	{
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('userid', 'User Name', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$userid=$this->input->post('userid',true);
			$password=$this->input->post('password',true);
			$remember=$this->input->post('remember_me',true);
			$this->load->helper('cookie');
		
			if($remember == 1)
			{
				$cookie_email = array(
						'name'   => 'userid_ad',
						'value'  => $userid,
						'expire' => time()+60, // 1min
						);
				$cookie_password = array(
						'name'   => 'password_ad',
						'value'  => $this->input->post('password'),
						'expire' => time()+60, // 1min
						);

				$this->input->set_cookie($cookie_email);
				$this->input->set_cookie($cookie_password);

			}
			else
			{
				delete_cookie("userid_ad");
				delete_cookie("password_ad");				
				
			}
				$result=$this->Admin_model->login($userid,$password);
				
			if($result == '3') 
			{
				$this->session->set_flashdata('message','<span style="color:red;">Your  Not Authountication Provided By Admin ! Contact To Admin</span>');
				redirect('koreatown-administrator');
			}				
			else if($result) 
			{
				redirect('koreatown-administrator/home');
			}			
			else
			{
				$this->session->set_flashdata('message','<span style="color:red;">Your username or password is incorrect</span>');
				redirect('koreatown-administrator');
			}
		 }
	   else{
			$this->load->view('admin/login');
		   }
	}	
/*login for  user  End*/
/*logout for  user  start*/
	public function logout()
	{				
			$newdata = array(
				'admin_id' 	=>'',
				'admin_name'    => '',
				'admin_email'    => '',
				'admin_logo'    => '',
				'userType'    => '',
				'logged_in' 	=> false,
			);
			
			
			$this->session->unset_userdata($newdata);
			
			redirect('koreatown-administrator');
	}
/*logout for  user  End*/	

/* ****  view change password page **** */
    public function change_password()
	 {	
				$this->_chk_if_login();
				$this->load->view('admin/changepassword');
	 }

 /* ****  view Change Logo page **** */
    public function changelogo()
	 {	
			$this->_chk_if_login();
			$where = array('id'=>$this->session->userdata('admin_id'));
	       $config['edit_data'] = $this->Admin_model->getSingle(ADMIN,$where);
		
			$this->load->view('admin/changelogo',$config);
	 }

  /*function for edit Logo Start*/
    function changelogoaction()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			   /* upload image in folder start*/
					$header_image='';
					$content_image = '';
					$header_image = $_FILES['logoimg']['name'];
					  
					 if($header_image !='')
					 {
						 $config['upload_path'] = './uploads/logoimg';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload', $config);
					 
							if ( ! $this->upload->do_upload('logoimg'))
							{
								$error = array('error' => $this->upload->display_errors());
								
								 $this->session->set_flashdata('err_login',$error['error']);
								
								  redirect('koreatown-administrator'); 
								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$content_image = $this->upload->file_name; 
								unlink("uploads/logoimg/".$this->input->post('old_image',TRUE));
															
							}
							
					  }
					  else
					  {
						 $content_image =$this->input->post('old_image',TRUE);
						  
					  }	
								    
			     $update_data = array
					             (
								    	'logoimg' => $content_image,
								 );								  
			      $id = $this->session->userdata('admin_id');
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(ADMIN,$where,$update_data);	
				  $newdata = array(				
				  'admin_logo' =>$content_image,				
					   );
				  $this->session->set_userdata($newdata);
				  redirect('koreatown-administrator'); 
		}
	}
/* ****  view Action change password page **** */
	public function change_psw_action()
	{    
		  if($_POST)
		  {
				$oldpassword=$this->input->post('current_password',true);
				
				$psw_match=array('EI'=>$this->session->userdata('admin_email',true));
				$match_data= $this->Admin_model->getSingle('al',$psw_match);
				
				$hashed_password = $match_data->UP;
				
			    if(password_verify($oldpassword, $hashed_password)) 
			    {	
					  $new_password = $this->input->post('new_password');
				      $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
				      
					  $where= array('EI '=>$this->session->userdata('admin_email',true));
					  $data=array('UP' => $new_password_hashed,'SUP' => $new_password);	
					  $update = $this->Admin_model->update_data('al',$where,$data);
					
					redirect('koreatown-administrator/logout');	
				 }
				 else
				 {			  
				   $this->session->set_flashdata('err_man','<div style="color: #F60303;font-size: 13px;font-weight: bold;margin-left: -105px;margin-top: -41px;text-align: center;" id="error_msg">Please Insert Correct Current Password.</div>');
				   redirect('koreatown-administrator/change_password');
				 }
		  }
		   			  
       }

/*function for show property Welcome Start*/
	public function home()
	{	
		$this->_chk_if_login();
		// $config['total_merchants'] = $this->Admin_model->getAll_merchants_count(ADMIN,'id');
		// $config['total_users'] = $this->Admin_model->getAll_users_count(USERS,'id');
		// $config['total_products'] = $this->Admin_model->getAll_products_count(PRODUCTS,'product.id');
		
		// $merchantid = $this->session->userdata('admin_id');
	 //    $where = array('merchantId'=>$merchantid);
		// $config['total_productmerchant'] = $this->Admin_model->getAll_productsmerachant_count(PRODUCTS,'product.id',$where);
		
		// $where = array('merchantId'=>$merchantid);
		// $config['total_merchantproducts'] = $this->Admin_model->getAll_oredrsmerachantonly_count(ORDERS,'product.id',$where);
		
  //       //$config['total_users'] = $this->Admin_model->getAll_num_rows(USERS);
		// $config['total_orders'] = $this->Admin_model->getAll_num_rows(ORDERS);
		

	//	$this->load->view('admin/index',$config);

		$this->load->view('admin/index');
	}


/*function for show all category start*/
	public function All_category()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allcategory');
	}
    public function Category()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allcategory');
	}
    /* function for get all category */
    public function get_category($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_category/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_category(CATEGORY,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_category_count(CATEGORY,'id');
		 
		 if($config['total_rows'] > 0)
         {
				 $count_min =($config['total_rows'] - $start);
				 
				   if($count_min  >= $config['per_page'])
				   {
					   $end = $config['per_page'];
				   }else{
						$end =$count_min;
						}
				 $data['searchall_data'][]='<table class="table table-bordered">
											<tr>
											    <th>S.No.</th>
											    <th>Name</th>
												<th>Description</th>
												<th>Create Date</th>
												<th>Image</th>
												<th>Status</th>					                            
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->categoryName.'</td>
					                                 <td>'.$data_paging[$i]->description.'</td>
					                                 <td>'.$data_paging[$i]->createDate.'</td>
					                                 <td><img src="'.base_url().'uploads/categoryimg/'.$data_paging[$i]->category_img.'" width="50" height="50"></td>          
					                                  </td>';
					                                
					                           	           
					                if($data_paging[$i]->status == 0){     	                                
					                    $data['searchall_data'][].='<td>
													    <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_category/'.$data_paging[$i]->id.'/'.$data_paging[$i]->status.'/"><i class=""></i>Active</a>
												     </td>'; 
									}else{
										$data['searchall_data'][].='<td>
													   <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_category/'.$data_paging[$i]->id.'/'.$data_paging[$i]->status.'/"><i class=""></i>Deactive</a>
												     </td>';
									}

										$data['searchall_data'][].='<td>                      
													    <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/select_category_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_category('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>';

					                     $j++;  
			      }
			      
			      $data['searchall_data'][].='</table>';
			       
         
				  $data['totaldata'] =$config['total_rows'];
				  $this->ajaxpagination->initialize($config);
				  $data['pagination'] = $this->ajaxpagination->create_links();
				  $arr = json_encode($data);
				    
			 }
			 else{
				  $data['totaldata'] =0;
				  $data['pagination'] ='';
				  $data['searchall_data'] ='';
				  $arr = json_encode($data);
				 
				 }
		  print_r($arr);
          exit;
	}
	/*function for add category record Start*/
    function add_category()
    {   
		$this->_chk_if_login();
		if($_POST)
		{

/* upload image in folder start*/
                     $content_image ="";
					 $header_image1 = $_FILES['categoryimage']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/categoryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('categoryimage'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/All_category'); 
								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$content_image = $this->upload->file_name; 								
							}							
					  }						  
			 /* upload image in folder End*/

			    	$insert_data = array
					             (
					                    'description' => $this->input->post('description',true),
										'categoryName' => $this->input->post('categoryname',true),
										'category_img' => $content_image,
										'createDate' =>date('Y-m-d H:i:s'),
										'isActive' => 0,
								  );
								  
					  
				  $update = $this->Admin_model->insert_data(CATEGORY,$insert_data);	
				  redirect('koreatown-administrator/All_category'); 
		}else{
			$this->load->view('admin/add_category'); 
			
			 }
	}
	/* ************* Delete category data ************ */ 
	public function delete_category()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 
	 $categorydata = $this->Admin_model->getSingle(CATEGORY,$where);
	 unlink("uploads/categoryimg/".$categorydata->category_img);
	 
	 $this->Admin_model->delete(CATEGORY,$where);
	 
	 
	 redirect('koreatown-administrator/All_category');	 
	
	  
	}



	/*----------------Activate  Caategory  -------------------------------------------------*/
	function activate_category()
    {
		$this->_chk_if_login();
		$id=$this->uri->segment(3);
		$status=$this->uri->segment(4);
		if($id != null)
		{
			if($status != 1)
			{
			$update_data = array('status' => 1);	
			}else{
			$update_data = array('status' => 0);	
			}
			$where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(CATEGORY,$where,$update_data);	
				  //echo $update;die();
				   redirect('koreatown-administrator/Category'); 
		}
	}


	/* ************* Select category  for edit start ************ */ 	
   function select_category_edit()
   {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);
	
	   $where = array('id'=>$id);
	   $config['edit_data'] = $this->Admin_model->getSingle(CATEGORY,$where);
	   $this->load->view('admin/edit_category',$config); 
	   
  }	
/* ************* Select category for edit End ************ */ 	
/*function for edit category  Start*/
    function update_category()
    {
		$this->_chk_if_login();
		if($_POST)
		{

             /* upload image in folder start*/
					 $header_image1 = $_FILES['categoryimage']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/categoryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('categoryimage'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/All_category'); 								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$content_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $content_image =$this->input->post('old_image',TRUE);						  
					  }
			 /* upload image in folder End*/

			    $update_data = array
					             (
					                    'description' => $this->input->post('description',true),
										'categoryName' => $this->input->post('categoryname',true),
										'category_img' => $content_image,
										'updateDate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(CATEGORY,$where,$update_data);	
				   redirect('koreatown-administrator/All_category'); 
		}
	}
/*function for edit category End*/

/*function for show all subcategory start*/
	public function All_subcategory()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allsubcategory');
	}
	
    public function Subcategory()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allsubcategory');
	}
	
    /* function for get all subcategory */
    public function get_subcategory($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_subcategory/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_subcategory(SUBCATEGORY,'tbl_subcategory.id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_subcategory_count(SUBCATEGORY,'tbl_subcategory.id');
		 
		 if($config['total_rows'] > 0)
         {
				 $count_min =($config['total_rows'] - $start);
				 
				   if($count_min  >= $config['per_page'])
				   {
					   $end = $config['per_page'];
				   }else{
						$end =$count_min;
						}
				 $data['searchall_data'][]='<table class="table table-bordered">
											<tr>
											    <th>S.No.</th>
											    <th>Category-Name</th>
											    <th>Subcategory Name</th>
												<th>Description</th>
												<th>Create Date</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->categoryname.'</td>
					                                 <td>'.$data_paging[$i]->subcategoryname.'</td>
					                                 <td>'.$data_paging[$i]->descriptions.'</td>
					                                 <td>'.$data_paging[$i]->createDates.'</td>
					                                 </td>';
					                                
					                if($data_paging[$i]->status == 0){     	                                
					                    $data['searchall_data'][].='<td>				                                  
													    
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/select_subcategory_edit/'.$data_paging[$i]->subcatid.'/"><i class="fa fa-pencil"></i></a> 
													     <a class="btn btn-danger" onclick="delete_subcategory('.$data_paging[$i]->subcatid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>'; 
									}else{
										$data['searchall_data'][].='<td>				                                  
													   
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/select_subcategory_edit/'.$data_paging[$i]->subcatid.'/"><i class="fa fa-pencil"></i></a> 
													     <a class="btn btn-danger" onclick="delete_subcategory('.$data_paging[$i]->subcatid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>';
					                           	    
					                     $j++;  
					                 }
			      }
			      
			      $data['searchall_data'][].='</table>';
			       
         
				  $data['totaldata'] =$config['total_rows'];
				  $this->ajaxpagination->initialize($config);
				  $data['pagination'] = $this->ajaxpagination->create_links();
				  $arr = json_encode($data);				    
			 }
			 else{
				  $data['totaldata'] =0;
				  $data['pagination'] ='';
				  $data['searchall_data'] ='';
				  $arr = json_encode($data);
				 
				 }
		  print_r($arr);
          exit;
	}
	
	/*function for add subcategory record Start*/
    function add_subcategory()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			    	$insert_data = array
					             (
					                    'description' => $this->input->post('description',true),
										'subcatName' => $this->input->post('subcatname',true),
										'catId' => $this->input->post('catid',true),
										'createDate' =>date('Y-m-d H:i:s'),
										'isActive' => 0,
								  );
								  
					  
				  $update = $this->Admin_model->insert_data(SUBCATEGORY,$insert_data);	
				  redirect('koreatown-administrator/All_subcategory'); 
		}else{
			 $config['cat'] = $this->Admin_model->getAll_category(CATEGORY,'id',100,0);
			$this->load->view('admin/add_subcategory',$config); 
			
			 }
	}
	/* ************* Delete subcategory data ************ */ 
	public function delete_subcategory()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 
	 $subcategorydata = $this->Admin_model->getSingle(SUBCATEGORY,$where);
	 unlink("uploads/categorys/".$subcategorydata->subcategoryimage);
	 
	 $this->Admin_model->delete(SUBCATEGORY,$where);
	 
	 
	 redirect('koreatown-administrator/All_subcategory');	 
	
	  
	}
	/* ************* Select subcategory  for edit start ************ */ 	
   function select_subcategory_edit()
   {
	   $this->_chk_if_login();
	   $subcatid=$this->uri->segment(3);
	
	   $where = array('tbl_subcategory.id'=>$subcatid);
	    $config['cat'] = $this->Admin_model->getAll_category(CATEGORY,'id',100,0);
	   $config['edit_data'] = $this->Admin_model->getSingleJoin(SUBCATEGORY,$where);
	   //print_r($config);die();
	   $this->load->view('admin/edit_subcategory',$config); 
	   
  }	
/* ************* Select subcategory for edit End ************ */ 	
/*function for edit subcategory  Start*/
    function update_subcategory()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			    $update_data = array
					             (
					                    'description' => $this->input->post('description',true),
										'subcatName' => $this->input->post('subcategoryname',true),
										'catId' => $this->input->post('catid',true),
										'updateDate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(SUBCATEGORY,$where,$update_data);	
				   redirect('koreatown-administrator/All_subcategory'); 
		}
	}


  /*function for MerchantList  Start*/

	public function PartenrList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allmerchants');
	}
	/* function for View Add MerchantList */	
    public function add_merchant()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/add_merchant');
	}	
   /* function for Add MerchantList */	
    function add_marchantaction()
    {
		$this->_chk_if_login();
		if($_POST){
			
            $where=array('EI' => $this->input->post('email',true));
			$result= $this->Admin_model->getCount(ADMIN,$where);
			
			$where1=array('UN' => $this->input->post('name',true));
			$result2= $this->Admin_model->getCount(ADMIN,$where1);
			
			if($result > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your Email Already Exist</div>');
				redirect('koreatown-administrator/add_merchant/'.$id); 				
			}else if($result2 > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your User Name Already Exist</div>');
				redirect('koreatown-administrator/add_merchant/'.$id); 				
			}else{						
		          $new_password = password_hash($this->input->post('password',true), PASSWORD_DEFAULT);
				  
				  $insert_data = array
					             (		
										'UN' => $this->input->post('name',true),
										'EI' => $this->input->post('email',true),
										'contactNumber' => $this->input->post('contact',true),
										'SUP' => $this->input->post('password',true),
										'UP' => $new_password,
										'userType' => 2,
										'isSocialLogin' => 0,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
				  $update = $this->Admin_model->insert_data(ADMIN,$insert_data);	
				  redirect('koreatown-administrator/MerchantList'); 
		 }
		}else{
			$config['select_data'] = $this->Admin_model->get_all(ADMIN);
			$this->load->view('admin/add_merchant',$config); 			
			 }
	}
	
	/* ************* Delete MerchantList data ************ */ 
	public function delete_merchants()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(ADMIN,$where);
	 redirect('koreatown-administrator/MerchantList');
	}	
	/* ************* Select MerchantList edit ************ */ 	
	
    function merchant_edit()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   $config['edit_data'] = $this->Admin_model->getSingle(ADMIN,$where);			
	   $this->load->view('admin/merchant_edit',$config); 
    }
  /*function for edit MerchantList  Start*/
    function update_merchant()
    {
		$this->_chk_if_login();
		if($_POST)
		{ 		  
			$id = $this->uri->segment(3);
            $where=array('EI' => $this->input->post('email',true),'id !='=> $id );
			$result= $this->Admin_model->getCount(ADMIN,$where);
			
			$where1=array('UN' => $this->input->post('name',true),'id !='=> $id );
			$result2= $this->Admin_model->getCount(ADMIN,$where1);
			
			if($result > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your Email Already Exist</div>');
				redirect('koreatown-administrator/merchant_edit/'.$id); 				
			}else if($result2 > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your User Name Already Exist</div>');
				redirect('koreatown-administrator/merchant_edit/'.$id); 				
			}else{
	             $new_password = password_hash($this->input->post('password',true), PASSWORD_DEFAULT);
				 
			     $update_data = array
					             (		
								        'UN' => $this->input->post('name',true),
										'EI' => $this->input->post('email',true),
										'contactNumber' => $this->input->post('contact',true),
										'SUP' => $this->input->post('password',true),
										'UP' => $new_password,
										'userType' => 2,
										'isSocialLogin' => 0,
										'createDate' =>date('Y-m-d H:i:s'),										
								  );			
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(ADMIN,$where,$update_data);	
				  redirect('koreatown-administrator/MerchantList'); 
			}	  
		}
	}
	
  /* End edit MerchantList  Start*/		
	
	function view_merchants()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);
	
	   $where = array('id'=>$id,'userType'=>2);
	   $config['edit_data'] = $this->Admin_model->getSingle(ADMIN,$where);
	   $this->load->view('admin/view_merchant',$config);
    }
	/* function for get all merchant */
    public function get_merchants($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_merchants/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_merchants(PARTNER,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_merchants_count(PARTNER,'id');
		 
		 if($config['total_rows'] > 0)
         {
				 $count_min =($config['total_rows'] - $start);
				 
				   if($count_min  >= $config['per_page'])
				   {
					   $end = $config['per_page'];
				   }else
				   {
					   $end =$count_min;
				   }
				 $data['searchall_data'][]='<table class="table table-bordered">
											<tr>
											    <th>S.No.</th>
											    <th>Name</th>
												<th>Email</th>
												<th>ContactNo.</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->Name.'</td>
					                                 <td>'.$data_paging[$i]->Email.'</td>
					                                 <td>'.$data_paging[$i]->Mobile.'</td>
					                                 				                            
					                                  </td>';
					                                
					                if($data_paging[$i]->isActive == 1){                           
					                    
										$data['searchall_data'][].='<td>				                                  
													   <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_merchants/'.$data_paging[$i]->id.'/0" title="click here to deactive"><i class=""></i>Active</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/merchant_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_merchants('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>';
									}else{
										$data['searchall_data'][].='<td>				                                  
													    <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_merchants/'.$data_paging[$i]->id.'/1" title="click here to active"><i class=""></i>Deactive</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/merchant_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_merchants('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>'; 										
									}
					                     $j++;  
			      }
			      
			      $data['searchall_data'][].='</table>';
			       
         
				  $data['totaldata'] =$config['total_rows'];
				  $this->ajaxpagination->initialize($config);
				  $data['pagination'] = $this->ajaxpagination->create_links();
				  $arr = json_encode($data);
				    
			 }
			 else{
				  $data['totaldata'] =0;
				  $data['pagination'] ='';
				  $data['searchall_data'] ='';
				  $arr = json_encode($data);
				 
				 }
		  print_r($arr);
          exit;
	}
	/*----------------Activate Users-------------------------------------------------*/
	function activate_users()
    {
		$this->_chk_if_login();
		$id=$this->uri->segment(3);
		$isActive1=$this->uri->segment(4);
			$update_data = array('isActive' => $isActive1);	
			$where = array('id'=> $id);
			$update = $this->Admin_model->update_data(USERS,$where,$update_data);	
			redirect('koreatown-administrator/UserList'); 
	}
	
	function activate_merchants()
    {
		$this->_chk_if_login();
		$id=$this->uri->segment(3);
	    $isActive1=$this->uri->segment(4);
	
			$update_data = array('isActive' => $isActive1);	
			$where = array('id'=> $id);
			$update = $this->Admin_model->update_data(ADMIN,$where,$update_data);	
			redirect('koreatown-administrator/MerchantList'); 
		
	}	

}