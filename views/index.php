<!DOCTYPE HTML>
<html dir="rtl">
	<head>
		<meta charset="utf-8"/>
		<title>سیستم کوتاه کردن لینک و افزودن دامنه</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>
	<body>
		<div class="container mt-4">
			<?php
				if(isset($_SESSION['error'])) {
					echo '<div class="alert alert-danger" role="alert">';
					foreach($_SESSION['error'] as $errors)
						foreach($errors as $error)
				 	echo '<p>' . $error . '</p>';
				 echo '</div>';
				}
				unset($_SESSION['error']);
			?>
			<div class="row">
				<div class="col-1">
					<a href="loginPage" class="btn btn-dark">ورود</a>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-8 col-lg-4">
					<form action="register" method="post">
						<h3>ثبت نام</h3>
						<hr/>
						<div class="mb-3">
							<label for="name" class="form-label">نام</label>
							<input type="text" id="name" name="name" class="form-control"/>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">ایمیل</label>
							<input type="text" id="email" name="email" class="form-control"/>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">رمزعبور</label>
							<input type="password" id="password" name="password" class="form-control"/>
						</div>
						<input type="submit" value="ارسال" class="btn btn-success"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>