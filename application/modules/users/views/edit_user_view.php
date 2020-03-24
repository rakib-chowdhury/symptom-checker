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
        <form role="form" action="<?= site_url('user_edit_post') ?>"
              onsubmit="return check_data()" id='user_add_form' class="form-horizontal form-groups-bordered validate"
              method="post">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Edit User Info<br>
                    </div>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="name" data-validate="required"
                                   name="name" placeholder="Ex: John Doe" value="<?= $user_data->name ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last Name<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="last_name" data-validate="required"
                                   name="last_name" placeholder="Ex: Doe" value="<?= $user_data->last_name ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="resolved_date" class="col-sm-3 control-label">Date of Birth</label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker"
                                       id="dob" placeholder="Select a Date"
                                       name="dob" readonly value="<?= isset($user_data->dob) ? $this->basic_lib->format_date_for_view_pages($this->basic_lib->millisecond_to_date($user_data->dob)) : "" ?>"
                                >
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="warranty" class="col-sm-3 control-label">Gender<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <select name="gender" id="gender" class="select2">
                                <option value="1" <?php if($user_data->gender == 1){echo 'selected';} ?>>Male</option>
                                <option value="0" <?php if($user_data->gender == 0){echo 'selected';} ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_type" class="col-sm-3 control-label">User Type<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <select name="user_type[]" id="user_type" class="select2" multiple>
                                <?php if (isset($user_types)): ?>
                                    <?php foreach ($user_types as $row): ?>
                                        <option value="<?= $row->id ?>"<?php if(in_array($row->id, array_column($user_roles, 'role_id'))){echo 'selected';} ?>><?= $row->name ?></option>
                                    <?php endforeach;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="col-sm-3 control-label">Phone Number<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="phone_number"
                                   name="phone_number" data-validate="required"
                                   placeholder="Type User Phone Number" value="<?= $user_data->phone_number ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Type User Email" value="<?= $user_data->email ? $user_data->email : "" ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address</label>

                        <div class="col-sm-5">
                                <textarea class="form-control autogrow" id="address" name="address"
                                          placeholder="Type Address(If Any)"><?= $user_data->address ? $user_data->address : "" ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?= $user_data->id ?>">
                    <input type="hidden" name="user_name" value="<?= $user_name ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-5">
                    <button type="submit" id="submit_btn" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        initialise_datepickers();
    });

    function initialise_datepickers() {
        $("#dob").datepicker({
            format: "dd MM, yyyy"
        }).datepicker('setEndDate', new Date());
    }
</script>
