<a href="<?php echo URL_ROOT; ?>/post" class="btn btn-light"><i class="fa fa-backward"></i> Volver</a>
<div class="card card-body bg-light mt-5">
   <h3>Editar</h3>
   <p>Editar Publicación</p>
   <form action="<?php echo URL_ROOT; ?>/post/edit/<?php echo $data['id']; ?>" method="post">
      <div class="form-group">
         <label for="title">Titulo: <sup>*</sup></label>
         <input type="text" name="title" class="form-control form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['title']; ?>">
         <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
         <label for="name">Cuerpo: <sup>*</sup></label>
         <textarea name="body" rows="<?php substr_count( $data['body'], "\r\n" ); ?>" class="form-control form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
         <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Guardar"/>
   </form>
</div>