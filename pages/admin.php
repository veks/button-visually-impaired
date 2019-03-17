<?php
//echo '<pre>' . print_r($this->get_option, 1) . '</pre>';
?>
<div class="wrap" id="wrap">
    <h1>Плагин <?php echo $this->plugin_name; ?> <sup><font style="font-size: 14px;">v<?php echo $this->ver; ?></font></sup></h1>
    <div class="bvi-text-center">
        <a href="http://bvi.isvek.ru/donate" target="_blank" class="bvi-link" title="Помочь развитию проекта">Помочь развитию проекта</a>
    </div>
    <h3 class="title">Основные настройки</h3>
    <p>Настройки панели при включении версии сайта для слабовидящих.</p>
    <form id="bvi_settings_save" class="form-horizontal" style="background: white; padding: 15px;">
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_active" class="font-weight-bold">Включить плагин?</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_active'], true); ?>">
                        <input type="radio" name="bvi_active" value="true" id="bvi_active" autocomplete="off" <?php checked(true, $this->get_option['bvi_active']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_active'], false); ?>">
                        <input type="radio" name="bvi_active" value="false" id="bvi_active" autocomplete="off" <?php checked(false, $this->get_option['bvi_active']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_theme" class="font-weight-bold">Цвета сайта</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group-vertical btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_theme'], 'white'); ?>">
                        <input type="radio" name="bvi_theme" value="white" id="bvi_theme" autocomplete="off" <?php checked('white', $this->get_option['bvi_theme']); ?>> Белым по черному
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_theme'], 'black'); ?>">
                        <input type="radio" name="bvi_theme" value="black" id="bvi_theme" autocomplete="off" <?php checked('black', $this->get_option['bvi_theme']); ?>> Черным по белому
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_theme'], 'blue'); ?>">
                        <input type="radio" name="bvi_theme" value="blue" id="bvi_theme" autocomplete="off" <?php checked('blue', $this->get_option['bvi_theme']); ?>> Темно-синим по голубому
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_theme'], 'brown'); ?>">
                        <input type="radio" name="bvi_theme" value="brown" id="bvi_theme" autocomplete="off" <?php checked('brown', $this->get_option['bvi_theme']); ?>> Коричневым по бежевому
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_theme'], 'green'); ?>">
                        <input type="radio" name="bvi_theme" value="green" id="bvi_theme" autocomplete="off" <?php checked('green', $this->get_option['bvi_theme']); ?>> Зеленым по темно-коричневому
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_font_size" class="font-weight-bold">Размер шрифта</label>
            </div>
            <div class="col-sm-3">
                <select name="bvi_font_size" id="bvi_font_size" class="form-control">
                    <?php
                    for ($i = 1;$i <= 40; $i++ )
                    {
                        echo '<option value="' . $i . '"' . selected($this->get_option['bvi_font_size'], $i) . ' >'.$i.' px</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_font" class="font-weight-bold">Шрифт</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_font'], 'arial'); ?>">
                        <input type="radio" name="bvi_font" value="arial" id="bvi_font" autocomplete="off" <?php checked('arial', $this->get_option['bvi_font']); ?>> Arial
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_font'], 'times'); ?>">
                        <input type="radio" name="bvi_font" value="times" id="bvi_font" autocomplete="off" <?php checked('times', $this->get_option['bvi_font']); ?>> Times New roman
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_letter_spacing" class="font-weight-bold">Межбуквенный интервал</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_letter_spacing'], 'normal'); ?>">
                        <input type="radio" name="bvi_letter_spacing" value="normal" id="bvi_letter_spacing" autocomplete="off" <?php checked('normal', $this->get_option['bvi_letter_spacing']); ?>> Одинарный
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_letter_spacing'], 'average'); ?>">
                        <input type="radio" name="bvi_letter_spacing" value="average" id="bvi_letter_spacing" autocomplete="off" <?php checked('average', $this->get_option['bvi_letter_spacing']); ?>> Полуторный
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_letter_spacing'], 'big'); ?>">
                        <input type="radio" name="bvi_letter_spacing" value="big" id="bvi_letter_spacing" autocomplete="off" <?php checked('big', $this->get_option['bvi_letter_spacing']); ?>> Двойной
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_line_height" class="font-weight-bold">Междустрочный интервал</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_line_height'], 'normal'); ?>">
                        <input type="radio" name="bvi_line_height" value="normal" id="bvi_line_height" autocomplete="off" <?php checked('normal', $this->get_option['bvi_line_height']); ?>> Стандартный
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_line_height'], 'average'); ?>">
                        <input type="radio" name="bvi_line_height" value="average" id="bvi_line_height" autocomplete="off" <?php checked('average', $this->get_option['bvi_line_height']); ?>> Средний
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_line_height'], 'big'); ?>">
                        <input type="radio" name="bvi_line_height" value="big" id="bvi_line_height" autocomplete="off" <?php checked('big', $this->get_option['bvi_line_height']); ?>> Большой
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_images" class="font-weight-bold">Изображения</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_images'], 'grayscale'); ?>">
                        <input type="radio" name="bvi_images" value="grayscale" id="bvi_images" autocomplete="off" <?php checked('grayscale', $this->get_option['bvi_images']); ?>> Черно-белые
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_images'], true); ?>">
                        <input type="radio" name="bvi_images" value="true" id="bvi_images" autocomplete="off" <?php checked(true, $this->get_option['bvi_images']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_images'], false); ?>">
                        <input type="radio" name="bvi_images" value="false" id="bvi_images" autocomplete="off" <?php checked(false, $this->get_option['bvi_images']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_reload" class="font-weight-bold">Перезагрузка страницы</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_reload'], true); ?>">
                        <input type="radio" name="bvi_reload" value="true" id="bvi_reload" autocomplete="off" <?php checked(true, $this->get_option['bvi_reload']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_reload'], false); ?>">
                        <input type="radio" name="bvi_reload" value="false" id="bvi_reload" autocomplete="off" <?php checked(false, $this->get_option['bvi_reload']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_voice" class="font-weight-bold">Синтез речи</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_voice'], true); ?>">
                        <input type="radio" name="bvi_voice" value="true" id="bvi_voice" autocomplete="off" <?php checked(true, $this->get_option['bvi_voice']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_voice'], false); ?>">
                        <input type="radio" name="bvi_voice" value="false" id="bvi_voice" autocomplete="off" <?php checked(false, $this->get_option['bvi_voice']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_not_work" class="font-weight-bold"><u>Включите</u> если плагин не работает</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_not_work'], true); ?>">
                        <input type="radio" name="bvi_not_work" value="true" id="bvi_not_work" autocomplete="off" <?php checked(true, $this->get_option['bvi_not_work']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_not_work'], false); ?>">
                        <input type="radio" name="bvi_not_work" value="false" id="bvi_not_work" autocomplete="off" <?php checked(false, $this->get_option['bvi_not_work']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_flash_iframe" class="font-weight-bold">iframe</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_flash_iframe'], true); ?>">
                        <input type="radio" name="bvi_flash_iframe" value="true" id="bvi_flash_iframe" autocomplete="off" <?php checked(true, $this->get_option['bvi_flash_iframe']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_flash_iframe'], false); ?>">
                        <input type="radio" name="bvi_flash_iframe" value="false" id="bvi_flash_iframe" autocomplete="off" <?php checked(false, $this->get_option['bvi_flash_iframe']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="bvi_hide" class="font-weight-bold">Скрыть панель для славбовидящих</label>
            </div>
            <div class="col-sm-9">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_hide'], true); ?>">
                        <input type="radio" name="bvi_hide" value="true" id="bvi_hide" autocomplete="off" <?php checked(true, $this->get_option['bvi_hide']); ?>> Включить
                    </label>
                    <label class="btn btn-outline-secondary btn-sm <?php $this->check_active($this->get_option['bvi_hide'], false); ?>">
                        <input type="radio" name="bvi_hide" value="false" id="bvi_hide" autocomplete="off" <?php checked(false, $this->get_option['bvi_hide']); ?>> Выключить
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <p class="submit">
            <?php wp_nonce_field('settings_save','settings_save'); ?>
            <input type="hidden" name="action" value="settings_save">
            <input type="submit" name="submit" id="submit" class="btn btn-success btn-sm" value="Сохранить настройки">
        </p>
    </form>
    <form id="bvi_settings_reset">
        <?php wp_nonce_field('settings_reset','settings_reset'); ?>
        <input type="hidden" name="action" value="settings_reset">
        <input type="submit" name="submit" id="submit" class="btn btn-info btn-sm" value="Сбросить настройки">
    </form>
</div>