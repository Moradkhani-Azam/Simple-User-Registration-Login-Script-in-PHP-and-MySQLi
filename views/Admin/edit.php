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
				<div class="col-8 col-lg-6">
					<h3>ویرایش</h3>
					<hr/>
					<form action="update" method="post">
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
						<input type="hidden" name="id" value="<?php echo $data['link']->id ?>"/>
						<div class="mb-3">
							<label for="url" class="form-label">لینک</label>
							<input type="text" id="url" name="url" class="form-control" value="<?php echo $data['link']->url ?>"/>
						</div>
						<div class="mb-3">
							<label for="shortened" class="form-label">لینک کوتاه شده</label>
							<input type="text" id="shortened" name="shortened" class="form-control" value="<?php echo $data['link']->shortened ?>"/>
						</div>
						<input type="submit" value="ارسال" class="btn btn-success mt-4"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>