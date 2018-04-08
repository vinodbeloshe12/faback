<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create listing</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createlistingsubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="buisnessname">buisness id</label>
<input type="text" id="bid" name="bid" value='<?php echo set_value('bid');?>'>
</div>
</div>

<div class="row">
<div class="input-field col s6">
<label for="buisnessname">buisnessname</label>
<input type="text" id="buisnessname" name="buisnessname" value='<?php echo set_value('buisnessname');?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("category",$category,set_value('category'));?>
<label>category</label>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("subcategory",$subcategory,set_value('subcategory'));?>
<label>subcategory</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="cperson">cperson</label>
<input type="text" id="cperson" name="cperson" value='<?php echo set_value('cperson');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="contact">contact</label>
<input type="text" id="contact" name="contact" value='<?php echo set_value('contact');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="addline1">addline1</label>
<input type="text" id="addline1" name="addline1" value='<?php echo set_value('addline1');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="addline2">addline2</label>
<input type="text" id="addline2" name="addline2" value='<?php echo set_value('addline2');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="city">city</label>
<input type="text" id="city" name="city" value='<?php echo set_value('city');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="state">state</label>
<input type="text" id="state" name="state" value='<?php echo set_value('state');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="pin">pin</label>
<input type="text" id="pin" name="pin" value='<?php echo set_value('pin');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="country">country</label>
<input type="text" id="country" name="country" value='<?php echo set_value('country');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s12">
<textarea name="keywords" class="materialize-textarea" length="400"><?php echo set_value( 'keywords');?></textarea>
<label>keywords</label>
</div>
</div>
<div class="row">
<div class="input-field col s12">
<textarea name="about" class="materialize-textarea" length="400"><?php echo set_value( 'about');?></textarea>
<label>about</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="email">email</label>
<input type="text" id="email" name="email" value='<?php echo set_value('email');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="facebook">facebook</label>
<input type="text" id="facebook" name="facebook" value='<?php echo set_value('facebook');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="twitter">twitter</label>
<input type="text" id="twitter" name="twitter" value='<?php echo set_value('twitter');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="google">google</label>
<input type="text" id="google" name="google" value='<?php echo set_value('google');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="linkedin">linkedin</label>
<input type="text" id="linkedin" name="linkedin" value='<?php echo set_value('linkedin');?>'>
</div>
</div>
<div class=" row">
<div class=" input-field col s6">
<?php echo form_dropdown("status",$status,set_value('status'));?>
<label>status</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<?php echo form_dropdown("type",$type,set_value('type'));?>
<label for="type">type</label>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="user">user</label>
<input type="text" id="user" name="user" value='<?php echo set_value('user');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewlisting"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
