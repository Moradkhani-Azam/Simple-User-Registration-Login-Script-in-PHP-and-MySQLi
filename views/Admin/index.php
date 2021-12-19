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
		<div class="container">
			<div class="row">
				<div class="col-1 my-4">
					<a href="../../logout" class="btn btn-dark">خروج</a>
				</div>
			</div>

			<div class="row justify-content-center mx-5">
				<div class="col-lg-8">
					<h3>دامنه ها</h3>
					<hr class="w-100"/>
					<section class="w-100">
						<?php foreach($data["links"] as $link) {?>
						<?php echo $link["id"]; ?> -
						<?php echo $link["url"]; ?> -
						<?php echo $link["shortened"]; ?>
						<div class="d-flex justify-content-between mt-4">
							<a href="edit?&id=<?php echo $link['id']; ?>" class="btn btn-info">جزئیات</a>
							<form action="destroy" method="post" onsubmit="return confirm('آیا مطمئن هستید؟');">
								<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
								<input type="hidden" name="id" value="<?php echo $link['id']; ?>">
								<input type="submit" value="حذف" class="btn btn-danger"/>
							</form>
						</div>
						<hr/>
						<?php } ?>
					</section>
				</div>
				<div class="col-1">
					<a href="create" class="btn btn-success">ایجاد</a>
				</div>
			</div>
		</div>
	</body>
</html>