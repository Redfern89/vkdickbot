<?php require_once '../bootstrap.php'; ?>
<h3>Настройки vkapi</h3>
<hr />
<form method="POST" action="/setup/act.php" class="mb-4">
	<input type="hidden" name="act" value="confirmation_token_setup" />
	<div class="mb-3">
		<label class="form-label mb-0">Код подтверждения</label>
		<div class="small mb-2 ms-1 text-muted">Данный код выдается на странице работы с <b>Callback API</b> в настройках Вашего сообщества. После того, когда Вы сохраните ключ - подтвердите Ваш сервер в настройках сообщества</div>
		<input type="text" name="vkapi_confirmation_token" class="form-control" value="<?php echo __('@vkapi_confirmation_token@'); ?>" />
	</div>
	<button type="submit" class="btn btn-danger">Сохранить код подтверждения</button>
</form>

<form method="POST" action="/setup/act.php">
	<input type="hidden" name="act" value="vkapi_keys_setup" />
	<div class="mb-3">
		<label class="form-label mb-0">Ключ доступа</label>
		<div class="small mb-2 ms-1 text-muted">Получить его можно в настройках сообщества в разделе <b>ключи доступа</b>. Данному ключу необходимы права [сообщения сообщества, фотографии]</div>
		<input type="text" name="vkapi_access_token" class="form-control" value="<?php echo __('@vkapi_access_token@'); ?>" />
	</div>
	<div class="mb-3">
		<label class="form-label mb-0">Секретный ключ</label>
		<div class="small mb-2 ms-1 text-muted">Данный код можно ввести на странице работы с <b>Callback API</b> и затем ввести его сюда. Он необходим для защиты от подделки запросов</div>
		<input type="text" name="vkapi_secret_key" class="form-control" value="<?php echo __('@vkapi_secret_key@'); ?>" />
	</div>
	
	<button type="submit" class="btn btn-danger">Сохранить ключи</button>
	<?php if (isset($_SESSION['vkapi_keys_ok'])) { ?>
	<a href="/setup?step=admin_settings" class="btn btn-danger">Далее</a>
	<?php } ?>
</form>