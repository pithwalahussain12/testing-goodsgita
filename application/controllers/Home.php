<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() 
    {
			parent::__construct();

			$this->load->model('Home_model','',TRUE);
			//$this->load->library(array('pagination','form_validation'));
    }

   function _chk_if_login()
	{
		if($this->session->userdata('logged_in') == false && $this->session->userdata('admin_id') == '')
			{
			$array_items = array('admin_id' =>'', 'admin_email' =>'','logged_in' =>false);

            $this->session->unset_userdata($array_items);
			  redirect('home/login');
				exit();   
			
			}
	}


	public function index()
	{
		  $this->_chk_if_login();
		  $config['category'] = $this->Home_model->get_all(CATEGORY);
		  $config['subcategory'] = $this->Home_model->get_all(SUBCATEGORY);
          $where = array('userType'=> '2');	   
	      $config['allmerchant'] = $this->Home_model->getwhere(ADMIN,$where);
		$this->load->view('view/index',$config);
	}

	public function register()
	{
		$this->form_validation->set_rules('mob', 'Mobile Number', 'required|trim');
		$this->form_validation->set_rules('email', 'User Email', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$filesCount = $_FILES['voter_img']['name'];
			//if($filesCount!=''){
				$_FILES['file']['name']     = $_FILES['voter_img']['name'];
				$_FILES['file']['type']     = $_FILES['voter_img']['type'];
				$_FILES['file']['tmp_name'] = $_FILES['voter_img']['tmp_name'];
				$_FILES['file']['error']     = $_FILES['voter_img']['error'];
				$_FILES['file']['size']     = $_FILES['voter_img']['size'];
		// File upload configuration
				$uploadPath = 'assets/voterid/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|jpeg|png';

		// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

		// Upload file to server
				if($this->upload->do_upload('file')){
		// Uploaded file data
					$fileData = $this->upload->data();
					$uploadData = $fileData['file_name'];
				}
			//}

			if(!empty($uploadData))
			{
				$voter_img= $uploadData;
			}
			else
			{
				$voter_img="";
			}


			$filesCount = $_FILES['aadhar_img']['name'];
			//for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES['aadhar_img']['name'];
				$_FILES['file']['type']     = $_FILES['aadhar_img']['type'];
				$_FILES['file']['tmp_name'] = $_FILES['aadhar_img']['tmp_name'];
				$_FILES['file']['error']     = $_FILES['aadhar_img']['error'];
				$_FILES['file']['size']     = $_FILES['aadhar_img']['size'];
		// File upload configuration
				$uploadPath = 'assets/aadhar/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|jpeg|png';

		// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

		// Upload file to server
				if($this->upload->do_upload('file')){
		// Uploaded file data
					$fileData = $this->upload->data();
					$uploadData = $fileData['file_name'];
				}
			//}

			if(!empty($uploadData))
			{
				$aadhar_img= $uploadData;
			}
			else
			{
				$aadhar_img="";
			}

			$username=$this->input->post('username',true);
			$father=$this->input->post('father',true);
			$mob=$this->input->post('mob',true);
			$email=$this->input->post('email',true);
			$category=$this->input->post('category',true);
			$voter_id=$this->input->post('voter_id',true);
			$aadhar_no=$this->input->post('aadhar_no',true);
            $pass = rand(100000,999999);
            $password = password_hash($pass, PASSWORD_DEFAULT);
			$save=array(
				'UN'=>$username,
				'FN'=>$father,
				'contactNumber'=>$mob,
				'UP'=>$password,
				'SUP'=>$pass,
				'EI'=>$email,
				'category'=>$category,
				'voter_id'=>$voter_id,
				'aadhar_no'=>$aadhar_no,
				'voter_img'=>$voter_img,
				'aadhar_img'=>$aadhar_img,
				'createDate'=>date('Y-m-d H:i:s')
			);

			$response= $this->Home_model->insert_data('al',$save);
//print_r($response); die;
			if($response > 0)
			{

				 $this->session->set_flashdata("mobile",$mob);
				 $this->session->set_flashdata("password",$pass);

			     $this->session->set_flashdata("message","<div class='alert alert-success'><strong>Your record has been successfully add</strong></div>");

				redirect(base_url().'home/login');
			}else{

				echo $this->session->set_flashdata("message","<div class='alert alert-danger'><strong> Sothing Went Wrong</strong></div>");

				redirect(base_url().'home/personal');
		        //$this->load->view('view/login', $data);
			}

		}
	   else{

	    $data['category'] = $this->Home_model->get_all(CATEGORY);
		$this->load->view('view/personal', $data);
		   }
	}

/*login for  user  Start*/
	public function login()
	{
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
				$result=$this->Home_model->login($userid,$password);
				//print_r($result); die;
			if($result === '3') 
			{
				$this->session->set_flashdata('message','<span style="color:red;"> Your  Not Authountication Provided By Admin ! Contact To Admin </span>');
				redirect('home/login');
			}
			else if($result) 
			{
				redirect('home');
			}
			else
			{
				$this->session->set_flashdata('message','<span style="color:red;"> Your username or password is incorrect </span>');
				redirect('home/login');
			}
		 }
	   else{
			$this->load->view('view/login');
		   }
	}
/*login for  user  End*/

	public function contactus()
	{
		$this->load->view('contact-us');
	}
	public function newspaper()
	{
		$this->load->view('all-newspaper');
	}
	public function category()
	{
		$this->load->view('all-category');
	}


    public function getsubcategory()
	{
		$this->_chk_if_login();
		$id =$this->input->post('catid',true);
		$where = array('catId'=> $id);
				
		if($result = $this->Home_model->getwhere(SUBCATEGORY,$where))
		{
			foreach($result as  $data){		
				echo '<option value="'.$data->id.'">'.$data->subcatName.'</option>';
			}			
		}else{
			   echo '<option value="">Record Not Found</option>';
		}		
	}

	public function logout()
	{
	    $this->_chk_if_login();	
			$newdata = array(
				'admin_id' 	=>'',
				'admin_name'    => '',
				'admin_email'    => '',
				'admin_logo'    => '',
				'userType'    => '',
				'logged_in' 	=> false,
			);
			
			$this->session->unset_userdata($newdata);
			redirect('home/login');
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
					  }else
							{	
								$featur_image = ''; 								
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
					  }else
							{	
								$gallery_image = ''; 								
							}			  
			 /* upload image in folder End*/
			 		$dealId = $this->random_string('6');
					$dailyDiscountId = $this->random_string('8');
					$brandId = $this->random_string('10');
					
				    $insert_data = array
					             (	               	
										'productName' => $this->input->post('productName',true),
										'merchantId' =>  $this->session->userdata('admin_id'),
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
							
				  $update = $this->Home_model->insert_data(PRODUCTS,$insert_data);	
				  
				  redirect('home/AllProducts'); 
		}else{
			$config['select_data'] = $this->Home_model->get_all(PRODUCTS);
			
			$this->load->view('view/index',$config); 			
			 }
	}


    public function AllProducts()
	{
        $this->_chk_if_login();
		$this->load->view('view/AllProducts'); 	
	}



	/* function for get all products */
    public function get_products($start = 0)
	{
		$data=array();
		$this->load->library('ajaxpagination');
	
		/* get Public Profile listing  data start */
	     $config['base_url']   = site_url('home/get_products/');
	     $config['per_page']   =12;
	     
	     $data_paging = $this->Home_model->getAll_productsJoin(PRODUCTS,'product.id',$config['per_page'],$start);
		 $config['total_rows'] = $this->Home_model->getAll_products_count(PRODUCTS,'product.id');
		
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
					                                 					                                 
					                                 <td>'.$data_paging[$i]->createDates.'</td>
					                                 				                            
					                                  </td>';
					                                
					                if($data_paging[$i]->status == 0){  


                            $data['searchall_data'][].='<td align="center">
                              <a class="btn btn-default"  href="'.base_url().'home/edit_products/'.$data_paging[$i]->pid.'/" ><em class="fa fa-pencil-alt"></em></a>
                              <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" > <em class="fa fa-trash"></em></a>
                            </td>';

					         //            $data['searchall_data'][].='<td>				                                  
													 //    <a class="btn btn-danger" href="'.base_url().'koreatown-administrator/activate_products/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Active</a>
														// <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/product_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
													 //    <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
												  //    </td>
					         //                     </tr>'; 
									}else{



                            $data['searchall_data'][].='<td align="center">
                              <a class="btn btn-default"  href="'.base_url().'home/edit_products/'.$data_paging[$i]->pid.'/" ><em class="fa fa-pencil-alt"></em></a>
                              <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" > <em class="fa fa-trash"></em></a>
                            </td>';
										// $data['searchall_data'][].='<td>				                                  
										// 			   <a class="btn btn-primary" href="'.base_url().'koreatown-administrator/activate_products/'.$data_paging[$i]->pid.'/'.$data_paging[$i]->status.'/"><i class=""></i>Deactive</a>
										// 				<a class="btn btn-primary" href="'.base_url().'koreatown-administrator/product_edit/'.$data_paging[$i]->pid.'/"><i class="fa fa-pencil"></i></a> 
										// 			    <a class="btn btn-danger" onclick="delete_products('.$data_paging[$i]->pid.')" href="javascript:void(0);" ><i class="fa fa-trash-o"></i></a>
										// 		     </td>
					     //                         </tr>';
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


	/* ************* Delete Coupon data ************ */ 
	public function delete_products()
	{    
	 $this->_chk_if_login();
	 $id=$this->uri->segment(3);
	 $where = array('id'=>$id);
	 $this->Admin_model->delete(PRODUCTS,$where);
	 redirect('home/AllProducts');
	}	


	/* ************* Select Coupon edit ************ */ 	
	
    function edit_products()
    {
    	$this->_chk_if_login();
	   $id=$this->uri->segment(3);	
	   $where = array('id'=>$id);
	   
	   $config['edit_data'] = $this->Home_model->getSingle(PRODUCTS,$where);
	   $config['category'] = $this->Home_model->get_all(CATEGORY);
	   $config['subcategory'] = $this->Home_model->get_all(SUBCATEGORY);	
       $where = array('userType'=> '2');	   
	   $config['allmerchant'] = $this->Home_model->getwhere(ADMIN,$where);	 
	   
        $this->load->view('view/edit_products',$config); 
    }

      /*function for edit Coupon  Start*/
    function update_productds()
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
								  redirect('home/AllProducts'); 								 
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
								  redirect('home/AllProducts'); 								 
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
				  $update = $this->Home_model->update_data(PRODUCTS,$where,$update_data);	
				  redirect('home/AllProducts'); 
		}
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


}
