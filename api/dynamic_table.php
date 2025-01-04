

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<div class="app-body">

<div class="padding">
  <div class="row">
    <div class="col-md-12">
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </tfoot>
    </table>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "server_processing.php"
    } );
} );
</script>

    </div>
    </div>
  </div>

<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->
  