<?php
include_once "includes/header.php";
//var_dump($_POST);
if(isset($_POST['login']) && !empty($_POST['login'])) {
    registerUser($_POST);

}
?>

	<main class="container">
		<!--<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
			Все ок
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
			А тут не ок
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>-->
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Регистрация</h2>
				<p class="text-center">Если у вас уже есть логин и пароль, <a href="<?php echo get_url('login.php') ?>">войдите на сайт</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action ="" method="post">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input type="text" class="form-control is-valid" id="login-input" required name="login">
						<div class="valid-feedback">Все ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input type="password" class="form-control is-invalid" id="password-input" required name="pass">
						<div class="invalid-feedback">А тут не ок</div>
					</div>
					<div class="mb-3">
						<label for="password-input2" class="form-label">Пароль еще раз</label>
						<input type="password" class="form-control is-invalid" id="password-input2" required name="pass2">
						<div class="invalid-feedback">И тут тоже не ок</div>
					</div>
					<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
				</form>
			</div>
		</div>
	</main>
<?php
include_once "includes/footer.php"; ?>
