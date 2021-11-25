<?php
if(isset($_GET['url']) && !empty($_GET['url'])) {
    include_once "includes/functions.php";
    $url = strtolower(trim($_GET['url']));

    $link = getLinkInfo($url);

    if (empty($link)) {
        header('Location: '. getUrl('404.php'));
        die;
    }
    updateViews($url);
    header('Location: ' . $link['long_link']);
    die;
}
include_once "includes/header.php";
?>
	<main class="container">
        <?php if (!isset($_SESSION['user']['id'])) { ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Необходимо <a href="<?php echo getUrl('register.php') ?>">зарегистрироваться</a> или <a href="<?php echo getUrl('login.php') ?>">войти</a> под своей учетной записью</h2>
			</div>
		</div>
        <?php } ?>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php if (isset($usersCount)) {
                        echo $usersCount;
                    } ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php if (isset($linksCount)) {
                        echo $linksCount;
                    } ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php if (isset($sumViews)) {
                        echo $sumViews;
                    } ?></h2>
			</div>
		</div>
	</main>

<?php require_once "includes/footer.php"?>