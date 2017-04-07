<?php $option = (isset($_GET['option'])) ? $_GET['option'] : "part1"; ?>
<html>
<head><title>BookPlace</title></head>
<body>
	<h2>Welcome to the BookPlace!</h2>
	<p>How would you like to start?</p>
	<div>
		<h3>Sign In</h3>
		<p>Sign in to view your personalized cart, shopping history and book ratings.</p>
		<a href="">Sign In</a>
		<a href="">Sign Up</a>
	</div>
	<h3>OR</h3>
	<div>
		<h3>Continue as Guest</h3>
		<p>Try BookPlace without becoming a member.</p>
		<a href="guest.php">Continue as Guest</a>
	</div>
</body>
</html>