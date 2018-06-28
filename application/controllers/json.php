<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallcategory1()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`fa_category`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`fa_category`.`image`";
$elements[2]->sort="1";
$elements[2]->header="image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`fa_category`.`icon`";
$elements[3]->sort="1";
$elements[3]->header="icon";
$elements[3]->alias="icon";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`fa_category`.`status`";
$elements[4]->sort="1";
$elements[4]->header="status";
$elements[4]->alias="status";

$elements=array();
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_category`");
$this->load->view("json",$data);
}
public function getsinglecategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->category_model->getsinglecategory($id);
$this->load->view("json",$data);
}
function getallsubcategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fa_subcategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`fa_subcategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`fa_subcategory`.`category`";
$elements[2]->sort="1";
$elements[2]->header="category";
$elements[2]->alias="category";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`fa_subcategory`.`image`";
$elements[3]->sort="1";
$elements[3]->header="image";
$elements[3]->alias="image";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`fa_subcategory`.`icon`";
$elements[4]->sort="1";
$elements[4]->header="icon";
$elements[4]->alias="icon";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`fa_subcategory`.`status`";
$elements[5]->sort="1";
$elements[5]->header="status";
$elements[5]->alias="status";

$elements=array();
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
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fa_subcategory`");
$this->load->view("json",$data);
}

public function getAllCategory(){
    $data["message"]=$this->category_model->getAllCategory();
    $this->load->view("json",$data);  
}

public function getHomeData(){
    $data["message"]=$this->category_model->getHomeData();
    $this->load->view("json",$data);  
}



public function getAllCategoryById(){
    $id=$this->input->get_post("id");
    $data["message"]=$this->subcategory_model->getAllCategoryById($id);
    $this->load->view("json",$data);  
}

public function registerUser(){
    $data["message"]=$this->user_model->registerUserFronEnd('vinod', 'beloshe','asmitajadhav2593@gmail.com');
    $this->load->view("json",$data);  
}

public function addListing(){
    // $data = json_decode(file_get_contents('php://input'), true);
    // $bid = $data['bid'];
    $bid = $this->input->post('bid');
    $buisnessname = $this->input->post('bname');
    $email = $this->input->post('email');
    $contact = $this->input->post('contact');
    $addline1 = $this->input->post('address');
    $addline2 = $this->input->post('landmark');
    $city = $this->input->post('city');
    $pin = $this->input->post('zip');
    $status = "2";
    $type = "1";
    $user="fa";
    $data["message"]=$this->listing_model->addListing($bid, $buisnessname,$email,  $contact, $addline1, $addline2, $city, $pin,  $status, $type,$user);
    $this->load->view("json",$data);  
}

public function addReview(){
    // $data = json_decode(file_get_contents('php://input'), true);
    $bid = $this->input->post('bid');
    $email = $this->input->post('email');
    $name = $this->input->post('name');
    $rating = $this->input->post('rating');
    $review = $this->input->post('review');
    $status = 1;
    $data["message"]=$this->listing_model->addReview($bid,$email,$name,$rating,$review,$status);
    $this->load->view("json",$data);  
}

public function loginuser(){
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $data["message"]=$this->listing_model->loginFrontEnd($username,$password);
    $this->load->view("json",$data);
}

public function login(){
    $username =  $this->input->post("username");
    $password =  $this->input->post("password");
    $data["message"]=$this->listing_model->loginuser($username,$password);
    $this->load->view("json",$data);  
}

public function getAllListing(){
    $catid=$this->input->get_post("catid");
    $subcatid=$this->input->get_post("subcatid");
    $data["message"]=$this->listing_model->getAllListing($catid,$subcatid);
    $this->load->view("json",$data);  
}

public function getDetails(){
    $name=$this->input->get_post("name");
    $data["message"]=$this->listing_model->getDetails($name);
    $this->load->view("json",$data);  
}

public function getAutoPass(){
     $data["message"]=$this->listing_model->random_password();
    $this->load->view("json",$data);  
}

public function search(){
    $searchTerm=$this->input->get_post("searchTerm");
    $data["message"]=$this->listing_model->search($searchTerm);
     $this->load->view("json",$data);  
  }


public function getsinglesubcategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->subcategory_model->getsinglesubcategory($id);
$this->load->view("json",$data);
}

public function getContent()
{
$id=$this->input->get_post("id");
$data["message"]=$this->content_model->getContent($id);
$this->load->view("json",$data);
}


public function enquiry(){
    // $data = json_decode(file_get_contents('php://input'), true);
    $bid = $this->input->post('bid');
    $email = $this->input->post('email');
    $name = $this->input->post('name');
    $message = $this->input->post('message');
    $contact = $this->input->post('contact');
     $data["message"]=$this->listing_model->enquiry($bid,$email,$name,$message,$contact);
    $this->load->view("json",$data);  
}

public function do_upload()
{
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);
    $filename = 'multipleUpload';
    $userId = $this->input->get_post("bid");
echo $filename;
echo '@@@@@';
echo $userId;
    $resume = '';
    if ($this->upload->do_upload($filename)) {
        $uploaddata = $this->upload->data();
        $resume = $uploaddata['file_name'];
        $config_r['source_pdf'] = './uploads/'.$uploaddata['file_name'];
        // $data['message'] = $this->restapi_model->careersSubmit($name, $email, $mobile, $message, $resume);
        // $data['redirect'] = $url;
        $this->load->view("json",$data);
}
}


public function uploadImage(){
    $userId = $this->input->get_post("bid");
    // $userId = $this->session->userdata("id");
    echo $userId;
    $file_path = "./images/" . $userId . '/';

    print_r($_FILES;
    if (isset($_FILES['multipleUpload'])) {

        if (!is_dir('images/' . $userId)) {
            mkdir('./images/' . $userId, 0777, TRUE);
        }

        $files = $_FILES;
        $cpt = count($_FILES ['multipleUpload'] ['name']);

        for ($i = 0; $i < $cpt; $i ++) {

            $name = time().$files ['multipleUpload'] ['name'] [$i];
            $_FILES ['multipleUpload'] ['name'] = $name;
            $_FILES ['multipleUpload'] ['type'] = $files ['multipleUpload'] ['type'] [$i];
            $_FILES ['multipleUpload'] ['tmp_name'] = $files ['multipleUpload'] ['tmp_name'] [$i];
            $_FILES ['multipleUpload'] ['error'] = $files ['multipleUpload'] ['error'] [$i];
            $_FILES ['multipleUpload'] ['size'] = $files ['multipleUpload'] ['size'] [$i];

            $this->upload->initialize($this->set_upload_options($file_path));
            if(!($this->upload->do_upload('multipleUpload')) || $files ['multipleUpload'] ['error'] [$i] !=0)
            {
                print_r($this->upload->display_errors());
            }
            else
            {
                // $this->load->model('uploadModel','um');
                // $this->um->insertRecord($user,$name);
                return $userId;
            }
        }
    } 
}

} ?>