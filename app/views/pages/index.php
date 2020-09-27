<?php require APP_ROUTE . '/views/inc/header.php'; ?>
<br>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-dark">
            <thead>
                <tr class="bg-success">
                    <th scope="col">#</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Precio</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($data['books'] as $key => $book):
            ?>
                <tr>
                    <th scope="row"><?php echo $key+1?></th>
                    <td><?php echo $book->title?></td>
                    <td><?php echo $book->description?></td>
                    <td><?php echo $book->author?></td>
                    <td>$ <?php echo $book->price?></td>
                    <td><a href="<?php echo APP_URL?> page/edit/<?php echo $book->id?>">Editar</a></td>
                    <td><a href="<?php echo APP_URL?> page/destroy/<?php echo $book->id?>">Borrar</a></td>
                </tr>
            <?php
            endforeach
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APP_ROUTE . '/views/inc/footer.php'; ?>