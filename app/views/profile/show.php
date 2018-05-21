<html>
<head>
<title> Profile </title>
<style>
h1 .btn-group { display: inline-block; }
</style>
</head>
<body style="margin-top: 3em;">
	<div class="container">
	<?php 
	include "../app/views/templates/nav.php"; $user = $data['user'];
		$addresses = $data['addresses'];
		   ?>
	<h1>Profile</h1>

	<dl class="dl-horizontal">
		<dt>Title</dt>
		<dd> <?php echo $user['title']; ?> </dd>
		<dt>Name</dt>
		<dd> <?php echo $user['forename'] . ' ' . $user['surname']; ?> </dd>
		<dt>email</dt>
		<dd> <?php echo $user['email']; ?> </dd>
		<dt>Gender</dt>
		<dd> <?php echo $user['gender']; ?> </dd>
		<dt>Date of Birth</dt>
		<dd> <?php echo date("d/m/Y", strtotime($user['dob'])); ?> </dd>
	</dl>
	<a href="/profile/edit" class="btn btn-info" role="button">Edit</a>

	<h1> Addresses
    <small>
        <span class="btn-group">
            <a href="/profile/add" class="btn btn-info" role="button"><span class="glyphicon glyphicon-plus"></span> Add new address</a>
        </span>
    </small>
</h1>
      
	<?php

	if(count($addresses) == 0) {
		?> <p>No address records.</p> <?php
	}

	 foreach ($addresses as $key=>$address) {
	 	$random = rand();
		?>
	
	<div class="panel-group" id="a<?php echo $random ?>">

	<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $random ?>">
        Address Line <?php echo $key+1 ?></a>
      </h4>
    </div>
    <div id="<?php echo $random ?>"class="panel-collapse collapse in">
     <div class="panel-body">
	    <dl class="dl-horizontal">
		<dt>Address Line 1</dt>
			<dd> <?php echo $address['address_line1']; ?> </dd>
		<dt>Address Line 2</dt>
			<dd> <?php echo $address['address_line2']; ?> </dd>
		<dt>Town</dt>
			<dd> <?php echo $address['town']; ?> </dd>
		<dt>County</dt>
			<dd> <?php echo $address['county']; ?> </dd>
		<dt>Country</dt>
			<dd> <?php echo $address['country']; ?> </dd>
		<dt>Postcode</dt>
			<dd> <?php echo $address['postcode']; ?> </dd>
		<dt>From Date</dt>
			<dd> <?php echo date("d/m/Y", strtotime($address['from_date'])); ?> </dd>
		<dt>Until Date</dt>
			<dd> <?php echo date("d/m/Y", strtotime($address['until_date'])); ?> </dd>
		<form action="/profile/edit_address" method="get">
		<input type="hidden" id="aid" name="aid" value="<?php echo $address['id']; ?>">
		<br>
		<input type="submit" class="btn btn-info" value="Edit">
		
		<input type="button" class="btn btn-danger" value="Delete" data-toggle="modal" data-target="#c<?php echo $random ?>">
		<div class="modal" id="c<?php echo $random ?>" tabindex="-1" role="dialog" aria-labelledby="confirmLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
          <h4 class="modal-title">Warning!</h4>
        </div>
      <div class="modal-body">
      	 <p> Are you sure you want to delete this address! </p>
      </div>
      <div class="modal-footer">
      	<button type="button" id="delete" class="btn btn-danger" class="close" data-dismiss="modal" onclick="removeAddress(<?php echo $address['id'] ?>, <?php echo $random ?>)">
      		Yes
      	</button>
        <button type="button" class="btn btn-info" class="close" data-dismiss="modal">No</button>
     </div>
    </div>
  </div>
</div>
		</form>
		</dl> 
	</div>
    </div>
  </div>
</div>
	<?php
	} 
	?>
</div>
<script>
function removeAddress(aid, eid) {
	var address_id = aid;

	$.ajax({
		method: "POST",
		url: "/profile/delete", 
		data: {
			aid: address_id 
		},
		success: function(data) {
			$('#a'+eid).remove();
			}
		});
};
</script>
</body>
</html>