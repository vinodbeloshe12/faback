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
    $data["message"]=$this->user_model->registerUserFronEnd('vinod', 'beloshe','vinodbeloshe122@gmail.com');
    $this->load->view("json",$data);  
}

public function addListing(){
    $data = json_decode(file_get_contents('php://input'), true);
    // print_r($data);
    $bid = $this->input->get_post("bid");
    $bid = $data['bid'];
    $buisnessname = $data['bname'];
    $email = $data['email'];
    $contact = $data['contact'];
    $addline1 = $data['address'];
    $addline2 = $data['landmark'];
    $city = $data['city'];
    $pin = $data['zip'];
    $status = "2";
    $type = "1";
    $user="fa";
    $data["message"]=$this->listing_model->addListing($bid, $buisnessname,$email,  $contact, $addline1, $addline2, $city, $pin,  $status, $type,$user);
    $this->load->view("json",$data);  
}

public function addReview(){
    $data = json_decode(file_get_contents('php://input'), true);
     $bid = $data['bid'];
    $email = $data['email'];
    $name = $data['name'];
    $rating = $data['rating'];
    $review = $data['review'];
    $status = 1;
    $data["message"]=$this->listing_model->addReview($bid,$email,$name,$rating,$review,$status);
    $this->load->view("json",$data);  
}

public function login(){
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $this->input->get_post("username");
    $username = $data['username'];
    $password = $data['password'];
    $data["message"]=$this->listing_model->login($username,$password);
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
} ?>