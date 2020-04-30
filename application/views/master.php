<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $main['title']; ?></title>
  <?php $this->load->view('layouts/head') ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">

		<!-- navbar -->
			<?php $this->load->view('layouts/navbar')?>
		<!-- END navbar -->
		
		<!-- sidebar -->
			<?php echo $main['sidebar']; ?>
		<!-- END sidebar -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- pages -->
			<?php echo $main['pages']; ?>
			<!-- END pages -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		<!-- footer -->
		<?php $this->load->view('layouts/footer')?>
		<!-- END footer -->
	</div>
	<!-- ./wrapper -->

	<!-- javascript -->
	<?php $this->load->view('layouts/javascript')?>
	<!-- END javascript -->

</body>
</html>
