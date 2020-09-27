<?php require APP_ROUTE . '/views/inc/header.php'; ?>
<br>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo APP_URL ?>page" class="btn btn-dark"><i class="fa fa-backward"></i> Volver</a>
        <div class="card card-body badge-light mt-5">
            <h2>Editar Libro</h2>
            <form action="<?php echo APP_URL ?>page/edit/<?php echo $data['id']?>" method="post">
            <div class="form-group">
                <label for="title">Titulo <sup>*</sup></label>
                <input type="text" name="title" value="<?php echo $data['title']?>" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="title">Descripción <sup>*</sup></label>
                <input type="text" name="description" value="<?php echo $data['description']?>" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="title">Autor <sup>*</sup></label>
                <input type="text" name="author" value="<?php echo $data['author']?>" class="form-control form-control-lg">
            </div>
            <div class="form-group">
                <label for="title">Precio <sup>*</sup></label>
                <input type="text" name="price" value="<?php echo $data['price']?>" class="form-control form-control-lg">
            </div>
            <input type="submit" class="btn btn-success" value="Editar Libro">
            </form>
        </div>
    </div>
</div>
<?php require APP_ROUTE . '/views/inc/footer.php'; ?>