<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit advertise</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editadvertisesubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">

<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("lid",$lid,set_value('lid',$before->lid));?>
<label>Listing Id</label>
</div>
</div>
<div class="row">
<!-- <span>400px X 400px</span> -->
<div class="file-field input-field col m6 s12">
    <span class="img-center big image">
                   <?php if ($before->image == '') {
} else {
?><img src="<?php echo base_url('uploads').'/'.$before->image;
?>">
            <?php
} ?></span>
    <div class="btn blue darken-4">
        <span>Image</span>
        <input name="image" type="file">
    </div>
    <div class="file-path-wrapper">
        <input class="file-path validate image1" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image', $before->image);?>">
    </div>
</div>

</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("pagedrp",$pagedrp,set_value('pagedrp',$before->pagedrp));?>
<label>page</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="link">link</label>
<input type="text" id="link" name="link" value='<?php echo set_value('link',$before->link);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="fromDate">From Date</label>
<input type="date" id="fromDate" name="fromDate" value='<?php echo set_value('fromDate',$before->fromDate);?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="toDate">To Date</label>
<input type="date" id="toDate" name="toDate" value='<?php echo set_value('toDate',$before->toDate);?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("status",$status,set_value('status',$before->status));?>
<label>status</label>
</div>
</div>
<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewadvertise"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
