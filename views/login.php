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
				 	echo '<div class="alert alert-danger" role="alert"><p>' . $_SESSION['error'] . '</p></div>';
				}
				unset($_SESSION['error']);
			?>
			<div class="row">
				<div class="col-1">
					<a href="index" class="btn btn-dark">بازگشت</a>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-8 col-lg-4">
					<form action="login" method="post">
						<h3>ورود کاربر</h3>
						<hr/>
						<div class="mb-3">
							<label for="email" class="form-label">ایمیل</label>
							<input type="text" id="email" name="email" class="form-control"/>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">رمز عبور</label>
							<input type="password" id="password" name="password" class="form-control"/>
						</div>
						<input type="submit" value="ارسال" class="btn btn-success"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>