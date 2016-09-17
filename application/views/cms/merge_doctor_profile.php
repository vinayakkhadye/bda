<html>
<head>
	<title>Merge Doctor Profile</title>
</head>
<body>
	<h1>Merge Doctor</h1>
	<form method="POST" action="<?=BASE_URL?>cms/merge_profile/doctor_post">
		<p><span>Name : </span><input type="text" name="name" value="" placeholder="name"/></p>
		<p><span>Email Id : </span><input type="text" name="email_id" value="" placeholder="email_id"/></p>
		<p><span>Password : </span><input type="password" name="password" value="" placeholder="password"/></p>
		<p><span>Contact Number : </span><input type="text" name="contact_number" value="" placeholder="contact_number"/></p>
		<p>
			<span>Gender : </span> 
			<span>Male : </span> <input type="radio" name="gender" value="m" />
			<span>Female : </span> <input type="radio" name="gender" value="f" />
		</p>
		<p><span>Date Of Birth : </span><input type="text" name="dob" value="" placeholder="YYYY-MM-DD"/></p>
		<p><span>Type Of user : </span><input type="text" name="type" value="" placeholder="Doctor (2)"/></p>
		<p><span>Mobile Verified : </span><input type="text" name="is_verified" value="" placeholder="1 or 0"/></p>
		<p><span>Doctor Id : </span><input type="text" name="doctor_id" value="" placeholder="Id"/></p>
		<p><input type="submit" value="merge"/></p>	
	</form>
</body>
</html>