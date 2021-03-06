<div class="row">
   <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
         <h3>Crear Cuenta</h3>
         <p>Ingrese sus Datos</p>
         <form action="<?php echo URL_ROOT; ?>/user/register" method="post">
            <div class="form-group">
               <label for="name">Nombre: <sup>*</sup></label>
               <input type="text" name="name" class="form-control form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['name']; ?>">
               <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group">
               <label for="name">Email: <sup>*</sup></label>
               <input type="email" name="email" class="form-control form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['email']; ?>">
               <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group">
               <label for="name">Contraseña: <sup>*</sup></label>
               <input type="password" name="password" class="form-control form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['password']; ?>">
               <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="form-group">
               <label for="name">Confirmar Contraseña: <sup>*</sup></label>
               <input type="password" name="confirm_password" class="form-control form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : '';?>" value="<?php echo $data['confirm_password']; ?>">
               <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
            </div>
            <div class="row">
               <div class="col">
                  <input type="submit" value="Registrarme" class="btn btn-success btn-block"/>
               </div>
               <div class="col">
                  <a href="<?php echo URL_ROOT; ?>/user/login" class="btn btn-light btn-block">Iniciar Sesión</a>
               </div>
            </div>
         </form>
   </div>
</div>

