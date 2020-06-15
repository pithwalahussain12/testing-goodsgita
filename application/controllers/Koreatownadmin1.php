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
		$config['total_merchants'] = $this->Admin_model->getAll_merchants_count(ADMIN,'id');
		$config['total_users'] = $this->Admin_model->getAll_users_count(USERS,'id');
		$config['total_products'] = $this->Admin_model->getAll_products_count(PRODUCTS,'product.id');
		
		$merchantid = $this->session->userdata('admin_id');
	    $where = array('merchantId'=>$merchantid);
		$config['total_productmerchant'] = $this->Admin_model->getAll_productsmerachant_count(PRODUCTS,'product.id',$where);
		
		$where = array('merchantId'=>$merchantid);
		$config['total_merchantproducts'] = $this->Admin_model->getAll_oredrsmerachantonly_count(ORDERS,'product.id',$where);
		
        //$config['total_users'] = $this->Admin_model->getAll_num_rows(USERS);
		$config['total_orders'] = $this->Admin_model->getAll_num_rows(ORDERS);
		

		$this->load->view('admin/index',$config);
	}	
/*function for show property  End*/	
	public function random_string($length) 
	{
	$key = '';
	$keys = array_merge(range(0, 9), range('a', 'z'));

	for ($i = 0; $i < $length; $i++) {
	$key .= $keys[array_rand($keys)];
	}
	return $key;
	}	
	
	public function forgot_password()
	{
	$this->load->view('admin/forgot_password.php');
	}
	public function send_password()
	{

		$email = $this->input->post('email',true);
		
		$where = array('EI'=> $email);
		
		$result = $this->Admin_model->check_email('al', $where);
	
		if($result)
		{
			$email = $this->input->post('email');
			$password = $this->random_string('8');
		    $new_password = password_hash($password, PASSWORD_DEFAULT);
			
			$where1 = array('EI'=> $email);
			$data = array(
			'UP'=>$new_password
			);
			
			$this->Admin_model->change_password('al', $where1, $data);
			
			//send updated passsword to user email id
            $this->load->library('email');
			$this->load->helper('html');
			
			$message='';	
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);	
			
			$this->email->from('info@techdiligents.com','Korea Town');
			$this->email->to($email);
			$this->email->subject('Korea Town Recycle-Reset Password');
			
			$message.= 'Dear '.$email. ',';
			$message.= br(2);
			$message.= 'Your New password is : '.$password;
			
			$message.= br(2);
			$message.= 'Thanks';
			
			$this->email->message($message); 

			$this->email->send();
			//-------------------------------------------
			$this->load->view('admin/confirm_password');
		}
		else
		{
		   $this->session->set_flashdata('message','<span style="color:#F60303;font-size:15px;">Please Insert correct Email Id</span>');
		   redirect('koreatown-administrator/forgot_password');	
		}
	
	}
	public function change_user()
	{
		$this->_chk_if_login();
		
		$where = array('id'=>$this->session->userdata('admin_id'));
		$config['edit_data'] = $this->Admin_model->getSingle('al', $where);
		
		
		$this->load->view('admin/changeUsername', $config);
	}	
		  
		  
	public function change_username()
	{
		$this->_chk_if_login();
		
	    	$id = $this->session->userdata('admin_id');
					
            $where=array('EI' => $this->input->post('email_id',true),'id !='=> $id );
			$result= $this->Admin_model->getCount(ADMIN,$where);
			
			$where1=array('UN' => $this->input->post('user_name',true),'id !='=> $id );
			$result2= $this->Admin_model->getCount(ADMIN,$where1);
			
			if($result > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your Email Already Exist</div>');
				redirect('koreatown-administrator/change_user/'.$id); 				
			}else if($result2 > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your User Name Already Exist</div>');
				redirect('koreatown-administrator/change_user/'.$id); 				
			}else{
		
		
		$where = array('id'=>$id);
		
		$data = array(
		'UN'=>$this->input->post('user_name'),
		'EI'=>$this->input->post('email_id'),
		);
		$this->Admin_model->update_data('al', $where, $data);
		
			$newdata = array(
				'admin_name'    =>$this->input->post('user_name',true),
				'admin_email'    =>$this->input->post('email_id',true),
					   );
					$this->session->set_userdata($newdata);
		
		$this->session->set_flashdata('succ_user','<span style="color:#008000;font-size:15px;">User details have been updated successfully<br/></span>');
		redirect('koreatown-administrator/change_user');	
	  }
	}
		
	/*function for show all Users start*/
	public function UserList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allusers');
	}
    public function AllUsers()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allusers');
	}
	
    public function add_users()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/add_user');
	}
   /* function for Add User */
	
    function add_usersaction()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			$where=array('EI' => $this->input->post('email',true));
			$result= $this->Admin_model->getCount(ADMIN,$where);
			
			$where1=array('UN' => $this->input->post('name',true));
			$result2= $this->Admin_model->getCount(ADMIN,$where1);
			
			if($result > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your Email Already Exist</div>');
				redirect('koreatown-administrator/add_users/'); 				
			}else if($result2 > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your User Name Already Exist</div>');
				redirect('koreatown-administrator/add_users/'); 				
			}else{
				  $insert_data = array
					             (		
										'name' => $this->input->post('name',true),
										'email' => $this->input->post('email',true),
										'contactNumber' => $this->input->post('contact',true),
										'password' => $this->input->post('password',true),
										'userType' => 0,
										'isSocialLogin' => 0,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
								  
				  $update = $this->Admin_model->insert_data(USERS,$insert_data);	
				  redirect('koreatown-administrator/UserList'); 
		 } 
		}else{
			$config['select_data'] = $this->Admin_model->get_all(USERS);
			
			$this->load->view('admin/add_usersaction',$config); 			
			 }
	}
	
	/* function for get all users */
    public function get_users($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_users/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_users(USERS,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_users_count(USERS,'id');
		 
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
												<th>Email</th>
												<th>ContactNo.</th>
												<th>CreateDate</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->name.'</td>
					                                 <td>'.$data_paging[$i]->email.'</td>
					                                 <td>'.$data_paging[$i]->contactNumber.'</td>
					                                 <td>'.$data_paging[$i]->createDate.'</td>
					                                 				                            
					                                  </td>';
					                                
					                if($data_paging[$i]->isActive == 1){     	                                
					                    $data['searchall_data'][].='<td>				                                  
													    <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_users/'.$data_paging[$i]->id.'/0/" title="click here to deactive"><i class=""></i>Active</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/edit_user/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_users('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>'; 
									}else{
										$data['searchall_data'][].='<td>				                                  
													   <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_users/'.$data_paging[$i]->id.'/1/" title="click here to activeiew_merchants"><i class=""></i>Deactive</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/edit_user/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_users('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
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
	
	/* ************* Delete User data ************ */ 
	public function delete_users()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(USERS,$where);
	 redirect('koreatown-administrator/UserList');
	}	
	/* ************* Select User edit ************ */ 	
	
    function edit_user()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   $config['edit_data'] = $this->Admin_model->getSingle(USERS,$where);			
	   $this->load->view('admin/users_edit',$config); 
    }	
  /*function for edit User  Start*/
    function update_user()
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
				redirect('koreatown-administrator/edit_user/'.$id); 				
			}else if($result2 > 0){
				$this->session->set_flashdata('message','<div class="alert alert-danger">  <strong>Oof!</strong> Your User Name Already Exist</div>');
				redirect('koreatown-administrator/edit_user/'.$id); 				
			}else{
			     $update_data = array
					             (		
								        'name' => $this->input->post('name',true),
										'email' => $this->input->post('email',true),
										'contactNumber' => $this->input->post('contact',true),
										'password' => $this->input->post('password',true),									
										'updateDate' =>date('Y-m-d H:i:s'),
								  );
								  
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(USERS,$where,$update_data);	
				  redirect('koreatown-administrator/UserList'); 
			}
		}
	}
  /*function for MerchantList  Start*/
	public function MerchantList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allmerchants');
	}	
	public function AllMerchants()
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
	     
	     $data_paging = $this->Admin_model->getAll_merchants(ADMIN,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_merchants_count(ADMIN,'id');
		 
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
												<th>CreateDate</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->UN.'</td>
					                                 <td>'.$data_paging[$i]->EI.'</td>
					                                 <td>'.$data_paging[$i]->contactNumber.'</td>
					                                 <td>'.$data_paging[$i]->createDate.'</td>
					                                 				                            
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

	/*-----------------------------------------------------------------*/
	/* ************* Select users  for edit start ************ */ 	
   function select_users_edit()
   {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);
	
	   $where = array('id'=>$id);
	   $config['edit_data'] = $this->Admin_model->getSingle(USERS,$where);
	 
		$this->load->view('admin/edit_users',$config); 
	   
  }	
/* ************* Select users for edit End ************ */ 	
/*function for edit users  Start*/
    function update_users()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			      /* upload image in folder start*/
					$header_image='';
					$content_image = '';
					$header_image = $_FILES['usersimage']['name'];
					  
					 if($header_image !='')
					 {
						 $config['upload_path'] = './handtec-uploads/icloud_image';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload', $config);
					 
							if ( ! $this->upload->do_upload('usersimage'))
							{
								$error = array('error' => $this->upload->display_errors());
								
								 $this->session->set_flashdata('err_login',$error['error']);
								
								  redirect('koreatown-administrator/All_users'); 
								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$content_image = $this->upload->file_name; 
								unlink("uploads/userss/".$this->input->post('old_image',TRUE));
							
								
							}
							
					  }
					  else
					  {
						 $content_image =$this->input->post('old_image',TRUE);
						  
					  }				  						
			 /* upload image in folder End*/	
			 
				  $update_data = array
					             (
					                    'usersimage' => $content_image,
										'name' => $this->input->post('name',true),
										'adddate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(USERS,$where,$update_data);	
				   redirect('koreatown-administrator/All_users'); 
		}
	}
/*function for edit users End*/
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
    
	
/*function for Sliders*/

	public function Allsliders()
	{
		  $this->_chk_if_login();
		 
		  $this->load->view('admin/allslider');
	}

	/* function for get all products */
    public function get_sliders($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_sliders/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_sliderJoin(SLIDERS,'sliders.id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_slider_count(SLIDERS,'sliders.id');
		
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
											    <th>Product-Name</th>
												<th>Gallery Image</th>
												<th>inStock</th>											
												<th>CreateDate</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->title.'</td>
					                                  <td>'.$data_paging[$i]->descriptiondata.'</td>
													 <td><img hieght="50" width="50" src ="'.base_url().'uploads/sliders/'.$data_paging[$i]->image.'"></td>		                                 
					                                 <td>'.$data_paging[$i]->added_date.'</td>
					                                 				                            
					                                  </td>';

					                    $data['searchall_data'][].='<td>				                                  
													    
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/slider_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_slider('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
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
	
   /* function for Add Coupon */
    public function add_slider()
	{
		  $this->_chk_if_login();
		  $config['category'] = $this->Admin_model->get_all(CATEGORY);
		  $config['subcategory'] = $this->Admin_model->get_all(SUBCATEGORY);
          $where = array('userType'=> '2');	   
	      $config['allmerchant'] = $this->Admin_model->getwhere(ADMIN,$where);
		  $this->load->view('admin/add_slider',$config);
	}
	
	 
    function add_slideraction()
    {
		$this->_chk_if_login();
		if($_POST)
		{

             /* upload image in folder start*/
                     $gallery_image ="";
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/sliders';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/Allsliders'); 
								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}
					  }
			
				    $insert_data = array
					             (	               	
										'title' => $this->input->post('title',true),
										'descriptiondata' => $this->input->post('descriptiondata',true),
										'image' => $gallery_image,
										'added_date' =>date('Y-m-d H:i:s'),
								  );
							

				  $update = $this->Admin_model->insert_data(SLIDERS,$insert_data);	
				  
				  redirect('koreatown-administrator/Allsliders'); 
		}else{
			$config['select_data'] = $this->Admin_model->get_all(SLIDERS);
			
			$this->load->view('admin/add_slider',$config); 			
			 }
	}
	
	/* ************* Delete slider data ************ */ 
	public function delete_slider()
	{
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(SLIDERS,$where);
	 redirect('koreatown-administrator/Allsliders');
	}

	/* ************* Select slider edit ************ */ 	
	
    function slider_edit()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   $config['allslider'] = $this->Admin_model->getSingle(SLIDERS,$where);	 
	   
        $this->load->view('admin/edit_slider',$config); 
    }
  /*function for edit slider  Start*/
    function update_slider()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			      
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/sliders';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/Allsliders'); 								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $gallery_image =$this->input->post('old_image1',TRUE);						  
					  }
			 /* upload image in folder End*/						  
						  
			     $update_data = array
					             (
								    'title' => $this->input->post('title',true),
									'descriptiondata' => $this->input->post('descriptiondata',true),
									'image' => $gallery_image,
									'added_date' =>date('Y-m-d H:i:s'),
								  );

			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(SLIDERS,$where,$update_data);	
				  redirect('koreatown-administrator/Allsliders'); 
		}
	}	
	/*----------------Activate slider-------------------------------------------------*/
	function activate_slider()
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
				  $update = $this->Admin_model->update_data(SLIDERS,$where,$update_data);	
				  //echo $update;die();
				   redirect('koreatown-administrator/Allsliders'); 
		}
	}

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
	     
	     $data_paging = $this->Admin_model->getAll_subcategory(SUBCATEGORY,'productsubcategory.id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_subcategory_count(SUBCATEGORY,'productsubcategory.id');
		 
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
	
	   $where = array('productsubcategory.id'=>$subcatid);
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
/*function for edit subcategory End*/
public function ProductList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allproducts');
	}
	public function AllProducts()
	{
		  $this->_chk_if_login();
		 
		  $this->load->view('admin/allproducts');
	}
	/* function for get all products */
    public function get_products($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_products/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_productsJoin(PRODUCTS,'product.id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_products_count(PRODUCTS,'product.id');
		
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
											    <th>Product-Name</th>
												<th>Category/Subcategory</th>
												<th>Price</th>
												<th>Ratail Price</th>
												<th>Whole Sale Price</th>
												<th>Featur Image</th>
												<th>Gallery Image</th>
												<th>inStock</th>
												<th>Merchant</th>												
												<th>CreateDate</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->productName.'</td>
					                                 <td>'.$data_paging[$i]->categoryname.'/'.$data_paging[$i]->subcategoryname.'</td>
					                                 <td>'.$data_paging[$i]->price.'</td>
					                                 <td>'.$data_paging[$i]->retailprice.'</td>
					                                 <td>'.$data_paging[$i]->wholesaleprice.'</td>
					                                 <td><img hieght="50" width="50" src ="'.base_url().'uploads/featuredimg/'.$data_paging[$i]->featureImage.'"></td>
													 <td><img hieght="50" width="50" src ="'.base_url().'uploads/galleryimg/'.$data_paging[$i]->imageGallery.'"></td>
					                                 <td>'.$data_paging[$i]->availability.'</td>
					                                 <td><a class="btn btn-info" href="'.base_url().'koreatown-administrator/view_merchants/'.$data_paging[$i]->merchantId.'/"><i class="fa fa-eye"></i>'.$data_paging[$i]->merchantname.'</a></td>					                                 
					                                 <td>'.$data_paging[$i]->createDates.'</td>
					                                 				                            
					                                  </td>';
					                                
					                if($data_paging[$i]->status == 0){     	                                
					                    $data['searchall_data'][].='<td>				                                  
													    <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_products/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Active</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/product_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>'; 
									}else{
										$data['searchall_data'][].='<td>				                                  
													   <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_products/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Deactive</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/product_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
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
	
   /* function for Add Coupon */
    public function add_products()
	{
		  $this->_chk_if_login();
		  $config['category'] = $this->Admin_model->get_all(CATEGORY);
		  $config['subcategory'] = $this->Admin_model->get_all(SUBCATEGORY);
          $where = array('userType'=> '2');	   
	      $config['allmerchant'] = $this->Admin_model->getwhere(ADMIN,$where);
		  $this->load->view('admin/add_products',$config);
	}
	
    public function getsubcategory()
	{
		$this->_chk_if_login();
		$id =$this->input->post('catid',true);
		$where = array('catId'=> $id);
				
		if($result = $this->Admin_model->getwhere(SUBCATEGORY,$where))
		{
			foreach($result as  $data){		
				echo '<option value="'.$data->id.'">'.$data->subcatName.'</option>';
			}			
		}else{
			   echo '<option value="">Record Not Found</option>';
		}		
	}
	 
    function add_productaction()
    {
		$this->_chk_if_login();
		if($_POST)
		{	 
	     /* upload image in folder start*/
					$header_image='';
					$header_image = $_FILES['featurdimg']['name'];
				
					 if($header_image !='')
					 {
						 $config['upload_path'] = './uploads/featuredimg';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config);
						 					 
							if ( ! $this->upload->do_upload('featurdimg'))
							 {
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$featur_image = $this->upload->file_name; 								
							}							
					  }

             /* upload image in folder start*/
                     $gallery_image ="";
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/galleryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 
								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}							
					  }						  
			 /* upload image in folder End*/
			 		$dealId = $this->random_string('6');
					$dailyDiscountId = $this->random_string('8');
					$brandId = $this->random_string('10');
					
				    $insert_data = array
					             (	               	
										'productName' => $this->input->post('productName',true),
										'merchantId' => $this->input->post('merchantId',true),
										'dealId' => $dealId,
										'dailyDiscountId' => $dailyDiscountId,
										'brandId' => $brandId,
										'categoryId' => $this->input->post('categoryId',true),
										'subcategoryId' => $this->input->post('subcategoryId',true),
										'price' => $this->input->post('price',true),
										'retailprice' => $this->input->post('retailprice',true),
										'wholesaleprice' => $this->input->post('wholesaleprice',true),
										'review' => $this->input->post('review',true),
										'rating' => $this->input->post('rating',true),
										'availability' => $this->input->post('availability',true),
										'featureImage' => $featur_image,
										'imageGallery' => $gallery_image,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
							
				  $update = $this->Admin_model->insert_data(PRODUCTS,$insert_data);	
				  
				  redirect('koreatown-administrator/AllProducts'); 
		}else{
			$config['select_data'] = $this->Admin_model->get_all(PRODUCTS);
			
			$this->load->view('admin/add_coupon',$config); 			
			 }
	}
	
	/* ************* Delete Coupon data ************ */ 
	public function delete_products()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(PRODUCTS,$where);
	 redirect('koreatown-administrator/AllProducts');
	}	
	/* ************* Select Coupon edit ************ */ 	
	
    function product_edit()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   
	   $config['edit_data'] = $this->Admin_model->getSingle(PRODUCTS,$where);
	   $config['category'] = $this->Admin_model->get_all(CATEGORY);
	   $config['subcategory'] = $this->Admin_model->get_all(SUBCATEGORY);	
       $where = array('userType'=> '2');	   
	   $config['allmerchant'] = $this->Admin_model->getwhere(ADMIN,$where);	 
	   
        $this->load->view('admin/product_edit',$config); 
    }
  /*function for edit Coupon  Start*/
    function update_product()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			        $header_image='';
					$header_image = $_FILES['featurdimg']['name'];
				
					 if($header_image !='')
					 {
						 $config['upload_path'] = './uploads/featuredimg';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config);
						 					 
							if ( ! $this->upload->do_upload('featurdimg'))
							 {
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$featur_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $featur_image =$this->input->post('old_image',TRUE);						  
					  }
					  
             /* upload image in folder start*/
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/galleryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $gallery_image =$this->input->post('old_image1',TRUE);						  
					  }
			 /* upload image in folder End*/						  
						  
			     $update_data = array
					             (
								    	'productName' => $this->input->post('productName',true),
										'merchantId' => $this->input->post('merchantId',true),
										'dealId' => $this->input->post('dealId',true),
										'dailyDiscountId' => $this->input->post('dailyDiscountId',true),
										'brandId' => $this->input->post('brandId',true),
										'categoryId' => $this->input->post('categoryId',true),
										'subcategoryId' => $this->input->post('subcategoryId',true),
										'price' => $this->input->post('price',true),
										'retailprice' => $this->input->post('retailprice',true),
										'wholesaleprice' => $this->input->post('wholesaleprice',true),
										'review' => $this->input->post('review',true),
										'rating' => $this->input->post('rating',true),
										'availability' => $this->input->post('availability',true),
										'featureImage' => $featur_image,
										'imageGallery' => $gallery_image,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(PRODUCTS,$where,$update_data);	
				  redirect('koreatown-administrator/AllProducts'); 
		}
	}
		
	/*----------------Activate products-------------------------------------------------*/
	function activate_products()
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
				  $update = $this->Admin_model->update_data(PRODUCTS,$where,$update_data);	
				  //echo $update;die();
				   redirect('koreatown-administrator/AllProducts'); 
		}
	}
	/* function for get all products merchant */
	public function AllProductsmerchant()
	{
		  $this->_chk_if_login();
		 
		  $this->load->view('admin/allmerchantsproduct');
	}
	
	/* function for get all products merchant */
    public function get_productsmerchant($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_productsmerchant/');
	     $config['per_page']   =12;
		  
		 $logid = $this->session->userdata('admin_id');		 
	     $where = array('merchantId'=> $logid);
		 
	     $data_paging = $this->Admin_model->getAll_productsmerchantJoin(PRODUCTS,'product.id',$config['per_page'],$start,$where);
		 $config['total_rows'] = $this->Admin_model->getAll_productsmerachant_count(PRODUCTS,'product.id',$where);
		
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
											    <th>Product-Name</th>
												<th>Category/Subcategory</th>
												<th>Price</th>
												<th>Ratail Price</th>
												<th>Whole Sale Price</th>
												<th>Featur Image</th>
												<th>Gallery Image</th>
												<th>inStock</th>
												<th>Merchant</th>												
												<th>CreateDate</th>
												<th>Action</th>												
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->productName.'</td>
					                                 <td>'.$data_paging[$i]->categoryname.'/'.$data_paging[$i]->subcategoryname.'</td>
					                                 <td>'.$data_paging[$i]->price.'</td>
					                                 <td>'.$data_paging[$i]->retailprice.'</td>
					                                 <td>'.$data_paging[$i]->wholesaleprice.'</td>
					                                 <td><img hieght="50" width="50" src ="'.base_url().'uploads/featuredimg/'.$data_paging[$i]->featureImage.'"></td>
													 <td><img hieght="50" width="50" src ="'.base_url().'uploads/galleryimg/'.$data_paging[$i]->imageGallery.'"></td>
					                                 <td>'.$data_paging[$i]->availability.'</td>
					                                 <td><a class="btn btn-info" href="'.base_url().'koreatown-administrator/view_merchants/'.$data_paging[$i]->merchantId.'/"><i class="fa fa-eye"></i>'.$data_paging[$i]->merchantname.'</a></td>					                                 
					                                 <td>'.$data_paging[$i]->createDates.'</td>
					                                 				                            
					                                  </td>';
					                                
					                if($data_paging[$i]->status == 0){     	                                
					                    $data['searchall_data'][].='<td>				                                  
													    <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_productsmerchant/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Active</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/productmerchant_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_productsmerchant('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>'; 
									}else{
										$data['searchall_data'][].='<td>				                                  
													   <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_productsmerchant/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Deactive</a>
														<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/productmerchant_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
													    <a class="btn btn-danger" onclick="delete_productsmerchant('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
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
	
   /* function for Add Product For Marchant */
    public function add_merchantproduct()
	{
		  $this->_chk_if_login();
		  $config['category'] = $this->Admin_model->get_all(CATEGORY);
		  $config['subcategory'] = $this->Admin_model->get_all(SUBCATEGORY);
		  $config['allmerchant'] = $this->Admin_model->get_all_merchant(USERS);
		  $this->load->view('admin/add_merchantproduct',$config);
	}	
	
   /* function for Add Product For Marchant */
    function add_mechantproductaction()
    {
		$this->_chk_if_login();
		if($_POST)
		{
	     /* upload image in folder start*/
					$header_image='';
					$header_image = $_FILES['featurdimg']['name'];
				
					 if($header_image !='')
					 {
						 $config['upload_path'] = './uploads/featuredimg';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config);
						 					 
							if ( ! $this->upload->do_upload('featurdimg'))
							 {
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$featur_image = $this->upload->file_name; 								
							}							
					  }

             /* upload image in folder start*/
                     $gallery_image ="";
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/galleryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 
								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}							
					  }						  
			 /* upload image in folder End*/
			 		$dealId = $this->random_string('6');
					$dailyDiscountId = $this->random_string('8');
					$brandId = $this->random_string('10');
					
					$merchantid = $this->session->userdata('admin_id');
					
				    $insert_data = array
					             (	               	
										'productName' => $this->input->post('productName',true),
										'merchantId' => $merchantid,
										'dealId' => $dealId,
										'dailyDiscountId' => $dailyDiscountId,
										'brandId' => $brandId,
										'categoryId' => $this->input->post('categoryId',true),
										'subcategoryId' => $this->input->post('subcategoryId',true),
										'price' => $this->input->post('price',true),
										'retailprice' => $this->input->post('retailprice',true),
										'wholesaleprice' => $this->input->post('wholesaleprice',true),
										'review' => $this->input->post('review',true),
										'rating' => $this->input->post('rating',true),
										'availability' => $this->input->post('availability',true),
										'featureImage' => $featur_image,
										'imageGallery' => $gallery_image,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
							
				  $update = $this->Admin_model->insert_data(PRODUCTS,$insert_data);	
				  
				  redirect('koreatown-administrator/AllProductsmerchant'); 
		}else{
			$config['select_data'] = $this->Admin_model->get_all(PRODUCTS);
			
			$this->load->view('admin/add_coupon',$config); 			
			 }
	}
	
	/* ************* Select Product Marchant edit ************ */ 	
	
    function productmerchant_edit()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   
	   $config['edit_data'] = $this->Admin_model->getSingle(PRODUCTS,$where);
	   $config['category'] = $this->Admin_model->get_all(CATEGORY);
	   $config['subcategory'] = $this->Admin_model->get_all(SUBCATEGORY);	   
	   $config['allmerchant'] = $this->Admin_model->get_all_merchant(USERS);
	   
        $this->load->view('admin/productmerchant_edit',$config); 
    }
  /*function for edit Product Marchant Start*/
    function update_productmerchant()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			        $header_image='';
					$header_image = $_FILES['featurdimg']['name'];
				
					 if($header_image !='')
					 {
						 $config['upload_path'] = './uploads/featuredimg';
						 $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config);
						 					 
							if ( ! $this->upload->do_upload('featurdimg'))
							 {
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProductsmerchant'); 								 
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());	
								$featur_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $featur_image =$this->input->post('old_image',TRUE);						  
					  }
					  
             /* upload image in folder start*/
					 $header_image1 = $_FILES['galleryimg']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/galleryimg';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('galleryimg'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('koreatown-administrator/AllProducts'); 								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$gallery_image = $this->upload->file_name; 								
							}							
					  }else
					  {
						 $gallery_image =$this->input->post('old_image1',TRUE);						  
					  }
			 /* upload image in folder End*/						  
						  
			     $update_data = array
					             (
								    	'productName' => $this->input->post('productName',true),
										'categoryId' => $this->input->post('categoryId',true),
										'subcategoryId' => $this->input->post('subcategoryId',true),
										'price' => $this->input->post('price',true),
										'retailprice' => $this->input->post('retailprice',true),
										'wholesaleprice' => $this->input->post('wholesaleprice',true),
										'review' => $this->input->post('review',true),
										'rating' => $this->input->post('rating',true),
										'availability' => $this->input->post('availability',true),
										'featureImage' => $featur_image,
										'imageGallery' => $gallery_image,
										'createDate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(PRODUCTS,$where,$update_data);	
				  redirect('koreatown-administrator/AllProductsmerchant'); 
		}
	}	
	
	/*----------------Activate products Marchant-------------------------------------------------*/
	function activate_productsmerchant()
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
				  $update = $this->Admin_model->update_data(PRODUCTS,$where,$update_data);	
				  //echo $update;die();
				   redirect('koreatown-administrator/AllProductsmerchant'); 
		}
	}
	
	/* ************* Delete Product Marchant data ************ */ 
	public function delete_productsmerchant()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(PRODUCTS,$where);
	 redirect('koreatown-administrator/AllProductsmerchant');
	}		
	
    /*----------------  Coupon  -------------------------------------------------*/
	/*function for Coupon start*/
	public function CouponList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allcoupon');
	}
	
    public function add_coupon()
	{
		  $this->_chk_if_login();
		  $config['getuserdata'] = $this->Admin_model->get_all_user(USERS);
		  $this->load->view('admin/add_coupon',$config);
	}
	
	/* function for get all COUPAN */
    public function get_coupon($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_coupon/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_coupon(COUPON,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_coupon_count(COUPON,'id');
		 
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
											    <th>User</th>
											    <th>Coupon Code</th>	
											    <th>Coupon Amount</th>	
											    <th>Avail From</th>	
											    <th>Expire Date</th>		
											 
											    <th>Action</th>						
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->name.'</td>
					                                 <td>'.$data_paging[$i]->couponCode.'</td>
					                                 <td>'.$data_paging[$i]->couponAmount.'</td>
					                                 <td>'.$data_paging[$i]->availFrom.'</td>
					                                 <td>'.$data_paging[$i]->expireDate.'</td>
					                                 </td>';
					                    if($data_paging[$i]->isActive == 0){                                  
					                     $data['searchall_data'][].='<td>
                                                        <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_coupon/'.$data_paging[$i]->id.'/'.$data_paging[$i]->isActive.'/"><i class=""></i>Active</a>										 
													    <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/coupon_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													     <a class="btn btn-danger" onclick="delete_coupon('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												     </td>
					                             </tr>';
										}else{
										   $data['searchall_data'][].='<td>
                                                        <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_coupon/'.$data_paging[$i]->id.'/'.$data_paging[$i]->isActive.'/"><i class=""></i>Deactive</a>										 
													    <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/coupon_edit/'.$data_paging[$i]->id.'/"><i class="fa fa-pencil"></i></a> 
													     <a class="btn btn-danger" onclick="delete_coupon('.$data_paging[$i]->id.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
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
	
   /* function for Add Coupon */	
    function add_couponaction()
    {
		$this->_chk_if_login();
		if($_POST)
		{	 
				  $insert_data = array
					             (		
										'userId' => $this->input->post('username',true),
										'couponCode' => $this->input->post('couponCode',true),
										'couponAmount' => $this->input->post('couponAmount',true),
										'availFrom' => $this->input->post('availFrom',true),
										'expireDate' => $this->input->post('expireDate',true),										
										'createDate' =>date('Y-m-d H:i:s'),
								  );
								  
				  $update = $this->Admin_model->insert_data(COUPON,$insert_data);	
				  redirect('koreatown-administrator/CouponList'); 
		}else{
			$config['select_data'] = $this->Admin_model->get_all(COUPON);
			
			$this->load->view('admin/add_coupon',$config); 			
			 }
	}
	
	/* ************* Delete Coupon data ************ */ 
	public function delete_coupon()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(COUPON,$where);
	 redirect('koreatown-administrator/CouponList');
	}	
	/* ************* Select Coupon edit ************ */ 	
	
    function coupon_edit()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   $config['edit_data'] = $this->Admin_model->getSingle(COUPON,$where);
	   $config['getuserdata'] = $this->Admin_model->get_all_user(USERS);
	   $this->load->view('admin/coupon_edit',$config); 
    }	
  /*function for edit Coupon  Start*/
    function update_coupon()
    {
		$this->_chk_if_login();
		if($_POST)
		{
			     $update_data = array
					             (		
								        'userId' => $this->input->post('username',true),
										'couponCode' => $this->input->post('couponCode',true),
										'couponAmount' => $this->input->post('couponAmount',true),
										'availFrom' => $this->input->post('availFrom',true),
										'expireDate' => $this->input->post('expireDate',true),										
										'createDate' =>date('Y-m-d H:i:s'),
								  );
								  
			      $id = $this->uri->segment(3);
				  $where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(COUPON,$where,$update_data);	
				  redirect('koreatown-administrator/CouponList'); 
		}
	}

    function activate_coupon()
    {
		$this->_chk_if_login();
		$id=$this->uri->segment(3);
		$isActive=$this->uri->segment(4);
		if($id != null)
		{
			if($isActive != 1)
			{
			$update_data = array('isActive' => 1);	
			}else{
			$update_data = array('isActive' => 0);	
			}
			$where = array('id'=> $id);
				  $update = $this->Admin_model->update_data(COUPON,$where,$update_data);	
				   redirect('koreatown-administrator/CouponList'); 
		}
	}
	
  /* End edit Coupon  Start*/
     /*----------------  Coupon  -------------------------------------------------*/
	/*function for Coupon start*/
	public function OrdersList()
	{
		  $this->_chk_if_login();
		  $this->load->view('admin/allorder');
	}
		
	/* function for get all COUPAN */
     public function get_orders($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_orders/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_orders(ORDERS,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_orders_count(ORDERS,'id');
		 
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
											    <th>User Name</th>
											    <th>Total Amount</th>								
											    <th>Shipping Address</th>
											    <th>Create Date</th>										
											    <th>Pay Status</th>
											    <th>Order Status</th> 										 
											    <th>Action</th>						
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->name.'</td>
					                                 <td>'.$data_paging[$i]->totalAmount.'</td>
				                             
					                                 <td>'.$data_paging[$i]->shippingAddress.'</td>
					                                 <td>'.$data_paging[$i]->createDate.'</td>
					                                 <td>'.$data_paging[$i]->payStatus.'</td>';
					                              				                          
					                    if($data_paging[$i]->status == 1){  
                                           $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" selected="selected">Recive</option><option value="2">Pendig</option><option value="3">Compelete</option></select></td>';										
                                        }
										else if($data_paging[$i]->status == 2)
										{
											 $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" >Recive</option><option value="2" selected="selected">Pendig</option><option value="3">Compelete</option></select></td>';	
										}	
                                        else if($data_paging[$i]->status == 3) 
                                        {
											 $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" >Recive</option><option value="2">Pendig</option><option value="3" selected="selected">Compelete</option></select></td>';	
										}											
											
					                     $data['searchall_data'][].='<td>
                                                 							 
													    <a class="btn btn-info" href="'.base_url().'koreatown-administrator/viewOrders/'.$data_paging[$i]->orderId.'/"><i class="fa fa-eye"></i></a>
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
     /*----------------  Coupon  -------------------------------------------------*/
	/*function for Coupon start*/
	public function MerchanOrders()
	{	
		  $this->_chk_if_login();
		  $this->load->view('admin/OrdersMerchantList');
	}
		
	/* function for get all COUPAN */
     public function get_ordersmerchant($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('koreatown-administrator/get_ordersmerchant/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Admin_model->getAll_ordersmerchant(ORDERS,'id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Admin_model->getAll_ordersmerchant_count(ORDERS,'id');
		
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
											    <th>User Name</th>
											    <th>Total Amount</th>								
											    <th>Shipping Address</th>
											    <th>Create Date</th>										
											    <th>Pay Status</th>
											    <th>Order Status</th> 										 
											    <th>Action</th>						
				  							</tr>';
				  $j=1;							
				  for ($i=0; $i<$end  ; $i++) 
				  {
					  $data['searchall_data'][]='<tr>
					                                 <td>'.$j.'</td>
					                                 <td>'.$data_paging[$i]->name.'</td>
					                                 <td>'.$data_paging[$i]->totalAmount.'</td>
				                             
					                                 <td>'.$data_paging[$i]->shippingAddress.'</td>
					                                 <td>'.$data_paging[$i]->createDate.'</td>
					                                 <td>'.$data_paging[$i]->payStatus.'</td>';
					                              				                          
					                    if($data_paging[$i]->status == 1){  
                                           $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" selected="selected">Recive</option><option value="2">Pendig</option><option value="3">Compelete</option></select></td>';										
                                        }
										else if($data_paging[$i]->status == 2)
										{
											 $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" >Recive</option><option value="2" selected="selected">Pendig</option><option value="3">Compelete</option></select></td>';	
										}	
                                        else if($data_paging[$i]->status == 3) 
                                        {
											 $data['searchall_data'][].='<td><select class="form-control" name="orderstatus" onchange="changeorderstatus(this.value,'.$data_paging[$i]->orderId.')"><option value="1" >Recive</option><option value="2">Pendig</option><option value="3" selected="selected">Compelete</option></select></td>';	
										}											
											
					                     $data['searchall_data'][].='<td>
                                                 							 
													    <a class="btn btn-info" href="'.base_url().'koreatown-administrator/viewMerchantOrders/'.$data_paging[$i]->orderId.'/"><i class="fa fa-eye"></i></a>
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
/* End  */	
	
    function changeorderstatus()
    {
		$this->_chk_if_login();
		$id=$this->uri->segment(3);
		$status=$this->uri->segment(4);
		if($id != null)
		{
			$update_data = array('status' => $status);	
			$where = array('orderId'=> $id);
		    $update = $this->Admin_model->update_data(ORDERS,$where,$update_data);	
	        redirect('koreatown-administrator/OrdersList');
		   // echo 1;
			//exit();
		}
	}

// View Orders
    function viewOrders()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('orderId'=>$id);
	   $config['view_data'] = $this->Admin_model->getAll_ordersdetail(ORDERSDETAILS,$where,$id);	
	   $config['orderId'] = $id;
	   $this->load->view('admin/view_orders',$config); 
    }

// View Merchant Order	
    function viewMerchantOrders()
    {
	   $this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array(ORDERSDETAILS.'.orderId'=>$id,ORDERS.'.merchantId'=>$this->session->userdata('admin_id'));
	   $config['view_data'] = $this->Admin_model->getAll_ordersmerchantdetail(ORDERSDETAILS,$where,$id);	
	   $config['orderId'] = $id;
	   $this->load->view('admin/view_merchant',$config); 
    }	
//close controller
}	
?>
