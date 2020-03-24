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
                    Manage User Group<br>
                </div>
                <br>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <button type="button" onclick="show_add_modal()" class="btn btn-icon icon-left btn-success">Add New User Group <i class="entypo-plus-circled"></i></button>
                </div>
                <table class="table table-bordered datatable" id="user_group_table" width="100%">
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
                        <form action="<?= site_url('user_group_add_post') ?>" class="validate"
                              method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="text-align: center">Add New User Group</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Group Name</label>
                                        <input type="text" name="user_type_name" id="user_type_name" onkeyup="check_user_type_name()" class="form-control" data-validate="required" placeholder="Ex: Admin">
                                        <span id="user_type_name_err"></span>
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
                        <form action="<?= site_url('user_type_edit_post') ?>" class="validate"
                              method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="text-align: center">Edit User Group</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">User Group Name</label>
                                        <input type="text" name="edit_user_type_name" id="edit_user_type_name" onkeyup="check_user_type_name_edit_availability()" class="form-control" data-validate="required" placeholder="Ex: Admin">
                                        <span id="edit_user_type_name_err"></span>
                                    </div>
                                    <input type="hidden" name="edit_user_type_id" id="edit_user_type_id">
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
        var $table1 = jQuery('#user_group_table');

        // Initialize DataTable
        $table1.DataTable({
            "aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
            "bStateSave": false,
            "paging": true,
            "responsive": true,
            dom: 'Bfrtip',
            "ajax": {
                "url": '<?= base_url('get_user_type_data') ?>'
            },
            buttons: [
                {
                    extend: 'copyHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-export"></i>Copy Table Data</button></a>',
                    title: "User Groups",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excelHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-download"></i>Download As Excel</button></a>',
                    title: "User Groups",
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'pdfHtml5', text: '<a><button class="btn btn-primary btn-icon icon-left"><i class="entypo-download"></i>Download As PDF</button></a>',
                    title: "User Groups",
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

    function set_edit_modal(admin_user_type_id, admin_user_type_name) {
        $('#edit_user_type_name').val(admin_user_type_name);
        $('#edit_user_type_id').val(admin_user_type_id);
        $('#edit_modal').modal('show');
    }

    function check_user_type_name() {
        var user_type_name = $('#user_type_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("check_user_type_name");?>',
            data: {
                'user_type_name': user_type_name
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('user_type_name_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    $('#add_btn').prop('disabled', false);
                }
                else {
                    var x = document.getElementById('user_type_name_err');
                    x.style.color = "red";
                    x.style.display = "inline-block";
                    x.style.marginTop = "5px";
                    x.style.fontSize = "12px";
                    x.innerHTML = "User type already exists!<br>";
                    $('#add_btn').prop('disabled', true);
                }
            }
        });
    }

    function check_user_type_name_edit_availability() {
        var user_type_id = $('#edit_user_type_id').val();
        var user_type_name = $('#edit_user_type_name').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("check_user_type_availability");?>',
            data: {
                'user_type_id' : user_type_id,
                'user_type_name': user_type_name
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('edit_user_type_name_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    $('#edit_btn').prop('disabled', false);
                }
                else {
                    var x = document.getElementById('edit_user_type_name_err');
                    x.style.color = "red";
                    x.style.display = "inline-block";
                    x.style.marginTop = "5px";
                    x.style.fontSize = "12px";
                    x.innerHTML = "User type already exists!<br>";
                    $('#edit_btn').prop('disabled', true);
                }
            }
        });
    }
</script>