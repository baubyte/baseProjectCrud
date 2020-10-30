<?php require APP_ROOT . '/views/inc/header.php' ?>
<a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Volver</a>
<br/>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
Escrito por <?php echo $data['user']->name ?> el <?php echo helper_format_date($data['post']->created_at); ?>
</div>
<p class="breakline"><?php echo $data['post']->body; ?></p>
<?php if( $data['post']->user_id == $_SESSION['user_id']) : ?>
<hr>
<a href="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Editar</a>
<form class="pull-right" action="<?php echo URL_ROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
<input type="submit" value="Borrar" class="btn btn-danger">
</form>
<?php endif; ?>
<?php require APP_ROOT . '/views/inc/footer.php' ?>
