<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
    public function getOrderingDone()
    {
        $orderby=$this->input->get("orderby");
        $ids=$this->input->get("ids");
        $ids=explode(",",$ids);
        $tablename=$this->input->get("tablename");
        $where=$this->input->get("where");
        if($where == "" || $where=="undefined")
        {
            $where=1;
        }
        $access = array(
            '1',
        );
        $this->checkAccess($access);
        $i=1;
        foreach($ids as $id)
        {
            //echo "UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = `$id` AND $where";
            $this->db->query("UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = '$id' AND $where");
            $i++;
            //echo "/n";
        }
        $data["message"]=true;
        $this->load->view("json",$data);
        
    }
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data['gender']=$this->user_model->getgenderdropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');
            
            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            	
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`logintype`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['gender']=$this->user_model->getgenderdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');
            
            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    public function viewcart()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcart";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewcartjson?id=").$this->input->get('id');
$data["title"]="View cart";
$this->load->view("templatewith2",$data);
}
function viewcartjson()
{
    $id=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_cart`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_cart`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_cart`.`quantity`";
$elements[2]->sort="1";
$elements[2]->header="Quantity";
$elements[2]->alias="quantity";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_cart`.`product`";
$elements[3]->sort="1";
$elements[3]->header="Product";
$elements[3]->alias="product";
$elements[4]=new stdClass();
$elements[4]->field="`fynx_cart`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="timestamp";
    
$elements[5]=new stdClass();
$elements[5]->field="`fynx_cart`.`size`";
$elements[5]->sort="1";
$elements[5]->header="Size";
$elements[5]->alias="size";

$elements[6]=new stdClass();
$elements[6]->field="`fynx_cart`.`color`";
$elements[6]->sort="1";
$elements[6]->header="Color";
$elements[6]->alias="color";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_cart`","WHERE `fynx_cart`.`user`='$id'");
$this->load->view("json",$data);
}
    public function viewwishlist()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewwishlist";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewwishlistjson?id=".$this->input->get('id'));
$data["title"]="View wishlist";
$this->load->view("templatewith2",$data);
}
function viewwishlistjson()
{
    $user=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_wishlist`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_wishlist`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_wishlist`.`product`";
$elements[2]->sort="1";
$elements[2]->header="Product";
$elements[2]->alias="product";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_wishlist`.`timestamp`";
$elements[3]->sort="1";
$elements[3]->header="Timestamp";
$elements[3]->alias="timestamp";
    
$elements[4]=new stdClass();
$elements[4]->field="`fynx_product`.`name`";
$elements[4]->sort="1";
$elements[4]->header="Product Name";
$elements[4]->alias="productname";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_wishlist` LEFT OUTER JOIN `fynx_product` ON `fynx_product`.`id`=`fynx_wishlist`.`product`","WHERE `fynx_wishlist`.`user`='$user'");
$this->load->view("json",$data);
}
    
    
 public function viewcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcategory";
$data["base_url"]=site_url("site/viewcategoryjson");
$data["title"]="View category";
$this->load->view("template",$data);
}
function viewcategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_category`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`fa_category`.`image`";
$elements[2]->sort="1";
$elements[2]->header="image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`fa_category`.`icon`";
$elements[3]->sort="1";
$elements[3]->header="icon";
$elements[3]->alias="icon";
$elements[4]=new stdClass();
$elements[4]->field="`fa_category`.`status`";
$elements[4]->sort="1";
$elements[4]->header="status";
$elements[4]->alias="status";
$elements[5]=new stdClass();
$elements[5]->field="`fa_category`.`user`";
$elements[5]->sort="1";
$elements[5]->header="user";
$elements[5]->alias="user";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_category`");
$this->load->view("json",$data);
}

public function createcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcategory";
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["title"]="Create category";
$this->load->view("template",$data);
}
public function createcategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","name","trim");
// $this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("icon","icon","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcategory";
$data["title"]="Create category";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
// $image=$this->input->get_post("image");

$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}


$icon=$this->input->get_post("icon");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");
if($this->category_model->create($name,$image,$icon,$status,$user)==0)
$data["alerterror"]="New category could not be created.";
else
$data["alertsuccess"]="category created Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function editcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcategory";
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("icon","icon","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcategory";
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}

$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
// $image=$this->input->get_post("image");
$icon=$this->input->get_post("icon");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");

if($this->category_model->edit($id,$name,$image,$icon,$status,$user)==0)
$data["alerterror"]="New category could not be Updated.";
else
$data["alertsuccess"]="category Updated Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function deletecategory()
{
$access=array("1");
$this->checkaccess($access);
$this->category_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
public function viewsubcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewsubcategory";
$data["base_url"]=site_url("site/viewsubcategoryjson");
$data["title"]="View subcategory";
$this->load->view("template",$data);
}
function viewsubcategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_subcategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_subcategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`fa_subcategory`.`category`";
$elements[2]->sort="1";
$elements[2]->header="category";
$elements[2]->alias="category";
$elements[3]=new stdClass();
$elements[3]->field="`fa_subcategory`.`image`";
$elements[3]->sort="1";
$elements[3]->header="image";
$elements[3]->alias="image";
$elements[4]=new stdClass();
$elements[4]->field="`fa_subcategory`.`icon`";
$elements[4]->sort="1";
$elements[4]->header="icon";
$elements[4]->alias="icon";
$elements[5]=new stdClass();
$elements[5]->field="`fa_subcategory`.`status`";
$elements[5]->sort="1";
$elements[5]->header="status";
$elements[5]->alias="status";
$elements[6]=new stdClass();
$elements[6]->field="`fa_subcategory`.`user`";
$elements[6]->sort="1";
$elements[6]->header="user";
$elements[6]->alias="user";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_subcategory`");
$this->load->view("json",$data);
}

public function createsubcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createsubcategory";
$data[ 'category' ] =$this->category_model->getdropdown();
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["title"]="Create subcategory";
$this->load->view("template",$data);
}
public function createsubcategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("category","category","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("icon","icon","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createsubcategory";
$data["title"]="Create subcategory";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$category=$this->input->get_post("category");
// $image=$this->input->get_post("image");


$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}


$icon=$this->input->get_post("icon");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");
if($this->subcategory_model->create($name,$category,$image,$icon,$status,$user)==0)
$data["alerterror"]="New subcategory could not be created.";
else
$data["alertsuccess"]="subcategory created Successfully.";
$data["redirect"]="site/viewsubcategory";
$this->load->view("redirect",$data);
}
}
public function editsubcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editsubcategory";
$data["title"]="Edit subcategory";
$data[ 'category' ] =$this->category_model->getdropdown();
$data[ 'status' ] =$this->category_model->getstatusdropdown();

$data["before"]=$this->subcategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editsubcategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("category","category","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("icon","icon","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editsubcategory";
$data["title"]="Edit subcategory";
$data["before"]=$this->subcategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$category=$this->input->get_post("category");
// $image=$this->input->get_post("image");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}

$icon=$this->input->get_post("icon");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");
if($this->subcategory_model->edit($id,$name,$category,$image,$icon,$status,$user)==0)
$data["alerterror"]="New subcategory could not be Updated.";
else
$data["alertsuccess"]="subcategory Updated Successfully.";
$data["redirect"]="site/viewsubcategory";
$this->load->view("redirect",$data);
}
}
public function deletesubcategory()
{
$access=array("1");
$this->checkaccess($access);
$this->subcategory_model->delete($this->input->get("id"));
$data["redirect"]="site/viewsubcategory";
$this->load->view("redirect",$data);
}

public function viewlisting()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewlisting";
$data["base_url"]=site_url("site/viewlistingjson");
$data["title"]="View listing";
$this->load->view("template",$data);
}
function viewlistingjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_listing`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_listing`.`buisnessname`";
$elements[1]->sort="1";
$elements[1]->header="buisnessname";
$elements[1]->alias="buisnessname";
$elements[2]=new stdClass();
$elements[2]->field="`fa_listing`.`cperson`";
$elements[2]->sort="1";
$elements[2]->header="cperson";
$elements[2]->alias="cperson";
$elements[3]=new stdClass();
$elements[3]->field="`fa_listing`.`contact`";
$elements[3]->sort="1";
$elements[3]->header="contact";
$elements[3]->alias="contact";
$elements[4]=new stdClass();
$elements[4]->field="`fa_listing`.`addline1`";
$elements[4]->sort="1";
$elements[4]->header="addline1";
$elements[4]->alias="addline1";
$elements[5]=new stdClass();
$elements[5]->field="`fa_listing`.`addline2`";
$elements[5]->sort="1";
$elements[5]->header="addline2";
$elements[5]->alias="addline2";
$elements[6]=new stdClass();
$elements[6]->field="`fa_listing`.`city`";
$elements[6]->sort="1";
$elements[6]->header="city";
$elements[6]->alias="city";
$elements[7]=new stdClass();
$elements[7]->field="`fa_listing`.`state`";
$elements[7]->sort="1";
$elements[7]->header="state";
$elements[7]->alias="state";
$elements[8]=new stdClass();
$elements[8]->field="`fa_listing`.`pin`";
$elements[8]->sort="1";
$elements[8]->header="pin";
$elements[8]->alias="pin";
$elements[9]=new stdClass();
$elements[9]->field="`fa_listing`.`country`";
$elements[9]->sort="1";
$elements[9]->header="country";
$elements[9]->alias="country";
$elements[10]=new stdClass();
$elements[10]->field="`fa_listing`.`keywords`";
$elements[10]->sort="1";
$elements[10]->header="keywords";
$elements[10]->alias="keywords";
$elements[11]=new stdClass();
$elements[11]->field="`fa_listing`.`about`";
$elements[11]->sort="1";
$elements[11]->header="about";
$elements[11]->alias="about";
$elements[12]=new stdClass();
$elements[12]->field="`fa_listing`.`email`";
$elements[12]->sort="1";
$elements[12]->header="email";
$elements[12]->alias="email";
$elements[13]=new stdClass();
$elements[13]->field="`fa_listing`.`facebook`";
$elements[13]->sort="1";
$elements[13]->header="facebook";
$elements[13]->alias="facebook";
$elements[14]=new stdClass();
$elements[14]->field="`fa_listing`.`twitter`";
$elements[14]->sort="1";
$elements[14]->header="twitter";
$elements[14]->alias="twitter";
$elements[15]=new stdClass();
$elements[15]->field="`fa_listing`.`google`";
$elements[15]->sort="1";
$elements[15]->header="google";
$elements[15]->alias="google";
$elements[16]=new stdClass();
$elements[16]->field="`fa_listing`.`linkedin`";
$elements[16]->sort="1";
$elements[16]->header="linkedin";
$elements[16]->alias="linkedin";
$elements[17]=new stdClass();
$elements[17]->field="`fa_listing`.`status`";
$elements[17]->sort="1";
$elements[17]->header="status";
$elements[17]->alias="status";
$elements[18]=new stdClass();
$elements[18]->field="`fa_listing`.`type`";
$elements[18]->sort="1";
$elements[18]->header="type";
$elements[18]->alias="type";
$elements[19]=new stdClass();
$elements[19]->field="`fa_listing`.`user`";
$elements[19]->sort="1";
$elements[19]->header="user";
$elements[19]->alias="user";
$elements[20]=new stdClass();
$elements[20]->field="`fa_listing`.`date`";
$elements[20]->sort="1";
$elements[20]->header="date";
$elements[20]->alias="date";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_listing`");
$this->load->view("json",$data);
}

public function createlisting()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createlisting";
$data[ 'category' ] =$this->category_model->getdropdown();
$data[ 'subcategory' ] =$this->subcategory_model->getdropdown();
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data[ 'type' ] =$this->listing_model->gettypedropdown();
$data["title"]="Create listing";
$this->load->view("template",$data);
}
public function createlistingsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("buisnessname","buisnessname","trim");
$this->form_validation->set_rules("cperson","cperson","trim");
$this->form_validation->set_rules("contact","contact","trim");
$this->form_validation->set_rules("addline1","addline1","trim");
$this->form_validation->set_rules("addline2","addline2","trim");
$this->form_validation->set_rules("city","city","trim");
$this->form_validation->set_rules("state","state","trim");
$this->form_validation->set_rules("pin","pin","trim");
$this->form_validation->set_rules("country","country","trim");
$this->form_validation->set_rules("keywords","keywords","trim");
$this->form_validation->set_rules("about","about","trim");
$this->form_validation->set_rules("email","email","trim");
$this->form_validation->set_rules("facebook","facebook","trim");
$this->form_validation->set_rules("twitter","twitter","trim");
$this->form_validation->set_rules("google","google","trim");
$this->form_validation->set_rules("linkedin","linkedin","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("type","type","trim");
$this->form_validation->set_rules("user","user","trim");
$this->form_validation->set_rules("date","date","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createlisting";
$data["title"]="Create listing";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$bid=$this->input->get_post("bid");
$buisnessname=$this->input->get_post("buisnessname");
$category=$this->input->get_post("category");
$subcategory=$this->input->get_post("subcategory");
$cperson=$this->input->get_post("cperson");
$contact=$this->input->get_post("contact");
$addline1=$this->input->get_post("addline1");
$addline2=$this->input->get_post("addline2");
$city=$this->input->get_post("city");
$state=$this->input->get_post("state");
$pin=$this->input->get_post("pin");
$country=$this->input->get_post("country");
$keywords=$this->input->get_post("keywords");
$about=$this->input->get_post("about");
$email=$this->input->get_post("email");
$facebook=$this->input->get_post("facebook");
$twitter=$this->input->get_post("twitter");
$google=$this->input->get_post("google");
$linkedin=$this->input->get_post("linkedin");
$status=$this->input->get_post("status");
$type=$this->input->get_post("type");
$user=$this->input->get_post("user");
$date=$this->input->get_post("date");
if($this->listing_model->create($bid,$buisnessname,$category,$subcategory,$cperson,$contact,$addline1,$addline2,$city,$state,$pin,$country,$keywords,$about,$email,$facebook,$twitter,$google,$linkedin,$status,$type,$user,$date)==0)
$data["alerterror"]="New listing could not be created.";
else
$data["alertsuccess"]="listing created Successfully.";
$data["redirect"]="site/viewlisting";
$this->load->view("redirect",$data);
}
}
public function editlisting()
{
$access=array("1");
$this->checkaccess($access);
$data["title"]="Edit listing";
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data[ 'category' ] =$this->category_model->getdropdown();
$data[ 'subcategory' ] =$this->subcategory_model->getdropdown();
$data[ 'type' ] =$this->listing_model->gettypedropdown();
$data["before"]=$this->listing_model->beforeedit($this->input->get("id"));
$data["before1"]=$this->input->get("id");
$data["before2"]=$this->input->get("id");
$data["before3"]=$this->input->get("id");
$data["before4"]=$this->input->get("id");
$data["before5"]=$this->input->get("id");
$data["page"]="editlisting";
$data['page2']='block/listingblock';
// $this->load->view("template",$data);
$this->load->view("templatewith2",$data);
}
public function editlistingsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("buisnessname","buisnessname","trim");
$this->form_validation->set_rules("cperson","cperson","trim");
$this->form_validation->set_rules("contact","contact","trim");
$this->form_validation->set_rules("addline1","addline1","trim");
$this->form_validation->set_rules("addline2","addline2","trim");
$this->form_validation->set_rules("city","city","trim");
$this->form_validation->set_rules("state","state","trim");
$this->form_validation->set_rules("pin","pin","trim");
$this->form_validation->set_rules("country","country","trim");
$this->form_validation->set_rules("keywords","keywords","trim");
$this->form_validation->set_rules("about","about","trim");
$this->form_validation->set_rules("email","email","trim");
$this->form_validation->set_rules("facebook","facebook","trim");
$this->form_validation->set_rules("twitter","twitter","trim");
$this->form_validation->set_rules("google","google","trim");
$this->form_validation->set_rules("linkedin","linkedin","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("type","type","trim");
$this->form_validation->set_rules("user","user","trim");
$this->form_validation->set_rules("date","date","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editlisting";
$data["title"]="Edit listing";
$data["before"]=$this->listing_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$bid=$this->input->get_post("bid");
$buisnessname=$this->input->get_post("buisnessname");
$category=$this->input->get_post("category");
$subcategory=$this->input->get_post("subcategory");
$cperson=$this->input->get_post("cperson");
$contact=$this->input->get_post("contact");
$addline1=$this->input->get_post("addline1");
$addline2=$this->input->get_post("addline2");
$city=$this->input->get_post("city");
$state=$this->input->get_post("state");
$pin=$this->input->get_post("pin");
$country=$this->input->get_post("country");
$keywords=$this->input->get_post("keywords");
$about=$this->input->get_post("about");
$email=$this->input->get_post("email");
$facebook=$this->input->get_post("facebook");
$twitter=$this->input->get_post("twitter");
$google=$this->input->get_post("google");
$linkedin=$this->input->get_post("linkedin");
$status=$this->input->get_post("status");
$type=$this->input->get_post("type");
$user=$this->input->get_post("user");
$date=$this->input->get_post("date");
if($this->listing_model->edit($id,$bid,$buisnessname,$category,$subcategory,$cperson,$contact,$addline1,$addline2,$city,$state,$pin,$country,$keywords,$about,$email,$facebook,$twitter,$google,$linkedin,$status,$type,$user,$date)==0)
$data["alerterror"]="New listing could not be Updated.";
else
$data["alertsuccess"]="listing Updated Successfully.";
$data["redirect"]="site/viewlisting";
$this->load->view("redirect",$data);
}
}
public function deletelisting()
{
$access=array("1");
$this->checkaccess($access);
$this->listing_model->delete($this->input->get("id"));
$data["redirect"]="site/viewlisting";
$this->load->view("redirect",$data);
}
public function viewslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewslider";
$data["base_url"]=site_url("site/viewsliderjson");
$data["title"]="View slider";
$this->load->view("template",$data);
}
function viewsliderjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_slider`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_slider`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";
$elements[2]=new stdClass();
$elements[2]->field="`fa_slider`.`status`";
$elements[2]->sort="1";
$elements[2]->header="status";
$elements[2]->alias="status";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_slider`");
$this->load->view("json",$data);
}

public function createslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createslider";
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["title"]="Create slider";
$this->load->view("template",$data);
}
public function createslidersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("status","status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createslider";
$data["title"]="Create slider";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
// $image=$this->input->get_post("image");

$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}
$status=$this->input->get_post("status");
if($this->slider_model->create($image,$status)==0)
$data["alerterror"]="New slider could not be created.";
else
$data["alertsuccess"]="slider created Successfully.";
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}
}
public function editslider()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editslider";
$data["title"]="Edit slider";
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["before"]=$this->slider_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editslidersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("status","status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editslider";
$data["title"]="Edit slider";
$data["before"]=$this->slider_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
// $image=$this->input->get_post("image");


$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}
$status=$this->input->get_post("status");
if($this->slider_model->edit($id,$image,$status)==0)
$data["alerterror"]="New slider could not be Updated.";
else
$data["alertsuccess"]="slider Updated Successfully.";
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}
}
public function deleteslider()
{
$access=array("1");
$this->checkaccess($access);
$this->slider_model->delete($this->input->get("id"));
$data["redirect"]="site/viewslider";
$this->load->view("redirect",$data);
}



public function viewimage()
{
$access=array("1");
$this->checkaccess($access);
$data["base_url"]=site_url("site/viewimagejson");
$data["title"]="View Image";
$data["before"]=$this->input->get("id");
$data["before1"]=$this->input->get("id");
$data["before2"]=$this->input->get("id");
$data["before3"]=$this->input->get("id");
$data["before4"]=$this->input->get("id");
$data["before5"]=$this->input->get("id");
$data["page"]="viewimage";
$data['page2']='block/listingblock';
// $this->load->view("template",$data);
$this->load->view("templatewith2",$data);
}
function viewimagejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_images`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_images`.`lid`";
$elements[1]->sort="1";
$elements[1]->header="lid";
$elements[1]->alias="lid";
$elements[2]=new stdClass();
$elements[2]->field="`fa_images`.`image`";
$elements[2]->sort="1";
$elements[2]->header="image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`fa_images`.`order`";
$elements[3]->sort="1";
$elements[3]->header="order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_images`");
$this->load->view("json",$data);
}



public function viewadvertise()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewadvertise";
$data["base_url"]=site_url("site/viewadvertisejson");
$data["title"]="View advertise";
$this->load->view("template",$data);
}
function viewadvertisejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_advertise`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fa_advertise`.`lid`";
$elements[1]->sort="1";
$elements[1]->header="lid";
$elements[1]->alias="lid";
$elements[2]=new stdClass();
$elements[2]->field="`fa_advertise`.`page`";
$elements[2]->sort="1";
$elements[2]->header="page";
$elements[2]->alias="page";
$elements[3]=new stdClass();
$elements[3]->field="`fa_advertise`.`image`";
$elements[3]->sort="1";
$elements[3]->header="image";
$elements[3]->alias="image";
$elements[4]=new stdClass();
$elements[4]->field="`fa_advertise`.`type`";
$elements[4]->sort="1";
$elements[4]->header="type";
$elements[4]->alias="type";
$elements[5]=new stdClass();
$elements[5]->field="`fa_advertise`.`status`";
$elements[5]->sort="1";
$elements[5]->header="status";
$elements[5]->alias="status";
$elements[6]=new stdClass();
$elements[6]->field="`fa_advertise`.`user`";
$elements[6]->sort="1";
$elements[6]->header="user";
$elements[6]->alias="user";
$elements[7]=new stdClass();
$elements[7]->field="`fa_advertise`.`link`";
$elements[7]->sort="1";
$elements[7]->header="link";
$elements[7]->alias="link";
$elements[8]=new stdClass();
$elements[8]->field="`fa_advertise`.`date`";
$elements[8]->sort="1";
$elements[8]->header="date";
$elements[8]->alias="date";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_advertise`");
$this->load->view("json",$data);
}

public function createadvertise()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createadvertise";
$data[ 'lid' ] =$this->advertise_model->getdropdown();
$data[ 'status' ] =$this->category_model->getstatusdropdown();
$data["title"]="Create advertise";
$this->load->view("template",$data);
}
public function createadvertisesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("page","page","trim");
$this->form_validation->set_rules("lid","lid","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("link","link","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createadvertise";
$data["title"]="Create advertise";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$page=$this->input->get_post("page");
$lid=$this->input->get_post("lid");
// $image=$this->input->get_post("image");


$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}


$link=$this->input->get_post("link");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");
if($this->advertise_model->create($lid,$page,$image,$link,$status,$user)==0)
$data["alerterror"]="New advertise could not be created.";
else
$data["alertsuccess"]="advertise created Successfully.";
$data["redirect"]="site/viewadvertise";
$this->load->view("redirect",$data);
}
}
public function editadvertise()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editadvertise";
$data["title"]="Edit advertise";
$data[ 'category' ] =$this->category_model->getdropdown();
$data[ 'status' ] =$this->category_model->getstatusdropdown();

$data["before"]=$this->advertise_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editadvertisesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("category","category","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("icon","icon","trim");
$this->form_validation->set_rules("status","status","trim");
$this->form_validation->set_rules("user","user","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editadvertise";
$data["title"]="Edit advertise";
$data["before"]=$this->advertise_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$category=$this->input->get_post("category");
// $image=$this->input->get_post("image");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
    $uploaddata = $this->upload->data();
    $image=$uploaddata['file_name'];
}

$icon=$this->input->get_post("icon");
$status=$this->input->get_post("status");
$user=$this->input->get_post("user");
if($this->advertise_model->edit($id,$name,$category,$image,$icon,$status,$user)==0)
$data["alerterror"]="New advertise could not be Updated.";
else
$data["alertsuccess"]="advertise Updated Successfully.";
$data["redirect"]="site/viewadvertise";
$this->load->view("redirect",$data);
}
}
public function deleteadvertise()
{
$access=array("1");
$this->checkaccess($access);
$this->advertise_model->delete($this->input->get("id"));
$data["redirect"]="site/viewadvertise";
$this->load->view("redirect",$data);
}

}
?>

