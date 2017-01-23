jQuery(document).ready(function(){
    jQuery('#widgets-right .color-picker, .inactive-sidebar .color-picker').wpColorPicker();
});
jQuery(document).ajaxComplete(function() {
    jQuery('#widgets-right .color-picker, .inactive-sidebar .color-picker').wpColorPicker();
});