<?php
include_once "includes/functions.php";

if (!isset($_SESSION['user']['id'])) {
    header('Location: '. getUrl());
    die;
}

if(isset($_GET['link']) && !empty($_GET['link'])) {
    $short_link = $_GET['link'];

    $link  = getLinkInfo($short_link);
    if(empty($link)|| !isOwnerLink($link['id'])){
        redirectToLink();
    }
}

include_once "includes/header_profile.php";
?>
	<main class="container">

		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Редактирование ссылки.</h2>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
                <form action="<?php echo getUrl('includes/edit.php')?>" method="post">
					<div class="mb-3">
						<label for="link-input" class="form-label">Исправьте или введите новую ссылку </label>
						<input type="text" class="form-control" id="link-input" required name="link" value="<?php echo $link['long_link'] ?>">
					</div>
                    <input type="hidden" name="link_id" value="<?php echo $link['id']?>">
					<button type="submit" class="btn btn-warning">Редактировать</button>
				</form>
			</div>
		</div>
	</main>
<?php require_once "includes/footer.php"?>
