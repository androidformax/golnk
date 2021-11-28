<?php
include_once "includes/functions.php";

if (!isset($_SESSION['user']['id'])) {
    header('Location: '. getUrl());
    die;
}

$links = getUserLinks($_SESSION['user']['id']);

$error = getMassage('error');
$success = getMassage('success');

include_once "includes/header_profile.php";
?>

	<main class="container">
        <?php
        showMessage($success, 'success');
        showMessage($error);
        ?>
		<div class="row mt-5">
            <?php if($links) { ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ссылка</th>
						<th scope="col">Сокращение</th>
						<th scope="col">Переходы</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
                <?php  foreach ($links as $index => $link) { ?>
					<tr>
						<th scope="row"><?php  echo $index + 1 ?></th>
						<td><a href="<?php  echo $link['long_link'] ?>" target="_blank"><?php  echo $link['long_link'] ?></a></td>
                        <td><a href="#" class="btn btn-primary btn-sm copy-btn" title="Скопировать в буфер" data-clipboard-text="<?php  echo HOST . '/' . $link['short_link'] ?>"><i class="bi bi-files"></i></a>
                            <a href="<?php  echo $link['short_link'] ?>" target="_blank"><?php  echo HOST . '/' . $link['short_link'] ?></a></td>
                        <!--<td class="short-link"><?php /*echo getUrl($link['short_link']); */?></td> // вариант без подсетки ссылки-->
						<td><?php  echo $link['views'] ?></td>
						<td>
							<a href="<?php  echo getUrl('editlink.php?link=' . $link['short_link']); ?>" class="btn btn-warning btn-sm" title="Редактировать"><i class="bi bi-pencil"></i></a>
							<a href="<?php  echo getUrl('delete.php?id=' . $link['id']); ?>" class="btn btn-danger btn-sm" title="Удалить"><i class="bi bi-trash"></i></a>
						</td>
					</tr>
                <?php  } ?>
				</tbody>
			</table>
			<?php } else { ?>
			<div class="col">
			<h3 class="text-center">У вас пока нет ни одной ссылки.</h3>
			</div>
			<?php } ?>
		</div>
	</main>
	<div aria-live="polite" aria-atomic="true" class="position-relative">
		<div class="toast-container position-absolute top-0 start-50 translate-middle-x">
			<div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						Ссылка скопирована в буфер
					</div>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer_profile.php"; ?>
