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
                    Change Password <br>
                </div>
                <br>
            </div>
            <div class="panel-body">
                <form role="form" action="<?= site_url('password_change_post') ?>"
                      onsubmit="return check_data()"
                      class="form-horizontal form-groups-bordered validate" method="post">
                    <div class="form-group">
                        <label for="old_password" class="col-sm-3 control-label">Old Password<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" data-validate="required"
                                   id="old_password" name="old_password" placeholder="Old Password">
                            <span id="old_password_err"></span>
                        </div>
                    </div>
                    <input type="hidden" name="login_id" id="login_id" value="<?= $_SESSION['login_id'] ?>">
                    <div class="form-group">
                        <label for="new_password" class="col-sm-3 control-label">New Password<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" data-validate="required"
                                   id="new_password" name="new_password"
                                   placeholder="New Password">
                            <span id="new_password_err"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="col-sm-3 control-label">Confirm Password<span
                                    style="color: red">*</span></label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" data-validate="required"
                                   id="confirm_password" name="confirm_password"
                                   placeholder="Confirm Password">
                            <span id="confirm_password_err"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                            <button type="submit" id="myBtn" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var password_status = 0;
    function check_data() {
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        check_old_password();
        if(password_status == 1){
            if (new_password == confirm_password) {
                var x = document.getElementById('confirm_password_err');
                x.style.color = "";
                x.innerHTML = "";
                return true;
            } else {
                var x = document.getElementById('confirm_password_err');
                x.style.color = "red";
                x.innerHTML = "Password Doesn't Match! Please Type Carefully.<br>";
                return false;
            }
        }else {
            return false;
        }
    }

    function check_old_password() {
        var old_password = $('#old_password').val();
        var login_id = $('#login_id').val();
        $.ajax({
            type: 'POST',
            async: false,
            url: '<?php echo site_url("check_old_password");?>',
            data: {
                'login_id': login_id,
                'password': old_password
            },
            success: function (data) {
                if (data == 1) {
                    var x = document.getElementById('old_password_err');
                    x.style.color = "";
                    x.innerHTML = "";
                    password_status = 1;
                } else {
                    var x = document.getElementById('old_password_err');
                    x.style.color = "red";
                    x.innerHTML = "Incorrect Old Password!<br>";
                    return false;
                }
            }
        });
    }
</script>