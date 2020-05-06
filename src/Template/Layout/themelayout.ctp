<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->Html->charset(); ?>

	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Demo project">
	<meta name="viewport" content="width=device-width, initial-scale=1"><?= $this->Html->css("bootstrap4/bootstrap.min.css"); ?>
	<?= $this->Html->css("https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>

	<?= $this->Html->css("/css/plugins/OwlCarousel2-2.2.1/owl.carousel.css"); ?>
	<?= $this->Html->css("/css/plugins/OwlCarousel2-2.2.1/owl.theme.default.css"); ?>
	<?= $this->Html->css("/css/plugins/OwlCarousel2-2.2.1/animate.css"); ?>
	<?= $this->Html->css("/css/plugins/jquery.mb.YTPlayer-3.1.12/jquery.mb.YTPlayer.css"); ?>

	<?= $this->Html->css("sb-admin-2.min.css"); ?>
	<?= $this->Html->css("main_styles.css"); ?>

	<?= $this->Html->css("responsive.css"); ?>

	<?= $this->Html->css("/css/bootstrap4/bootstrap.min.css"); ?>
	<?= $this->Html->script("https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"); ?>



	<style>

		.hidden{
			display:none;

		}



	</style>

	<script>
		var input = document.getElementById("search");
		input.addEventListener("keyup", function(event) {
			if (event.keyCode === 13) {
				event.preventDefault();
				$("#searchform").submit();
			}
		});

	</script>
</head>
<body>

<div class="super_container">

	<!-- Header -->





	<?= $this->Flash->render() ?>

	<?= $this->fetch('content') ?>


</div>


<?= $this->Html->script("/js/jquery.mb.YTPlayer.js"); ?>
<?= $this->Html->script("/js/bootstrap/popper.js"); ?>
<?= $this->Html->script("/js/bootstrap/bootstrap.min.js"); ?>
<?= $this->Html->script("/js/owl.carousel.js"); ?>

<?= $this->Html->script("/js/easing.js"); ?>

<?= $this->Html->script("/js/masonry.js"); ?>
<?= $this->Html->script("/js/custom.js"); ?>

<?= $this->Html->script("/js/parallax.min.js"); ?>
<?= $this->Html->script("/js/post.js"); ?>
</body>
</html>
