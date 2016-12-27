<form action="" method="post">
  <input type="text" name="test" > <input type="submit" name="" />
</form>
<?php
  file_put_contents("php://output", 'name=libai');

  echo file_get_contents("php://input");
?>