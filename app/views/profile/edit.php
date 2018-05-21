<!DOCTYPE html>
<head>
<title> Profile </title>
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
</head>

<body style="margin-top: 3em;">
  <div class="container">
  <?php include "../app/views/templates/nav.php"; ?>
	<h1> Profile </h1>

	<?php 

  if (isset($data['user'])) {
	$user = $data['user'];
	

	if($user->errors != null) {
		?> <p> Errors: </p>
		   <ul> 
		   	<?php
		   	  foreach ($user->errors as $errors) {
		   	  	?> <li> <?php echo "$errors <br>" ?> </li> <?php
		   	}
		   	?> </ul>
		   	<?php }
		   	}
		   	?>
	
	<form method="post" id="formProfile" action="/profile/update">

    <input type="hidden" name="settitle" id="settitle" value="<?php echo $user['title']; ?>">

    <div class="form-group">
        <label for="inputTitle"> Title </label>
        <select id="inputTitle" name="title" class="form-control form-control-lg">
        <option>Mr</option>
        <option selected="selected">Mrs</option>
        <option>Miss</option>
        <option>Ms</option>
        <option>Dr</option>
        </select>
      </div>

    	<div class="form-group">
    		<label for="inputName">Forename</label>
    		<input id="inputName" name="forename" placeholder="Forename" value="<?php if (isset($data['user'])) { echo $user->forename; }?>" required class="form-control" />
    	</div>
      <div class="form-group">
        <label for="inputSurname">Surname</label>
        <input id="inputSurname" name="surname" placeholder="Surname" autofocus value="<?php if (isset($data['user'])) { echo $user->surname; }?>" class="form-control" />
      </div>
    	<div class="form-group">
    		<label for="inputEmail">Email address</label>
    		<input id="inputEmail" name="email" placeholder="email address" value="<?php if (isset($data['user'])) { echo $user->email; }?>" required type="email" class="form-control"/>
    	</div>
    	<div class="form-group">
			<label for="inputPassword">Password</label>
			<input type="password" id="inputPassword" name="password" placeholder="Password" aria-describedby="helpBlock" class="form-control" />
      <span id="helpBlock" class="help block">Leave blank to keep current password</span>
		</div>
		<div class="form-group">
			<label for="inputPasswordConformation">Repeat password</label>
			<input type="password" id="inputPasswordConformation" name="password_confirmation" placeholder="Repeat password" class="form-control"/>  
		</div>

    <div class="form-group">
    <label for="inputGender">Gender</label> <br />
    <label class="radio-inline"><input type="radio" id="inputMale" name="gender" <?php if (isset($data['user']) && $user->gender=="Male") {echo "checked";}?> value="Male"> Male </label>
    <label class="radio-inline"><input type="radio" id="inputFemale" name="gender" <?php if (isset($data['user']) && $user->gender=="Female") {echo "checked";}?> value="Female"> Female </label>
    </div>

    <div class="form-group">
      <label class="control-label " for="date">
       Date
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-calendar">
        </i>
       </div>
       <input class="form-control" id="date" name="date" placeholder="DD/MM/YYYY" value="<?php if (isset($data['user'])) { echo date("d/m/Y", strtotime($user->dob)); }?>" type="text"/>
      </div>
     </div>

    <input type="hidden" id="uid" name="userid" value="<?php echo $user->id; ?>">

		<button type="submit" class="btn btn-default">Save</button>	
    <a href="/profile/show">Cancel</a>
    </form>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"> </script>
  <!-- <script src="/js/app.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  <script>
     $(document).ready(function(){
          var date_input=$('input[name="date"]'); //our date input has the name "date"
          var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
          date_input.datepicker({
              format: 'dd/mm/yyyy',
              container: container,
              todayHighlight: true,
              autoclose: true,
          })
      });

    $.validator.addMethod('validPassword',
            function(value, element, param) {
                if (value != '') {
                    if (value.match(/.*[a-z]+.*/i) == null) {
                        return false;
                    }
                    if (value.match(/.*\d+.*/) == null) 
                    {
                        return false;
                    }
                }

                return true;
            },
            'Must contain at least one letter and one number'
        );
    
  	$(document).ready(function() {

      SelectElement("inputTitle", document.getElementById("settitle").value);
          function SelectElement(id, value) {
            var e = document.getElementById(id);
            e.value = value;

          }

      var userId = $('#uid').val();

       $('#formProfile').validate({
            rules: {
                forename: 'required',
                surname: 'required',
                gender: 'required',
                date: 'required',
                email: {
                    required: true,
                    email: true,
                    remote:  {
                      url: '/account/validateEmail',
                      data: {
                        ignore_id: function() {
                          return userId;
                        }
                    }
                }
            },
            password: {
                minlength: 6,
                validPassword: true
                },
             password_confirmation: {
                equalTo: '#inputPassword'
             }
           },
           messages: {
           		 email: {
           			   remote: 'email already taken'
           		}
           	}   
        });
    });
</script>
</body>
</div>
</html>