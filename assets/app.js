import './styles/app.scss';

import './js/jquery/jquery.min.js';
import './js/bootstrap/bootstrap.bundle.min.js';
import './js/owl.carousel/owl.carousel.min.js';
import './js/bootstrap-spinner/bootstrap-spinner.js';
import './js/daterangepicker/daterangepicker.js';

var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
$(function () {
    'use strict';
    // Depart Date
    $('#trainDepart').daterangepicker({
        singleDatePicker: true,
        minDate: today,
        autoUpdateInput: false,
    }, function (chosen_date) {
        $('#trainDepart').val(chosen_date.format('MM-DD-YYYY'));
    });
});
import './js/theme.js';