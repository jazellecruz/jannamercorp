<?php
  ob_start();
  require_once("includes/load.php");
  if(isset($_SESSION["user_id"])) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
  
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
      <img src="uploads/inventory system logo.png" alt="Company Logo" width="65" height="65">
      <h4>SMIS</h4>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name= "password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="branch" class="control-label">Select a branch</label>
            <select name="branch" class="form-control">
                <option selected="selected" disabled>SELECT</option>
                <?php $branches = find_all('branches');?>
                <?php foreach ($branches as $branch) : ?>
                  <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
