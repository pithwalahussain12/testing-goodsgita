<?php	
defined('BASEPATH') OR exit('No direct script access allowed');

class Frientend extends CI_Controller {

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
			  redirect('Frientend/login');
				exit();   
			
			}
	}


	public function index()
	{
		$this->load->view('web/index');
	}


	public function partner()
	{
		$this->load->view('web/partner');
	}

	public function shop()
	{
		$this->load->view('web/shop');
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
				$this->session->set_flashdata('message','<span style="color:red;"> Your Not Authountication Provided By Admin ! Contact To Admin </span>');
				redirect('Frientend/login');
			}
			else if($result) 
			{
				redirect('home/index');
			}
			else
			{
				$this->session->set_flashdata('message','<span style="color:red;"> Your username or password is incorrect </span>');
				redirect('Frientend/login');
			}
		 }
	   else{
			$this->load->view('web/login');
		   }
	}
/*login for  user  End*/

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


	/*login for  user  Start*/
		public function register()
		{
			$this->form_validation->set_rules('userid', 'User Name', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == TRUE)
			{
			
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
				  
				  redirect('Frientend'); 

			}
		   else
		   {
				$this->load->view('web/register');
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

/*login for  user  End*/
 
    function add_partneraction()
    {
		//$this->_chk_if_login();
		if($_POST)
		{
             /* upload image in folder start*/
                     $pertnerpic_image ="";
					 $header_image1 = $_FILES['profilepic']['name'];  
					 if($header_image1 !='')
					 {
						 $config1['upload_path'] = './uploads/pertnerpic';
						 $config1['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF';
						 $config1['encrypt_name'] = TRUE;

						 $this->load->library('upload');
						 $this->upload->initialize($config1);
					 
							if (!$this->upload->do_upload('profilepic'))
							{
								$error = array('error' => $this->upload->display_errors());								
								 $this->session->set_flashdata('err_login',$error['error']);								
								  redirect('Frientend/partner'); 
								 
							}
							else
							{
								$data1 = array('upload_data' => $this->upload->data());	
								$pertnerpic_image = $this->upload->file_name; 								
							}
					  }

					$new_password_hashed = password_hash($this->input->post('password',true), PASSWORD_DEFAULT);
			
				    $insert_data = array
					             (	               	
										'Name' => $this->input->post('username',true),
										'Email' => $this->input->post('email',true),
										'Mobile' => $this->input->post('contact',true),
										'Password' => $new_password_hashed,
										'PickUpAddress' => $this->input->post('PickUpAddress',true),
										'PickUpPIN' => $this->input->post('PickUpPIN',true),
										'Country' => $this->input->post('Country',true),
										'State' => $this->input->post('State',true),
										'City' => $this->input->post('City',true),
										'PersonalAddress' => $this->input->post('Personal_Address',true),
										'PersonalPIN' => $this->input->post('Personal_PIN',true),
										'IsStoreIdAvailable' => $this->input->post('IsStoreIdAvailable',true),
										'StoreIdType' => $this->input->post('StoreIdType',true),
										'StoreIdNumber' => $this->input->post('StoreIdNumber',true),
										'GSTNumber' => $this->input->post('GSTNumber',true),
										'BankIfscCode' => $this->input->post('BankIfscCode',true),
										'AccountNumber' => $this->input->post('AccountNumber',true),
										'AccountHolderName' => $this->input->post('AccountHolderName',true),
										'ProfilePic' => $pertnerpic_image,
										'FormNum' => '1',
										'added_date' =>date('Y-m-d H:i:s'),
								  );

				  $insertdata = $this->Home_model->insert_data(PARTNER,$insert_data);	
				  
				  redirect('Frientend/partner'); 
		}else{
			
				  redirect('Frientend/partner');  			
			 }
	}
/*login for  user  End*/

}
