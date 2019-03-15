/**
 * Created by feb on 20/05/17.
 */

$.fn.setValue = function (value) {
    if ($(this).hasClass("easyui-numberbox")) {
        $(this).numberbox('setValue', value);
    } else if ($(this).hasClass("easyui-combobox")) {
        $(this).combobox('setValue', value);
    } else if ($(this).hasClass("easyui-datebox")) {
        $(this).datebox('setValue', value);
    } else {
        $(this).textbox('setValue', value);
    }
}

var dateFormatter = function (date) {
    //console.log(date);
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    if (m < 10) {
        m = "0" + m;
    }
    if (d < 10) {
        d = "0" + d;
    }
    var complete = y + '-' + m + '-' + d;
    //console.log(complete);
    return complete;
};

$.fn.datebox.defaults.formatter = dateFormatter;

var dateParser = function(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
};

$.fn.datebox.defaults.parser = dateParser;

function formatMoney(value, row){
    return accounting.formatMoney(value, "", 0, ".", ",") + ",-";
}