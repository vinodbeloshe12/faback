<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class advertise_model extends CI_Model
{
public function create($lid,$page,$image,$link,$status,$user)
{
$data=array("lid" => $lid,"page" => $page,"image" => $image,"link" => $link,"status" => $status,"user" => $user);
$query=$this->db->insert( "fa_advertise", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("fa_advertise")->row();
return $query;
}
function getsingleadvertise($id){
$this->db->where("id",$id);
$query=$this->db->get("fa_advertise")->row();
return $query;
}
public function edit($id,$lid,$page,$image,$link,$status,$user)
{
if($image=="")
{
$image=$this->advertise_model->getimagebyid($id);
$image=$image->image;
}
$data=array("lid" => $lid,"page" => $page,"image" => $image,"link" => $link,"status" => $status,"user" => $user);
$this->db->where( "id", $id );
$query=$this->db->update( "fa_advertise", $data );
return 1;
}


public function getAllCategoryById($id){
    $query=$this->db->query("SELECT `id`, `name`, `order`, `image`, `icon` FROM `fa_advertise` WHERE `status`=1 AND `category`='$id'")->result();
    return $query;
}


public function delete($id)
{
$query=$this->db->query("DELETE FROM `fa_advertise` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `fa_advertise` WHERE `id`='$id'")->row();
return $query;
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