<style>
    .ms-container .ms-list {
        width: 270px !important;
        height: 270px !important;
    }
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    Manage Permissions<br>
                </div>
                <br>
            </div>
            <div class="panel-body">
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
                <form role="form" method="post" action="<?= site_url('group_permission_add_post') ?>"
                      class="form-horizontal form-groups-bordered">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Permission List</label>

                        <div class="col-sm-7">
                            <select multiple="multiple" name="permission_id[]" class="form-control multi-select">
                                <?php if(isset($permissions)): ?>
                                    <?php foreach ($permissions as $row): ?>
                                        <option value="<?= $row->permission_id ?>"<?php if(in_array($row->permission_id, array_column($user_permissions, 'group_permission_id'))){echo 'selected';} ?>><?= $row->permission_name ?></option>
                                    <?php endforeach;endif; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="user_type_id" name="user_type_id" value="<?= $type_id ?>">
                    <div class="form-group">
                        <div class="col-md-offset-5">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>public/assets/backend/js/select2/select2.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/backend/js/jquery.multi-select.js"></script>
<script type="text/javascript">

</script>