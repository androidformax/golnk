<?php require_once "includes/header.php";

if(isset($_GET['url']) && !empty($_GET['url']))
{
    $url = strtolower(trim($_GET['url']));

    $link = db_query("SELECT * FROM golnk.links WHERE `short_link` = '$url';")->fetch();
    var_dump($link);

    if(empty($link)){
        echo "Ссылка не найдена.";
        die;
    }
    db_exec("UPDATE links SET views = views + 1 WHERE short_link = '$url';");
    header("Location: " . $link['long_link']);
    die;
}
?>
	<main class="container">
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Необходимо <a href="<?php echo get_url('register.php') ?>">зарегистрироваться</a> или <a href="<?php echo get_url('login.php') ?>">войти</a> под своей учетной записью</h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php echo $usersCount;?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php echo $linksCount;?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php echo $sumViews;?></h2>
			</div>
		</div>
	</main>

<?php require_once "includes/footer.php"?>