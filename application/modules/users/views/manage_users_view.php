<link rel="stylesheet" href="<?php echo base_url() ?>public/assets/backend/js/datatables/datatables.css">
<div class="row">
    <div class="col-md-12">
		<?php if ($this->session->flashdata('success_msg')) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<strong><?= $this->session->flashdata('success_msg'); ?></strong>
					</div>
				</div>
			</div>
		<?php }
		if ($this->session->flashdata('error_msg')) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<strong><?= $this->session->flashdata('error_msg'); ?></strong>
					</div>
				</div>
			</div>
		<?php } ?>
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    Manage User Info<br>
                </div>
                <br>
            </div>
            <div class="panel-body">
                <table class="table table-bordered datatable" id="user_info_table" width="100%">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Dob</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
						<?php if($this->basic_lib->check_permission('delete_user') ||
						$this->basic_lib->check_permission('edit_user') ||
							$this->basic_lib->check_permission('change_user_status') ||
								$this->basic_lib->check_permission('reset_user_password')) : ?>
                        <th>Action</th>
						<?php endif; ?>
					</tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>public/assets/backend/js/datatables/datatables.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        initialise_user_info_table();
    });
    function initialise_user_info_table(){
        var $table1 = jQuery('#user_info_table');

        // Initialize DataTable
        $table1.DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": false,
            "paging": true,
            "responsive": true,
            "ajax": {
                "url": '<?= base_url('get_users_data') ?>'
            }
        });

        // Initalize Select Dropdown after DataTables is created
        $table1.closest('.dataTables_wrapper').find('select').select2({
            minimumResultsForSearch: -1
        });
    }
</script>

