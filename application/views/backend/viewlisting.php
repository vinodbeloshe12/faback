<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable">
<?php $this->chintantable->createsearch("listing");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">id</th>
<th data-field="buisnessname">buisnessname</th>
<th data-field="city">city</th>
<th data-field="status">status</th>
<th data-field="type">type</th>
<th data-field="type">date</th>

</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
<div class="createbuttonplacement"><a class="btn-floating btn-large waves-effect waves-light blue darken-4 tooltipped" href="<?php echo site_url("site/createlisting"); ?>"data-position="top" data-delay="50" data-tooltip="Create"><i class="material-icons">add</i></a></div>
</div>
</div>
<script>
function drawtable(resultrow) {
    if(resultrow.status==1){
        var status="Enabled";
        var loginbtn="<a class='btn btn-primary' href='<?php echo site_url('site/sendPassword?bid=');?>"+resultrow.bid+"' data-position='top' data-delay='50' data-tooltip='Send Login'><i class='fa fa-key propericon'></i></a>";
    }else{
        var loginbtn="";
        var status="Disabled";
    }
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.buisnessname + "</td><td>" + resultrow.city + "</td><td>" + status + "</td><td>" + resultrow.type + "</td><td>" + resultrow.date + "</td><td><a class='btn btn-primary btn-xs waves-effect waves-light blue darken-4 z-depth-0 less-pad' href='<?php echo site_url('site/editlisting?id=');?>"+resultrow.id+"' data-position='top' data-delay='50' data-tooltip='Edit'><i class='fa fa-pencil propericon'></i></a><a class='btn btn-danger btn-xs waves-effect waves-light red pad10 z-depth-0 less-pad' onclick=\"return confirm('Are you sure you want to delete?');\") href='<?php echo site_url('site/deletelisting?id='); ?>"+resultrow.id+"' data-position='top' data-delay='50' data-tooltip='Delete'><i class='material-icons propericon'>delete</i></a>"+ loginbtn +"</td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
