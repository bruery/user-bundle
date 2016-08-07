/*
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

jQuery(document).ready(function(){
    bruery_user_profile_datepicker.init();
    bruery_user_profile_selectpicker.init();
});

var bruery_user_profile_datepicker = {
    init: function() {
        jQuery('.bruery-datepicker').datepicker({autoclose: true});
    },
    initById: function(id, options) {
        jQuery('#'+id).datepicker(options);
    }
}

//* select
var bruery_user_profile_selectpicker = {
    init: function() {
        jQuery('.selectpicker').selectpicker();
    },
    initById: function(id, options){
        jQuery("#"+id).selectpicker(options ? options : null);
    }
}
