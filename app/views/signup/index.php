<!DOCTYPE html>
<head>
<title> Sign Up </title>
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<!-- <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style> -->
</head>

<body style="margin-top: 3em;">
  <div class="container">
  <?php include "../app/views/templates/nav.php"; ?>
	<h1> Sign Up </h1>

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
	
	<form method="post" action="/signup/create" id="formSignup">

      <div class="form-group">
        <label for="inputTitle"> Title </label>
        <select id="inputTitle" name="title" class="form-control form-control-lg">
        <option>Mr</option>
        <option>Mrs</option>
        <option>Miss</option>
        <option>Ms</option>
        <option>Dr</option>
        </select>
        </div>

    	<div class="form-group">
        <label for="inputForename">Forename</label>
        <input id="inputForename" name="forename" placeholder="Forename" autofocus value="<?php if (isset($data['user'])) { echo $user->forename; }?>" class="form-control" />
      </div>

      <div class="form-group">
        <label for="inputSurname">Surname</label>
        <input id="inputSurname" name="surname" placeholder="Surname" autofocus value="<?php if (isset($data['user'])) { echo $user->surname; }?>" class="form-control" />
      </div>

    	<div class="form-group">
    		<label for="inputEmail">*Email address</label>
    		<input id="inputEmail" name="email" placeholder="email address" value="<?php if (isset($data['user'])) { echo $user->email; }?>" required type="email" class="form-control" />
    	</div>
    	<div class="form-group">
			<label for="inputPassword">*Password</label>
			<input type="password" id="inputPassword" name="password" placeholder="Password" required class="form-control"/>
		</div>
		<div class="form-group">
			<label for="inputPasswordConformation">*Repeat password</label>
			<input type="password" id="inputPasswordConformation" name="password_confirmation" placeholder="Repeat password" required class="form-control" />  
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
       <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" value="<?php if (isset($data['user'])) { echo $user->date; }?>" type="text"/>
      </div>
     </div>   

		<button type="submit" class="btn btn-default">Sign up</button>	
    </form>

  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"> </script>
    <!-- <script src="/js/app.js"></script> -->
  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  <script>
      $(document).ready(function(){
          var date_input=$('input[name="date"]'); //our date input has the name "date"
          var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
          date_input.datepicker({
              format: 'mm/dd/yyyy',
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

       $('#formSignup').validate({
            rules: {
                title: 'required',
                gender: 'required',
                forename: 'required',
                surname: 'required',
                date: 'required',
                email: {
                    required: true,
                    email: true,
                    remote:  '/account/validateEmail'
            },
            password: {
                required:true,
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

