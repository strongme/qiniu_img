<div class="row">
	<div class="col-md-6">
		<div class="alert alert-<?= $data['type']; ?> alert-dismissible" role='alert'>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			<strong><?= $data["msg_title"]; ?></strong>&nbsp;<?=$data["msg_body"]; ?>
		</div>
	</div>
</div>