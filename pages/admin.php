<div class="wrap" id="wrap">
	<style>
		.bvi-form h2 {
			font-size: 1.2rem;
			margin-bottom: 1.5rem;
			border-bottom: 1px solid #eeeeee;
			padding-bottom: 0.5rem;
			padding-left: -1rem !important;
			padding-right: -1rem !important;
		}
	</style>
	<?php settings_errors(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
				<div class="text-left mb-2">
					<h1>Плагин <?php echo $this->plugin_name; ?>
						<small><sup><u>v<?php echo $this->version; ?></u></sup></small></h1>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
				<div class="bg-white border shadow-sm p-3 mb-3">
					<form method="post" action="options.php" class="bvi-form">
						<?php do_settings_sections( 'bvi' ); ?>
						<?php settings_fields( 'bvi-setting' ); ?>
						<?php submit_button(); ?>
						<?php submit_button( 'Восстановить настройки по умолчанию', 'secondary', 'bvi-reset', false ); ?>
					</form>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
				<div class="card rounded-0 p-0 shadow-sm m-0 w-100">
					<div class="card-header text-center pb-0">
						<h5><?php echo $this->plugin_name; ?> <sup><u><font
										style="font-size: 14px;">v<?php echo $this->version; ?></font></u></sup></h5>
					</div>
					<div class="card-body">
						<div class="text-left">
							Плагин доступности сайта для слабовидящих - <strong>"<?php echo $this->plugin_name; ?>
								"</strong> для WordPress.<br><br>
							Мы распространием этот плагин на бесплатной основе, но его написание, поддержка и
							распространение требует от нас вложения времени, сил и средств. Пожертвования пользователей
							могут позволить нам развивать и поддерживать плагин бесплатно.<br><br>
							<strong>Если плагин полезен для вас - пожалуйста рассмотрите возможность сделать
								пожертвование.</strong>
						</div>
						<hr class="m-0">
						<div class="text-center">
							<a href="https://bvi.isvek.ru/donate/"
							   class="mt-3 btn btn-danger btn-sm border border-danger shadow-sm" target="_blank">Сделать
								пожертвование</a>
						</div>
						<hr>
						<h5>Полезные ссылки</h5>
						<ul>
							<li><i aria-hidden="true" class="dashicons dashicons-external"></i><a
									href="https://bvi.isvek.ru/ustanovka-plagina/wordpress/" target="_blank">Документация</a></li>
							<li><i aria-hidden="true" class="dashicons dashicons-external"></i><a
									href="https://wordpress.org/support/plugin/button-visually-impaired/"
									target="_blank">Форум</a></li>
						</ul>
						<hr>
						<h5>Обратная связь</h5>
						<ul>
							<li>Электронная почта: bvi@isvek.ru <i aria-hidden="true"
							                                       class="dashicons dashicons-external"></i><a
									href="mailto:bvi@isvek.ru">Написать письмо</a></li>
							<li>Форма обратной связи - <i aria-hidden="true" class="dashicons dashicons-external"></i><a
									href="http://bvi.isvek.ru/feedback/" target="_blank">Перейти</a></li>
						</ul>
					</div>
					<div class="card-footer">
						Спасибо за использование <a href="http://bvi.isvek.ru/"
						                            target="_blank">"<?php echo $this->plugin_name; ?>"</a>!
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function ($) {
		if ($("input[name='bvi_database[bvi_active]']").val() == 0) {
			console.log(1);
		} else {
			console.log(0);
		}

	});
</script>
