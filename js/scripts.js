var plus_minus_num = {}, plus_minus_amount = {}, plus_minus_total_amount = {};

function edit_fee(type, cat_id, post_id, key, amount) {
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : Ajax.ajaxurl,
        data : {action: "ajax_action", m: "edit_fee", type: type, cat_id: cat_id, post_id: post_id, key: key},
        success: function(response) {
            if(response.success == 1) {
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : Ajax.ajaxurl,
                    data : {action: "ajax_action", m: "get_pricing_sidebar"},
                    success: function(response) {
                        if(response.success == 1) {
                            plusMinusNum(type, key, amount, 'total-amount-post-id-' + post_id);
                            jQuery('#pricing-sidebar-id').html(response.html);
                        } else {
                        }
                    }
                });
            } else {
            }
        }
    });   
}

function remove_from_itinerary(cat_id, post_id, key) {
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : Ajax.ajaxurl,
        data : {action: "ajax_action", m: "remove_from_itinerary", cat_id: cat_id, post_id: post_id, key: key},
        success: function(response) {
            if(response.success == 1) {
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : Ajax.ajaxurl,
                    data : {action: "ajax_action", m: "get_pricing_sidebar"},
                    success: function(response) {
                        if(response.success == 1) {
                            jQuery('#pricing-sidebar-id').html(response.html);
                        } else {
                        }
                    }
                });
            } else {
            }
        }
    });   
}

function add_to_itinerary(cat_id, post_id) {
    var fees = {};
    jQuery("#fees-"+post_id+" :input").each(function (e) {
        fees[this.id] = this.value;
    });
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : Ajax.ajaxurl,
        data : {action: "ajax_action", m: "add_to_itinerary", cat_id: cat_id, post_id: post_id, fees: fees},
        success: function(response) {
            if(response.success == 1) {
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : Ajax.ajaxurl,
                    data : {action: "ajax_action", m: "get_pricing_sidebar"},
                    success: function(response) {
                        if(response.success == 1) {
                            jQuery('#pricing-sidebar-id').html(response.html);
                        } else {
                        }
                    }
                });
            } else {
            }
        }
    });   
}

function plusMinusNum(type, meta_key, amount, total_amount_id) {
    var num = jQuery('#'+meta_key+'_number').attr('value');
    var total_amount = Number(jQuery('#'+total_amount_id).html().replace(/P/g, ""));
    if (type == '-') {
        if (num == 0) return;
        num--;
        total_amount -= amount;
    } else {
        if (num == 100) return;
        num++
        total_amount += amount;
    }
    plus_minus_num[meta_key] = num;
    plus_minus_amount[meta_key] = num * amount;
    plus_minus_total_amount[total_amount_id] = total_amount;
    jQuery('#'+meta_key+'_number').val(num);
    jQuery('#'+meta_key+'_amount').html('P'+(num*amount));
    updateTotalAmount(total_amount_id, total_amount);
}

function plusMinusNumPopUp(type, meta_key, amount, total_amount_id) {
    plusMinusNum(type, meta_key, amount, total_amount_id);
    updateTotalAmountDefaults(total_amount_id, meta_key);
}

function setTotalAmountDefaults(id, meta_key, num, amount, total_amount) {
    plus_minus_num[meta_key] = num;
    plus_minus_amount[meta_key] = num * amount;
    plus_minus_total_amount[id] = total_amount;
}

function updateTotalAmountDefaults(id, meta_key) {
    jQuery('#'+meta_key+'_number_pop_up').val(plus_minus_num[meta_key]);
    jQuery('#'+meta_key+'_amount_pop_up').html('P'+plus_minus_amount[meta_key]);
    jQuery('#'+id+'-pop-up').html('P'+plus_minus_total_amount[id]);
}

function updateTotalAmount(id, total) {
    jQuery('#'+id).html('P'+total);
}

function onOffCheckbox(meta_key, amount, total_amount_id) {
    var on = jQuery('#'+meta_key+'_checkbox').is(':checked');
    var total_amount = Number(jQuery('#'+total_amount_id).html().replace(/P/g, ""));
    if (on) {
        
    } else {
        
    }
}

var c_one = true, c_two = false, c_three = false, c_four = false;

function load_attractions() {
    jQuery('form[name="attractions_ajax_search"]').submit();
}

function attractions_tab() {
	if (c_one) {
		return;
	} else if (c_two) {
		c_two = false;
		jQuery('#collapseTwo').collapse('hide');
		jQuery('#accommodations-search-box-div').hide();
	} else if (c_three) {
		c_three = false;
		jQuery('#collapseThree').collapse('hide');
		jQuery('#restaurants-search-box-div').hide();
	} else if(c_four) {
		c_four = false;
		jQuery('#collapseFour').collapse('hide');
		jQuery('#transportations-search-box-div').hide();
	}
	c_one = true;
	jQuery('#collapseOne').collapse('show');
    jQuery('form[name="attractions_ajax_search"]').submit();
	jQuery('#attractions-search-box-div').show();
}

function accommodations_tab() {
	if (c_two) {
		return;
	} else if (c_one) {
        c_one = false;
	    jQuery('#collapseOne').collapse('hide');
		jQuery('#attractions-search-box-div').hide();
	} else if (c_three) {
        c_three = false;
	    jQuery('#collapseThree').collapse('hide');
		jQuery('#restaurants-search-box-div').hide();
	} else if (c_four) {
        c_four = false;
        jQuery('#collapseFour').collapse('hide');
		jQuery('#transportations-search-box-div').hide();
	}
	c_two = true;
	jQuery('#collapseTwo').collapse('show');
    jQuery('form[name="accommodations_ajax_search"]').submit();
	jQuery('#accommodations-search-box-div').show();
}

function restaurants_tab() {
	if (c_three) {
		return;
	} else if (c_one) {
        c_one = false;
	    jQuery('#collapseOne').collapse('hide');
		jQuery('#attractions-search-box-div').hide();
	} else if (c_two) {
        c_two = false;
	    jQuery('#collapseTwo').collapse('hide');
		jQuery('#accommodations-search-box-div').hide();
	} else if (c_four) {
        c_four = false;
        jQuery('#collapseFour').collapse('hide');
		jQuery('#transportations-search-box-div').hide();
	}
	c_three = true;
	jQuery('#collapseThree').collapse('show');
    jQuery('form[name="restaurants_ajax_search"]').submit();
	jQuery('#restaurants-search-box-div').show();
}

function transportations_tab() {
	if (c_four) {
		return;
	} else if (c_one) {
        c_one = false;
	    jQuery('#collapseOne').collapse('hide');
		jQuery('#attractions-search-box-div').hide();
	} else if (c_three) {
        c_three = false;
	    jQuery('#collapseThree').collapse('hide');
		jQuery('#restaurants-search-box-div').hide();
	} else if (c_two) {
        c_two = false;
        jQuery('#collapseTwo').collapse('hide');
		jQuery('#accommodations-search-box-div').hide();
	}
	c_four = true;
	jQuery('#collapseFour').collapse('show');
    jQuery('form[name="transportations_ajax_search"]').submit();
	jQuery('#transportations-search-box-div').show();
}
