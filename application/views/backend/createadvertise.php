<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create advertise</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createadvertisesubmit");?>' enctype= 'multipart/form-data'>

<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("lid",$lid,set_value('lid'));?>
<label>Listing Id</label>
</div>
</div>
<div class="row">
<!-- <span>400px X 400px</span> -->
<div class="file-field input-field col s12 m6">
<div class="btn blue darken-4">
<span>Image</span>
<input type="file" name="image">
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload one or more files" value='<?php echo set_value('image');?>'>
</div>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("pagedrp",$pagedrp,set_value('pagedrp'));?>
<label>page</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="link">link</label>
<input type="text" id="link" name="link" value='<?php echo set_value('link');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="fromDate">From Date</label>
<input type="date" id="fromDate" name="fromDate" value='<?php echo set_value('fromDate');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="toDate">To Date</label>
<input type="date" id="toDate" name="toDate" value='<?php echo set_value('toDate');?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("status",$status,set_value('status'));?>
<label>status</label>
</div>
</div>

<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewadvertise"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
