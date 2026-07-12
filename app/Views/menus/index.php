<!-- MAIN -->
<?= $this->include('layout/main') ?>
<!-- MAIN END -->

<!-- CSS -->
<!-- INTERNAL  DATA TABLE CSS-->
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>/teamplate/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />
<!-- CSS END -->

<!-- MAIN -->
<?= $this->include('layout/body') ?>
<!-- MAIN END -->                
 <!--app-content open-->
<div class="app-content">
	<div class="side-app">

		<!-- PAGE-HEADER -->
		<div class="page-header">
			<div>
				<h1 class="page-title">MENU</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Table</a></li>
					<li class="breadcrumb-item active" aria-current="page">Menu</li>
				</ol>
			</div>
			<div class="ml-auto pageheader-btn">
				<a href="<?=base_url()?>/menus/create" class="btn btn-primary btn-icon text-white">
					<span>
						<i class="fe fe-plus"></i>
					</span> Add Menu
				</a>
			</div>
		</div>
		<!-- PAGE-HEADER END -->
		 
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header bg-primary">
						<h3 class="card-title">Data Menu</h3>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="dataTbls" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
								<thead>
									<tr>
										<th>PARENT</th>
										<th>PAGE</th>
										<th>SEQUENCE</th>
										<th>ACTIONS</th>
										<th>CREATED DATE</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ROW-4 CLOSED-->
		

	</div>
</div>
<!-- FOOTER -->
<?= $this->include('layout/footers') ?>
<!-- FOOTER END -->

<!-- INTERNAL  DATA TABLE JS-->
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/teamplate/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<script type="text/javascript">
$(function(e) {
    $('#dataTbls').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url() ?>/menus/datatables", // endpoint backend
            type: 'POST'
        },
        "order": [
            [0, 'desc']
        ],
        columns: [{
                data: 'parent'
            },
            {
                data: 'page'
            },
            {
                data: 'sequence'
            },
			{
                data: 'actions'
            },
            {
                data: 'created_date'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
