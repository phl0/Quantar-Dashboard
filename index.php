<?php include('quantar.php'); ?>
<?php include('internals/layout/meta.php'); ?>
    <!-- AJAX Content Refresh -->
    <!-- Uptime -->
    <script type="text/javascript">
      <?php include('config/intervals.php'); ?>
      function updateKernel(){
	$('#dashboard-kernel').html('<?php echo exec('uname -r'); ?>');
      }
    </script>

  </head>

  <body>

    <?php include('internals/layout/navbar.php'); ?>

    <div class="container">

      <div class="row">
        <span class="span6">
	  <h2>Exciter / PA Information</h2>
	  <table class="table">
	    <thead>
	      <th><span class="color">Property</span></th>
	      <th><span class="color">Value</span></th>
	    </thead>
            <?php
               foreach ($values as $key => $value) {
                 print "<tr>\n";
                 print "<td>{$key}:</td>\n";
                 print "<td id=\"dasboard-{$key}\">{$value}</td>\n";
                 print "</tr>\n";
               }
             ?>
	  </table>
	</span>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>

