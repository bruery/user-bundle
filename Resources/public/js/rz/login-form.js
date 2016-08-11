/*
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

jQuery(document).ready(function(){
    bruery_user_uniform_checkbox.init();
});

var bruery_user_uniform_checkbox = {
    init: function() {
        jQuery(".uni_style_checkbox").uniform();
    }
}
