<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo "<script type='text/javascript'>alert('$error');</script>"; ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>