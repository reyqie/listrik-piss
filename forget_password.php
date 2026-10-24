<?php
	session_start();
	include "connection.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-search fa-fw"></i>&nbsp;Lupa Password</h4>
	<button style="margin-top: 0px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form class="form-horizontal" id="formForgotPassword" name="formForgotPassword" method="POST">
		<div class="form-group" style="padding: 0 10px; margin-left:10px; margin-right: 10px;">
			<label>Pilih Role</label>
			<select class="form-control" id="role" name="role" required>
				<option value="" >- Pilih Role -</option>
				<option value="spv" >SPV</option>
				<option value="pp" >PP</option>
				<option value="cashier" >Kasir</option>
			</select>
		</div>
		<div class="form-group" style="padding: 0 10px; margin-left:10px; margin-right: 10px;">
			<label>Username</label>
			<input type="text" class="form-control username" id="username" name="username" placeholder="Masukkan username" required>  
		</div>
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-bottom: 20px;">
			<button id="submitForgot" type="submit" class="btn btn-outline btn-primary btn-block btn-sm" style="font-size: 14px;">
				<i id="btnIcon" class="fa fa-search fa-fw" style="font-size: 16px;"></i>
				<span id="btnText">Lupa Password</span>
			</button>
		</div>
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-top:-10px;">
			<label>Password <i id="passwordIcon" class="fa "></i></label>
			<input type="text" class="form-control" id="passwordResult" name="passwordResult" placeholder="Password akan muncul disini" autofocus="autofocus" disabled>  
		</div>
	</form>
</div>

<style>
	.username:focus {
		border: 2px solid #6c757d;
		box-shadow: 0 0 1px rgba(108, 117, 125, 0.6);
		outline: none;
	}

    .is-success {
        border: 2px solid #28a745;
        background-color: #d4edda;
        color: #28a745;
    }

    .is-error {
        border: 2px solid #dc3545;
        background-color: #f8d7da;
        color: #dc3545;
    }

	.icon-success {
        color: #28a745;
    }

    .icon-error {
        color: #dc3545;
    }
</style>

<script>
$(document).ready(function() {
    $('#formForgotPassword').on('submit', function(e) {
        e.preventDefault();

        var username = $('#username').val();
        var role = $('#role').val();

        var $resultField = $('#passwordResult');
        var $icon = $('#passwordIcon');
        var $btn = $('#submitForgot');
        var $btnText = $('#btnText');
        var $btnIcon = $('#btnIcon');

        // Reset field
        $resultField.val('').removeClass('is-success is-error');
        $icon.removeClass('fa-check fa-remove icon-success icon-error');

        // Tombol berubah jadi spinner
        $btn.prop('disabled', true);
        $btnIcon.removeClass().addClass('fa fa-spinner fa-spin');
        $btnText.text('Sedang mencari...');

        setTimeout(function() {
            $.ajax({
                url: 'get_password.php',
                method: 'POST',
                data: { username: username, role: role },
                success: function(response) {
                    // Kembalikan tombol
                    $btn.prop('disabled', false);
                    $btnIcon.removeClass().addClass('fa fa-search fa-fw');
                    $btnText.text('Lupa Password');

                    if (response && !response.includes('Password tidak ditemukan') && !response.includes('Terjadi kesalahan') && !response.includes('Role tidak valid')) {
                        $resultField
                            .val(response)
                            .removeClass('is-error')
                            .addClass('is-success');
                        $icon
                            .removeClass('fa-remove icon-error')
                            .addClass('fa-check icon-success');
                    } else {
                        $resultField
                            .val(response || 'Password tidak ditemukan')
                            .removeClass('is-success')
                            .addClass('is-error');
                        $icon
                            .removeClass('fa-check icon-success')
                            .addClass('fa-remove icon-error');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                    $btnIcon.removeClass().addClass('fa fa-search fa-fw');
                    $btnText.text('Lupa Password');

                    $resultField
                        .val('Terjadi kesalahan.')
                        .removeClass('is-success')
                        .addClass('is-error');
                    $icon
                        .removeClass('fa-check icon-success')
                        .addClass('fa-remove icon-error');
                }
            });
        }, 2000);
    });
});
</script>


