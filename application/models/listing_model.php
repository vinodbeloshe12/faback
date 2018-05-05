<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class listing_model extends CI_Model
{
public function search($searchTerm){
    if((strlen($searchTerm))>2){
    $query=$this->db->query("SELECT `id`, `bid`, `category`, `subcategory`, `regdate`, `buisnessname`, `cperson`, `contact`, `addline1`, `addline2`, `city`, `state`, `pin`, `country`,  `about`, `email`, `facebook`,`keywords`, `twitter`, `google`, `linkedin` FROM `fa_listing` WHERE city like '%$searchTerm%' OR keywords like '%$searchTerm%' OR bid like '%$searchTerm%' OR buisnessname like '%$searchTerm%'")->result();
    return $query;
}else{
    return [];
}
}

public function create($bid,$buisnessname,$category,$subcategory,$cperson,$contact,$addline1,$addline2,$city,$state,$pin,$country,$keywords,$services,$about,$email,$facebook,$twitter,$google,$linkedin,$status,$type,$user,$date)
{
$data=array("bid" => $bid,"buisnessname" => $buisnessname,"category" => $category,"subcategory" => $subcategory,"cperson" => $cperson,"contact" => $contact,"addline1" => $addline1,"addline2" => $addline2,"city" => $city,"state" => $state,"pin" => $pin,"country" => $country,"keywords" => $keywords,"services" => $services,"about" => $about,"email" => $email,"facebook" => $facebook,"twitter" => $twitter,"google" => $google,"linkedin" => $linkedin,"status" => $status,"type" => $type,"user" => $user,"date" => $date);
$query=$this->db->insert( "fa_listing", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}

public function addReview($bid,$email,$name,$rating,$review,$status){
    $data=array("bid" => $bid,"email" => $email,"name" => $name,"rating" => $rating,"review" => $review,"status" => $status);
    $query=$this->db->insert( "fa_rating", $data );
 if(!$query)
    return  false;
    else
    return  true;
}


public function addListing($bid, $buisnessname,$email,  $contact, $addline1, $addline2, $city, $pin,  $status, $type,$user){
    // $q="SELECT id FROM `fa_listing` where bid='$bid'";
    $q= $this->db->query("SELECT id FROM fa_listing
    WHERE bid = '".$bid."'");
   
    $count = $q->num_rows();
    if($count==0){
 $data=array("bid" => $bid,"buisnessname" => $buisnessname,"email" => $email,"contact" => $contact,"addline1" => $addline1,"addline2" => $addline2,"city" => $city,"pin" => $pin,"status" => $status,"type" => $type,"user" => $user);
    $query=$this->db->insert( "fa_listing", $data );
    $id=$this->db->insert_id();
    $object = new stdClass();
    if($query){
        $data['name']=$buisnessname;
        $data['email']=$email;
        $viewcontent = $this->load->view('emailer/signup', $data, true);
        $this->email_model->emailer($viewcontent,'Welcome to Findacross','emailid010@gmail.com','');
        $q =$this->db->query("SELECT `bid` FROM `fa_listing` WHERE `id`='$id'")->row();
        $object->bid = $q->bid;
        $object->value = true;
        return $object;
    }
    else{
    $object->value = false;
    return $object;
    }
    }else{
        $object = new stdClass();
        $object->value = false;
        $object->message = "Listing id already exists";
        return $object;
    }
   
   
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("fa_listing")->row();
return $query;
}
function getsinglelisting($id){
$this->db->where("id",$id);
$query=$this->db->get("fa_listing")->row();
return $query;
}
public function edit($id,$bid,$buisnessname,$category,$subcategory,$cperson,$contact,$addline1,$addline2,$city,$state,$pin,$country,$keywords,$services,$about,$email,$facebook,$twitter,$google,$linkedin,$status,$type,$user,$date)
{
if($image=="")
{
$image=$this->listing_model->getimagebyid($id);
$image=$image->image;
}
$data=array("bid" => $bid,"buisnessname" => $buisnessname,"category" => $category,"subcategory" => $subcategory,"cperson" => $cperson,"contact" => $contact,"addline1" => $addline1,"addline2" => $addline2,"city" => $city,"state" => $state,"pin" => $pin,"country" => $country,"keywords" => $keywords,"services" => $services,"about" => $about,"email" => $email,"facebook" => $facebook,"twitter" => $twitter,"google" => $google,"linkedin" => $linkedin,"status" => $status,"type" => $type,"user" => $user,"date" => $date);
$this->db->where( "id", $id );
$query=$this->db->update( "fa_listing", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `fa_listing` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
// $query=$this->db->query("SELECT `image` FROM `fa_listing` WHERE `id`='$id'")->row();
// return $query;
}

public function login($username,$password){
    // $query = $this->db->query("SELECT * FROM `user` WHERE status=1 AND email='$username' AND password='$password'")->row();
    // return $query;

$password=md5($password);

           $query=$this->db->query("SELECT `id`, `name`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json`, `firstname`, `lastname`, `phone` FROM `user` WHERE `email`='$email' AND `password`= '$password'");
              if($query->num_rows > 0)
      {
          $user=$query->row_array();
                      $userid = $user['id'];
                     $this->session->set_userdata($user);
          return $user;
      }
      else
              $object = new stdClass();
              $object->value = false;
          return $object;
}

public function getAllListing($catid,$subcatid){
    // $query->category=$this->db->query("SELECT `id`, `name`, `order`, `image`, `icon` FROM `fa_subcategory` WHERE `status`=1 AND `category`='$catid'")->result();
    $query->adsv=$this->db->query("SELECT `id`,  `image`, `link` FROM `fa_advertise` WHERE type=1 and status=1 and page='listing'")->result();
    $query->adsh=$this->db->query("SELECT `id`,  `image`, `link` FROM `fa_advertise` WHERE type=2 and status=1 and page='listing'")->result();
    $query->listing=$this->db->query("SELECT fa_listing.id, fa_listing.regdate,fa_listing.bid, fa_listing.buisnessname,  fa_listing.addline1, fa_listing.addline2, fa_listing.city, fa_listing.state, fa_listing.pin, fa_listing.country, fa_category.name as 'category',fa_subcategory.name as 'subcategory' FROM fa_listing LEFT OUTER JOIN fa_category ON fa_listing.category=fa_category.id LEFT OUTER JOIN fa_subcategory ON fa_listing.subcategory=fa_subcategory.id WHERE fa_listing.status='1' AND `fa_listing`.subcategory='$subcatid' ORDER BY fa_listing.id DESC")->result();
    return $query;
}

public function getDetails($name){
    $chk= $this->db->query("SELECT fa_listing.status FROM fa_listing WHERE fa_listing.bid='$name'")->row();
    if($chk->status==1){
        $query->details=$this->db->query("SELECT fa_listing.id, fa_listing.regdate,fa_listing.type,fa_listing.about, fa_listing.bid,fa_listing.category as 'cid',fa_listing.subcategory as 'sid',fa_listing.buisnessname,
          fa_listing.addline1, fa_listing.addline2, fa_listing.city,fa_listing.services, fa_listing.state, fa_listing.pin, fa_listing.country, fa_category.name as 'category',fa_subcategory.name as 'subcategory' FROM fa_listing LEFT OUTER JOIN fa_category ON fa_listing.category=fa_category.id LEFT OUTER JOIN fa_subcategory ON fa_listing.subcategory=fa_subcategory.id WHERE fa_listing.status='1' AND `fa_listing`.bid='$name'")->row();
        $myId=$query->details->id;
        $query->images=[];   
        $query->images=$this->db->query("SELECT `id`, `image`, `order` FROM `fa_images` WHERE `lid`='$myId'")->result();
        $query->videos=[];
             $query->videos=$this->db->query("SELECT `id`, `video`, `order` FROM `fa_videos` WHERE `lid`='$myId'")->result();
            $query->ads=[];
            $query->ads=$this->db->query("SELECT `id`, `page`, `type`, `image`, `link` FROM `fa_advertise` WHERE `lid`='$myId'")->result();
            $query->rating=$this->db->query("SELECT `id`, `name`, `email`, `rating`, `review`, `status`,`date` FROM `fa_rating` WHERE `bid`='$myId'")->result();
    }else{
        $query->details=$this->db->query("SELECT fa_listing.about, fa_listing.bid,fa_listing.category as 'cid',fa_listing.subcategory as 'sid',fa_listing.buisnessname,  fa_listing.addline1, fa_listing.addline2, fa_listing.city, fa_listing.state, fa_listing.pin, fa_listing.country, fa_category.name as 'category',fa_subcategory.name as 'subcategory' FROM fa_listing LEFT OUTER JOIN fa_category ON fa_listing.category=fa_category.id LEFT OUTER JOIN fa_subcategory ON fa_listing.subcategory=fa_subcategory.id WHERE fa_listing.user='fa' AND `fa_listing`.bid='$name'")->row(); 
        $query->images=[];
        $query->videos=[];
        $query->ads=[];
        $query->rating=[];
    }

    return $query;
}




public function gettypedropdown()
{
    $type= array(
         "1" => "Starter",
         "2" => "Advanced",
         "3" => "Pro"
        );
    return $type;
}


public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `fa_listing` ORDER BY `id` 
                    ASC")->result();
$return=array(
"" => "Select Option"
);
foreach($query as $row)
{
$return[$row->id]=$row->name;
}
return $return;
}
}
?>

