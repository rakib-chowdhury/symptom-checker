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
                    Manage Permissions<br>
                </div>
                <br>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <button type="button" onclick="show_add_modal()" class="btn btn-success">Add New Permission</button>
                </div>
                <table class="table table-bordered datatable" id="permission_table" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div id="add_modal" class="modal fade"
                     role="dialog" tabindex="-1">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <form action="<?= site_url('permission_add_post') ?>" class="validate"
                              method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="text-align: center">Add New Permission</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Permission Name</label>
                                        <input type="text" name="name" id="name" onkeyup="check_permission_name()" class="form-control" data-validate="required">
                                        <span id="name_err"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="add_btn">Submit</button>
                                    <button type="button" class="btn btn-white"
                                            data-dismiss="modal">No
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="edit_modal" class="modal fade"
                     role="dialog" tabindex="-1">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <form action="<?= site_url('permission_edit_post') ?>" class="validate"
                              method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="text-align: center">Edit Permission</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Permission Name</label>
                                        <input type="text" name="edit_permission_name" id="edit_permission_name" onkeyup="check_permission_edit_availability()" class="form-control" data-validate="required">
                                        <span id="edit_permission_name_err"></span>
                                    </div>
                                    <input type="hidden" name="edit_permission_id" id="edit_permission_id">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="edit_btn" class="btn btn-success">Submit</button>
                                    <button type="button" class="btn btn-white"
                                            data-dismiss="modal">No
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>public/assets/backend/js/datatables/datatables.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var $table1 = jQuery('#permission_table');

        // Initialize DataTable
        $table1.DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": false,
            "paging": true,
            "responsive": true,
            dom: 'Bfrtip',
            "ajax": {
                "url": '<?= base_url('get_permissions_data') ?>'
            },
            buttons: [
                {
                    extend: 'copyHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-export"></i>Copy Table Data</button></a>',
                    title: "Permission List",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excelHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-download"></i>Download As Excel</button></a>',
                    title: "Permission List",
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'pdfHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-download"></i>Download As PDF</button></a>',
                    title: "Permission List",
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                }
            ]
        });

        // Initalize Select Dropdown after DataTables is created
        $table1.closest('.dataTables_wrapper').find('select').select2({
            minimumResultsForSearch: -1
        });
    });
    function show_add_modal(){
        $('#add_modal').modal('show');
    }

    function set_edit_modal(permission_id, permission_name) {
        $('#edit_permission_name').val(permission_name);
        $('#edit_permission_id').val(permission_id);
        $('#edit_modal').modal('show');
    }

    function check_permission_name() {
        var permission_name = $('#name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("check_permission_name");?>',
            data: {
                'permission_name': permission_name
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('name_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    $('#add_btn').prop('disabled', false);
                }
                else {
                    var x = document.getElementById('name_err');
                    x.style.color = "red";
                    x.innerHTML = "Permission already exists!<br>";
                    $('#add_btn').prop('disabled', true);
                }
            }
        });
    }

    function check_permission_edit_availability() {
        var permission_id = $('#edit_permission_id').val();
        var permission_name = $('#edit_permission_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("check_permission_availability");?>',
            data: {
                'permission_id' : permission_id,
                'permission_name': permission_name
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('edit_permission_name_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    $('#edit_btn').prop('disabled', false);
                }
                else {
                    var x = document.getElementById('edit_permission_name_err');
                    x.style.color = "red";
                    x.innerHTML = "Permission already exists!<br>";
                    $('#edit_btn').prop('disabled', true);
                }
            }
        });
    }
</script>