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
        <form role="form" action="<?= site_url('user_add_post') ?>"
              onsubmit="return check_data()" id='user_add_form' class="form-horizontal form-groups-bordered validate"
              method="post">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Basic Info<br>
                    </div>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="name" data-validate="required"
                                   name="name" placeholder="Ex: John Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last Name<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="last_name" data-validate="required"
                                   name="last_name" placeholder="Ex: Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="resolved_date" class="col-sm-3 control-label">Date of Birth</label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker"
                                       id="dob" placeholder="Select a Date"
                                       name="dob" readonly
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
                                <option value="1">Male</option>
                                <option value="0">Female</option>
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
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
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
                                   placeholder="Type User Phone Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Type User Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address</label>

                        <div class="col-sm-5">
                                <textarea class="form-control autogrow" id="address" name="address"
                                          placeholder="Type Address(If Any)"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Credentials<br>
                    </div>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="user_name" class="col-sm-3 control-label">User Name<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_name"
                                   name="user_name" data-validate="required"
                                   placeholder="Type User Name" onkeyup="check_user_name()">
                            <span id="user_name_err"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password"
                                   name="password" placeholder="Type Password" data-validate="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Confirm Password<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" placeholder="Re-Type Password"
                                   data-validate="required"
                            >
                            <span id="password_err"></span>
                        </div>
                    </div>
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
    function check_user_name() {
        var user_name = $('#user_name').val();
        $.ajax({
            type: 'POST',
            async: false,
            url: '<?php echo site_url("check_user_name");?>',
            data: {
                'user_name': user_name
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('user_name_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    $('#submit_btn').prop('disabled', false);
                } else {
                    var x = document.getElementById('user_name_err');
                    x.style.color = "red";
                    x.innerHTML = "Email already exists!<br>";
                    $('#submit_btn').prop('disabled', true);
                }
            }
        });
    }
    function check_white_spaces() {
        var user_name = $('#user_name').val();
        if(user_name.indexOf(' ') >= 0){
            var user_error = document.getElementById('user_name_err');
            user_error.style.color = 'red';
            user_error.innerHTML = 'Spaces are not allowed in user name!';
            return false;
        }else{
            var user_error = document.getElementById('user_name_err');
            user_error.style.color = '';
            user_error.innerHTML = '';
            return true;
        }
    }
    function check_password() {
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if(password == confirm_password){
            var pass_error = document.getElementById('password_err');
            pass_error.style.color = '';
            pass_error.innerHTML = "";
            return true;
        }else{
            var pass_error = document.getElementById('password_err');
            pass_error.style.color = 'red';
            pass_error.innerHTML = "Passwords doesn't match!";
            return false;
        }
    }
    
    function check_data() {
        if(check_white_spaces() && check_password()){
            return true;
        }else{
            return false;
        }
    }
</script>
