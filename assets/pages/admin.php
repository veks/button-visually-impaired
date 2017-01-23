<div class="wrap" id="wrap">
    <h1><?php echo _e('Плагин', 'bvi_languages'); ?> <?php echo $this->plugin_name; ?> <sup><font style="font-size: 14px;">v<?php echo $this->ver; ?></font></sup></h1>
    <div class="bvi-text-center">
        <a href="http://bvi.isvek.ru/pages/donate" target="_blank" class="bvi-link" title="<?php echo _e('Помочь проекту', 'bvi_languages'); ?>"><?php echo _e('Помочь проекту', 'bvi_languages'); ?></a>
    </div>
    <h2 class="title"><?php echo _e('Основные настройки', 'bvi_languages'); ?></h2>
    <p><?php echo _e('Настройки панели слабовидящих', 'bvi_languages'); ?></p>
    <form id="bvi_settings_save">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="BviPanel"><?php echo _e('Включить плагин?',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanel" id="BviPanel" class="postform">
                        <option class="level-0" value="1" <?php selected( $this->get_option['BviPanel'], '1' ); ?>><?php echo _e('Включить', 'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPanel'], '0' ); ?>><?php echo _e('Выключить', 'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelBg"><?php echo _e('Цвета сайта', 'bvi_languages'); ?>:</label>
                </th>
                <td>
                    <select name="BviPanelBg" id="BviPanelBg" class="postform">
                        <option class="level-0" value="white" <?php selected( $this->get_option['BviPanelBg'], 'white' ); ?>><?php echo _e('Белым по черному', 'bvi_languages'); ?></option>
                        <option class="level-0" value="black" <?php selected( $this->get_option['BviPanelBg'], 'black' ); ?>><?php echo _e('Черным по белому', 'bvi_languages'); ?></option>
                        <option class="level-0" value="blue"  <?php selected( $this->get_option['BviPanelBg'], 'blue' ); ?>><?php echo _e('Темно-синим по голубому', 'bvi_languages'); ?></option>
                        <option class="level-0" value="brown" <?php selected( $this->get_option['BviPanelBg'], 'brown' ); ?>><?php echo _e('Коричневым по бежевому', 'bvi_languages'); ?></option>
                        <option class="level-0" value="green" <?php selected( $this->get_option['BviPanelBg'], 'green' ); ?>><?php echo _e('Зеленым по темно-коричневому', 'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelFontSize"><?php echo _e('Размер шрифта', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelFontSize" id="BviPanelFontSize" class="postform">
                        <option class="level-0" value="14" <?php selected( $this->get_option['BviPanelFontSize'], '14' ); ?>>14 px</option>
                        <option class="level-0" value="16" <?php selected( $this->get_option['BviPanelFontSize'], '16' ); ?>>16 px</option>
                        <option class="level-0" value="18" <?php selected( $this->get_option['BviPanelFontSize'], '18' ); ?>>18 px</option>
                        <option class="level-0" value="20" <?php selected( $this->get_option['BviPanelFontSize'], '20' ); ?>>20 px</option>
                        <option class="level-0" value="23" <?php selected( $this->get_option['BviPanelFontSize'], '23' ); ?>>23 px</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelLetterSpacing"><?php echo _e('Интервал между буквами', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelLetterSpacing" id="BviPanelLetterSpacing" class="postform">
                        <option class="level-0" value="normal"  <?php selected( $this->get_option['BviPanelLetterSpacing'], 'normal' ); ?>><?php echo _e('Стандартный', 'bvi_languages'); ?></option>
                        <option class="level-0" value="average" <?php selected( $this->get_option['BviPanelLetterSpacing'], 'average' ); ?>><?php echo _e('Средний', 'bvi_languages'); ?></option>
                        <option class="level-0" value="big"     <?php selected( $this->get_option['BviPanelLetterSpacing'], 'big' ); ?>><?php echo _e('Большой', 'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelLineHeight"><?php echo _e('Интервал между строками', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelLineHeight" id="BviPanelLineHeight" class="postform">
                        <option class="level-0" value="normal"  <?php selected( $this->get_option['BviPanelLineHeight'], 'normal' ); ?>><?php echo _e('Стандартный',  'bvi_languages'); ?></option>
                        <option class="level-0" value="average" <?php selected( $this->get_option['BviPanelLineHeight'], 'average' ); ?>><?php echo _e('Средний',  'bvi_languages'); ?></option>
                        <option class="level-0" value="big"     <?php selected( $this->get_option['BviPanelLineHeight'], 'big' ); ?>><?php echo _e('Большой',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelImg"><?php echo _e('Изображения', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelImg" id="BviPanelImg" class="postform">
                        <option class="level-0" value="grayScale"  <?php selected( $this->get_option['BviPanelImg'], 'grayScale' ); ?>><?php echo _e('Черно-белые',  'bvi_languages'); ?></option>
                        <option class="level-0" value="1"  <?php selected( $this->get_option['BviPanelImg'], '1' ); ?>><?php echo _e('Включить',  'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPanelImg'], '0' ); ?>><?php echo _e('Выключить',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelImgXY"><?php echo _e('Сохранение размера исходного изображения', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelImgXY" id="BviPanelImgXY" class="postform">
                        <option class="level-0" value="1"  <?php selected( $this->get_option['BviPanelImgXY'], '1' ); ?>><?php echo _e('Включить',  'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPanelImgXY'], '0' ); ?>><?php echo _e('Выключить',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelReload"><?php echo _e('Перезагрузка страницы', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelReload" id="BviPanelReload" class="postform">
                        <option class="level-0" value="1"  <?php selected( $this->get_option['BviPanelReload'], '1' ); ?>><?php echo _e('Включить',  'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPanelReload'], '0' ); ?>><?php echo _e('Выключить',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
            <tr>
                <th scope="row">
                    <label for="BviPlay"><?php echo _e('Синтез речи', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPlay" id="BviPlay" class="postform">
                        <option class="level-0" value="1"  <?php selected( $this->get_option['BviPlay'], '1' ); ?>><?php echo _e('Включить',  'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPlay'], '0' ); ?>><?php echo _e('Выключить',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviFixPanel"><?php echo _e('Зафиксировать панель настроек вверху страницы', 'bvi_languages'); ?></label>
                </th>
                <td>
                    <input id="BviFixPanel" name="BviFixPanel" type="checkbox" value="<?php echo $this->get_option['BviFixPanel'];?>"  <?php checked( $this->get_option['BviFixPanel'], 1); ?>>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviCloseClassAndId"><?php echo _e('Отключить', 'bvi_languages'); ?> class & id</label>
                </th>
                <td>
                    <input id="BviCloseClassAndId" type="text" name="BviCloseClassAndId" value="<?php echo $this->get_option['BviCloseClassAndId']?>" class="regular-text code">
                    <p><?php echo _e('Впишите название <u>class</u> или <u>id</u> через запятую для отключеня при включении версии для слабовидящих.',  'bvi_languages'); ?>
                        <br>
                        <?php echo _e('Например',  'bvi_languages'); ?>: <code>.className1,.className2,#idName1</code>
                        <br>
                        <?php echo _e('Правильно вводите название класса или ид иначе плагин не будет работать.',  'bvi_languages'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelText"><?php echo _e('Название сыллки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <input id="BviPanelText" type="text" name="BviPanelText" value="<?php echo $this->get_option['BviPanelText'];?>" class="regular-text code">
                    <p><?php echo _e('Название сыллки включения плагина виджет',  'bvi_languages'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelCloseText"><?php echo _e('Название сыллки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <input id="BviPanelCloseText" type="text" name="BviPanelCloseText" value="<?php echo $this->get_option['BviPanelCloseText'];?>" class="regular-text code">
                    <p><?php echo _e('Название сыллки выключения плагина',  'bvi_languages'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviTextBg"><?php echo _e('Фон кнопки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <input id="BviTextBg" type="text" name="BviTextBg" value="<?php echo $this->get_option['BviTextBg'];?>" class="bvi-color-picker-BviTextBg" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviTextColor"><?php echo _e('Цвет текста кнопки и иконки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <input id="BviTextColor" type="text" name="BviTextColor" value="<?php echo $this->get_option['BviTextColor'];?>" class="bvi-color-picker-BviTextColor" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviSizeIcon"><?php echo _e('Размер иконки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviSizeIcon" id="BviSizeIcon" class="postform">
                        <option class="level-0" value="18" <?php selected( $this->get_option['BviSizeIcon'], '18' ); ?>>18px</option>
                        <option class="level-0" value="20" <?php selected( $this->get_option['BviSizeIcon'], '20' ); ?>>20px</option>
                        <option class="level-0" value="22" <?php selected( $this->get_option['BviSizeIcon'], '22' ); ?>>22px</option>
                        <option class="level-0" value="24" <?php selected( $this->get_option['BviSizeIcon'], '24' ); ?>>24px</option>
                        <option class="level-0" value="26" <?php selected( $this->get_option['BviSizeIcon'], '26' ); ?>>26px</option>
                        <option class="level-0" value="28" <?php selected( $this->get_option['BviSizeIcon'], '28' ); ?>>28px</option>
                        <option class="level-0" value="30" <?php selected( $this->get_option['BviSizeIcon'], '30' ); ?>>30px</option>
                        <option class="level-0" value="32" <?php selected( $this->get_option['BviSizeIcon'], '32' ); ?>>32px</option>
                        <option class="level-0" value="34" <?php selected( $this->get_option['BviSizeIcon'], '34' ); ?>>34px</option>
                        <option class="level-0" value="36" <?php selected( $this->get_option['BviSizeIcon'], '36' ); ?>>36px</option>
                        <option class="level-0" value="38" <?php selected( $this->get_option['BviSizeIcon'], '38' ); ?>>38px</option>
                        <option class="level-0" value="40" <?php selected( $this->get_option['BviSizeIcon'], '40' ); ?>>40px</option>
                        <option class="level-0" value="42" <?php selected( $this->get_option['BviSizeIcon'], '42' ); ?>>42px</option>
                        <option class="level-0" value="44" <?php selected( $this->get_option['BviSizeIcon'], '44' ); ?>>44px</option>
                        <option class="level-0" value="46" <?php selected( $this->get_option['BviSizeIcon'], '46' ); ?>>46px</option>
                        <option class="level-0" value="48" <?php selected( $this->get_option['BviSizeIcon'], '48' ); ?>>48px</option>
                        <option class="level-0" value="50" <?php selected( $this->get_option['BviSizeIcon'], '50' ); ?>>50px</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviSizeText"><?php echo _e('Размер шрифта кнопки',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviSizeText" id="BviSizeText" class="postform">
                        <option class="level-0" value="12" <?php selected( $this->get_option['BviSizeText'], '12' ); ?>>12px</option>
                        <option class="level-0" value="13" <?php selected( $this->get_option['BviSizeText'], '13' ); ?>>13px</option>
                        <option class="level-0" value="14" <?php selected( $this->get_option['BviSizeText'], '14' ); ?>>14px</option>
                        <option class="level-0" value="15" <?php selected( $this->get_option['BviSizeText'], '15' ); ?>>15px</option>
                        <option class="level-0" value="16" <?php selected( $this->get_option['BviSizeText'], '16' ); ?>>16px</option>
                        <option class="level-0" value="17" <?php selected( $this->get_option['BviSizeText'], '17' ); ?>>17px</option>
                        <option class="level-0" value="18" <?php selected( $this->get_option['BviSizeText'], '18' ); ?>>18px</option>
                        <option class="level-0" value="19" <?php selected( $this->get_option['BviSizeText'], '19' ); ?>>19px</option>
                        <option class="level-0" value="20" <?php selected( $this->get_option['BviSizeText'], '20' ); ?>>20px</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="BviPanelNoWork"><?php echo _e('<u>Включите</u> если плагин не работает',  'bvi_languages'); ?></label>
                </th>
                <td>
                    <select name="BviPanelNoWork" id="BviPanelNoWork" class="postform">
                        <option class="level-0" value="1" <?php selected( $this->get_option['BviPanelNoWork'], '1' ); ?>><?php echo _e('Включить',  'bvi_languages'); ?></option>
                        <option class="level-0" value="0" <?php selected( $this->get_option['BviPanelNoWork'], '0' ); ?>><?php echo _e('Выключить',  'bvi_languages'); ?></option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php wp_nonce_field( 'settings_save','settings_save'); ?>
            <input type="hidden" name="action" value="settings_save">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo _e('Сохранить настройки',  'bvi_languages'); ?>">
        </p>
    </form>
    <form id="bvi_settings_reset">
        <?php wp_nonce_field( 'settings_reset','settings_reset'); ?>
        <input type="hidden" name="action" value="settings_reset">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo _e('Сбросить настройки',  'bvi_languages'); ?>">
    </form>
</div>