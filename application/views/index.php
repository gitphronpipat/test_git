<!DOCTYPE html>
<html lang="th">

<head>
	<!-- ต้องมีบรรทัดนี้ใน <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<?php
	
	//$this->load->view('admin/theme/header.php');
	?>

	<title>
		<?php 
			echo  $title;	?>
	</title>

</head>
<body>
	<?php $this->load->view('theme/menu'); ?>	
  <?php $this->load->view('theme/navbar'); ?>
  
  <div id="main">

  </div>

</body>
</html>
