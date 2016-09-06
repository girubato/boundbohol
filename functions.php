<?php

    add_filter('wp_session_expiration', function() { return 24 * 60 * 60; });
    add_filter('wp_session_expiration_variant', function() { return 24 * 60 * 60; });
    $wp_session = WP_Session::get_instance();
    $wp_session['session_id'] = substr( filter_input( INPUT_COOKIE, WP_SESSION_COOKIE, FILTER_SANITIZE_STRING ), 0, 32 );
    if (isset($_POST['input_number'])) {
        foreach ($_POST as $key => $val) {
            $wp_session[$key] = $val;
        }
    }

    function more_info_modal($post_info=array(), $cat_id, $total_amount_id, $atib, $return=false) {
        $id = md5(print_r($post_info, true));
        $update_defaults_script = '';
        $the_custom_amount_meta_pop_up = '';
        list($the_custom_amount_meta_pop_up, $update_defaults_script) = the_custom_amount_meta_pop_up($cat_id, $post_info['post_id'], $total_amount_id);
        echo '
            <button onclick="'.$update_defaults_script.'" type="button" class="btn btn-primary" data-toggle="modal" data-target="#post-modal-id-'.$id.'"> More Info </button>
        
            <div class="modal fade large" id="post-modal-id-'.$id.'" tabindex="-1" role="dialog" aria-labelledby="post-label-id-'.$id.'">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <!--
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#photos-'.$id.'" aria-controls="photos" role="tab" data-toggle="tab">Photos</a></li>
                                        <li role="presentation"><a href="#videos-'.$id.'" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
                                        <!-- disabled for now
                                        <li role="presentation"><a href="#map-'.$id.'" aria-controls="map" role="tab" data-toggle="tab">Map</a></li>
                                        <li role="presentation"><a href="#reviews-'.$id.'" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                                        -->
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="photos-'.$id.'">
        ';
        if (!empty($post_info['pg_id'])) {
            echo do_shortcode('[Best_Wordpress_Gallery id="'.$post_info['pg_id'].'"]');
        }
        echo '
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="videos-'.$id.'">
        ';
        if (!empty($post_info['vg_id'])) {
            echo do_shortcode('[Best_Wordpress_Gallery id="'.$post_info['vg_id'].'"]');
        }
        echo '
                                        </div>
                                        <!-- disabled for now
                                        <div role="tabpanel" class="tab-pane" id="map-'.$id.'">
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="reviews-'.$id.'">
                                        </div>
                                        -->
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div><h4>'.$post_info['title'].'</h4></div>
                                    <div>'.$post_info['address'].'</div>
                                    <div>'.$post_info['etos'].'</div>
                                    <div>'.$post_info['description'].'</div>
                                    <hr>
                                    ' . $the_custom_amount_meta_pop_up . '
                                    <div class="float-left">' . $atib . '</div>
                                    <div class="total-amount-post" id="'. $total_amount_id .'-pop-up"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    function the_custom_amount_meta_pop_up($cat_id='', $post_id='', $total_amount_id='') {
        $html = '';
        $update_defaults_script = '';
        if ( $keys = get_post_custom_keys() ) {
            foreach ( (array) $keys as $key ) {
                $meta_key = trim($key);
                if ( is_protected_meta( $meta_key, 'post' ) ) {
                    continue;
                } elseif (!preg_match('/^fee_format:/i', $meta_key)) {
                    continue;
                }
                $default = 1;
                global $wp_session;
                if (isset($wp_session['input_number'])) {
                    $default = $wp_session['input_number'];
                }
                $html .= "<div id='fees-$post_id-pop-up'>";
                foreach (get_post_custom_values($key) as $value) {
                    $token = explode(':', $value);
                    $meta_key = md5($meta_key.$value.$cat_id.$post_id);
                    $type = array_shift($token);
                    $name = array_shift($token);
                    $label = array_shift($token);
                    $amount = array_shift($token);
                    if (isset($wp_session['pricing_sidebar_data'])) {
                        $token = json_decode($wp_session['pricing_sidebar_data']);
                        if (isset($token->$cat_id->$post_id->$meta_key)) {
                            $default = $token->$cat_id->$post_id->$meta_key->number;
                        }
                    }
                    if ($type == 'number') {
                        $html .= "<div>";
                        $html .= "<div class='custom-amount-label'>$label</div>";
                        $html .= "<div class='float-left'>";
                        $html .= "<input type='hidden' id='{$meta_key}_name_pop_up' value='$name' />";
                        $html .= "<input type='hidden' id='{$meta_key}_value_pop_up' value='$amount' />";
                        $html .= "<a href='javascript:void(0);' onclick='plusMinusNumPopUp(\"-\", \"$meta_key\", $amount, \"$total_amount_id\")'>-</a>";
                        $html .= "&nbsp;<input id='{$meta_key}_number_pop_up' type='text' value=$default disabled='disabled' size=3 />";
                        $html .= "&nbsp;<a href='javascript:void(0);' onclick='plusMinusNumPopUp(\"+\", \"$meta_key\", $amount, \"$total_amount_id\")'>+</a></div>";
                        $html .= "<div class='float-right'' id='{$meta_key}_amount_pop_up'>P".($amount*$default)."</div><div class='clear'></div>";
                        $html .= "</div>";
                        $update_defaults_script .= "updateTotalAmountDefaults('$total_amount_id', '$meta_key');";
                    }
                }
                $html .= "</div>";
            }
        }
        return array($html, $update_defaults_script);
    }

    function the_custom_amount_meta($cat_id, $post_id, $total_amount_id='', $return=false) {
        $html = '';
        if ( $keys = get_post_custom_keys() ) {
            $set_defaults_script = '';
            $total_amount = 0;
            foreach ( (array) $keys as $key ) {
                $meta_key = trim($key);
                if ( is_protected_meta( $meta_key, 'post' ) ) {
                    continue;
                } elseif (!preg_match('/^fee_format:/i', $meta_key)) {
                    continue;
                }
                $default = 1;
                global $wp_session;
                if (isset($wp_session['input_number'])) {
                    $default = $wp_session['input_number'];
                }
                $html .= "<div id='fees-$post_id'>";
                foreach (get_post_custom_values($key) as $value) {
                    $token = explode(':', $value);
                    $meta_key = md5($meta_key.$value.$cat_id.$post_id);
                    $type = array_shift($token);
                    $name = array_shift($token);
                    $label = array_shift($token);
                    $amount = array_shift($token);
                    if (isset($wp_session['pricing_sidebar_data'])) {
                        $token = json_decode($wp_session['pricing_sidebar_data']);
                        if (isset($token->$cat_id->$post_id->$meta_key)) {
                            $default = $token->$cat_id->$post_id->$meta_key->number;
                        }
                    }
                    $total_amount += $amount*$default;
                    if ($type == 'number') {
                        $html .= "<div class='custom-amount-label'>$label</div>";
                        $html .= "<div class='float-left'>";
                        $html .= "<input type='hidden' id='{$meta_key}_name' value='$name' />";
                        $html .= "<input type='hidden' id='{$meta_key}_value' value='$amount' />";
                        $html .= "<a href='javascript:void(0);' onclick='plusMinusNum(\"-\", \"$meta_key\", $amount, \"$total_amount_id\")'>-</a>";
                        $html .= "&nbsp;<input id='{$meta_key}_number' type='text' value=$default disabled='disabled' size=3 />";
                        $html .= "&nbsp;<a href='javascript:void(0);' onclick='plusMinusNum(\"+\", \"$meta_key\", $amount, \"$total_amount_id\")'>+</a></div>";
                        $html .= "<div class='float-right'' id='{$meta_key}_amount'>P".($amount*$default)."</div><div class='clear'></div>";
                        $set_defaults_script .= "setTotalAmountDefaults('$total_amount_id', '$meta_key', '$default', '$amount', '$total_amount');";
                    } elseif ($type == 'checkbox') {
                    /**
                        $checked = $default ? 'checked' : '';
                        print "<div>";
                        print "<input ref='javascript:void(0);' onclick='onOffCheckbox(\"$meta_key\", $amount, \"$total_amount_id\")' type='checkbox' id='{$meta_key}_checkbox' $checked />&nbsp;$label";
                        print "</div>";
                     */
                    }
                }
                $html .= "</div>";
            }
            $html .= "<script type='text/javascript'>";
            $html .= $set_defaults_script;
            $html .= "updateTotalAmount('$total_amount_id', $total_amount);";
            $html .= "</script>";
        }
        if ($return) return $html;
        echo $html;
    }

    function add_to_itinerary() {
        global $wp_session;
        if (isset($wp_session['pricing_sidebar_data'])) {
            $data = json_decode($wp_session['pricing_sidebar_data']);
        }
        foreach ($_POST['fees'] as $key => $value) {
            $token = explode('_', $key);
            $data->$_POST['cat_id']->$_POST['post_id']->$token[0]->$token[1] = $value;
        }
        $wp_session['pricing_sidebar_data'] = json_encode($data);
        echo json_encode(array('success' => 1));
        die();
    }

    function remove_from_itinerary() {
        global $wp_session;
        $data = json_decode($wp_session['pricing_sidebar_data']);
        if (!empty($_POST['key'])) {
            if (isset($data->$_POST['cat_id']->$_POST['post_id']->$_POST['key'])) {
                unset($data->$_POST['cat_id']->$_POST['post_id']->$_POST['key']);
                $token = (array) $data->$_POST['cat_id']->$_POST['post_id'];
                if (empty($token)) {
                    unset($data->$_POST['cat_id']->$_POST['post_id']);
                }
                $wp_session['pricing_sidebar_data'] = json_encode($data);
                echo json_encode(array('success' => 1));
                die();
            }
        } elseif (isset($data->$_POST['cat_id']->$_POST['post_id'])) {
            unset($data->$_POST['cat_id']->$_POST['post_id']);
            $wp_session['pricing_sidebar_data'] = json_encode($data);
            echo json_encode(array('success' => 1));
            die();
        }
        echo json_encode(array('success' => 0));
        die();
    }

    function edit_fee() {
        global $wp_session;
        $data = json_decode($wp_session['pricing_sidebar_data']);
        $token = &$data->$_POST['cat_id']->$_POST['post_id']->$_POST['key'];
        if ($_POST['type'] == '+') {
            $token->number++;
        } else {
            $token->number--;
        }
        $wp_session['pricing_sidebar_data'] = json_encode($data);
        echo json_encode(array('success' => 1));
        die();
    }

    function get_pricing_sidebar() {
        global $wp_session;
        $html = "<div class='row'>Your Plan</div>";
        $pricing_sidebar_data = array();
        if (isset($wp_session['pricing_sidebar_data'])) {
            $pricing_sidebar_data = json_decode($wp_session['pricing_sidebar_data']);
        }
        $total = 0;
        foreach ($pricing_sidebar_data as $cat_id => $data) {
            $sub_total = 0;
            $cat_name = get_the_category_by_id($cat_id);
            $html .= "<div class='row'>$cat_name</div>";
            foreach ($data as $post_id => $token) {
                $title = get_the_title($post_id);
                $html .= "<div class='row'>";
                $html .= "<div class='col-xs-10'>";
                $html .= "$title";
                $html .= "</div>";
                $html .= "<div class='col-xs-1'>";
                $html .= "<a href='javascript:void(0);' onclick='remove_from_itinerary(\"$cat_id\", \"$post_id\", \"0\");'>X</a>";
                $html .= "</div>";
                $html .= "</div>";
                foreach ($token as $key=>$tmp) {
                    $html .= "<div class='row'>";
                    $html .= "<div class='col-xs-5'>";
                    $html .= "{$tmp->name}";
                    $html .= "</div>";
                    $html .= "<div class='col-xs-2'>";
                    $html .= "<a href='javascript:void(0);' onclick='edit_fee(\"-\", \"$cat_id\", \"$post_id\", \"$key\", {$tmp->value});'>-</a>";
                    $html .= "{$tmp->number}";
                    $html .= "<a href='javascript:void(0);' onclick='edit_fee(\"+\", \"$cat_id\", \"$post_id\", \"$key\", {$tmp->value});'>+</a>";
                    $html .= "</div>";
                    $html .= "<div class='col-xs-3'>";
                    $amount = $tmp->number * $tmp->value;
                    $html .= "P$amount";
                    $html .= "</div>";
                    $html .= "<div class='col-xs-1'>";
                    $html .= "<a href='javascript:void(0);' onclick='remove_from_itinerary(\"$cat_id\", \"$post_id\", \"$key\");'>X</a>";
                    $html .= "</div>";
                    $html .= "</div>";
                    $sub_total += $amount;
                }
            }
            $html .= "<div class='row'>";
            $html .= "<div class='col-xs-10'>";
            $html .= "SubTotal";
            $html .= "</div>";
            $html .= "<div class='col-xs-1'>";
            $html .= $sub_total;
            $html .= "</div>";
            $html .= "</div>";
            $total += $sub_total;
        }
        $html .= "<div class='row'>";
        $html .= "<div class='col-xs-10'>";
        $html .= "Total";
        $html .= "</div>";
        $html .= "<div class='col-xs-1'>";
        $html .= $total;
        $html .= "</div>";
        $html .= "</div>";
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(array('success' => 1, 'html' => $html));
            die();
        }
        echo $html;
    }

    function ajax_action() {
        $_POST['m']();
    }

	function theme_add_custom_js() {
		wp_enqueue_script('scripts-js', get_template_directory_uri() . '/js/scripts.js', 'jquery', '1.0', false);
        wp_localize_script('scripts-js', 'Ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
		wp_enqueue_script('moment-js', get_template_directory_uri() . '/js/moment.min.js', 'moment', '2.0.0', false);
		wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.6', false);
		wp_enqueue_script('datetimepicker-js', get_template_directory_uri() . '/js/datetimepicker.min.js', 'datetimepicker', '4.17.37', false);
		wp_enqueue_script('selectize-js', get_template_directory_uri() . '/js/selectize.min.js', 'selectize', '', false);
	}
	add_action('wp_enqueue_scripts', 'theme_add_custom_js');
    add_action("wp_ajax_ajax_action", "ajax_action");
    add_theme_support('post-thumbnails'); 

	require_once('search/wpas.php');
	
	function search_box_attractions_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Attractions'
							);
		$args['form'] = array(
							'auto_submit' => false,
                            'disable_wrappers' => true,
							'name' => 'search_box_attractions_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array( 'type' => 'search', 
                                'class' => array('content-search-box'),
                                'placeholder' => 'Search your desired destination' );
		$args['fields'][] = array( 'type' => 'submit',
                               'class' => 'button',
                               'value' => 'Search' );
		register_wpas_form('attractions-search-form-search-box', $args);
	}
	add_action('init', 'search_box_attractions_ajax_search');
	
	function search_box_accommodations_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Accommodations'
							);
		$args['form'] = array(
							'auto_submit' => false,
                            'disable_wrappers' => true,
							'name' => 'search_box_accommodations_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array( 'type' => 'search', 
                                'class' => array('content-search-box'),
                                'placeholder' => 'Search your desired accommodation' );
		$args['fields'][] = array( 'type' => 'submit',
                               'class' => 'button',
                               'value' => 'Search' );
		register_wpas_form('accommodations-search-form-search-box', $args);
	}
	add_action('init', 'search_box_accommodations_ajax_search');
	
	function search_box_restaurants_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Restaurants'
							);
		$args['form'] = array(
							'auto_submit' => false,
                            'disable_wrappers' => true,
							'name' => 'search_box_restaurants_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array( 'type' => 'search', 
                                'class' => array('content-search-box'),
                                'placeholder' => 'Search your desired restaurant' );
		$args['fields'][] = array( 'type' => 'submit',
                               'class' => 'button',
                               'value' => 'Search' );
		register_wpas_form('restaurants-search-form-search-box', $args);
	}
	add_action('init', 'search_box_restaurants_ajax_search');
	
	function search_box_transportations_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Transportations'
							);
		$args['form'] = array(
							'auto_submit' => false,
                            'disable_wrappers' => true,
							'name' => 'search_box_transportations_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array( 'type' => 'search', 
                                'class' => array('content-search-box'),
                                'placeholder' => 'Search your desired transportation' );
		$args['fields'][] = array( 'type' => 'submit',
                               'class' => 'button',
                               'value' => 'Search' );
		register_wpas_form('transportations-search-form-search-box', $args);
	}
	add_action('init', 'search_box_transportations_ajax_search');
	
	function attractions_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Attractions'
							);
		$args['form'] = array(
							'auto_submit' => true,
							'name' => 'attractions_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'label' => '',
								'format' => 'checkbox',
								'meta_key' => 'attraction_type',
								'values' => array(
												'Mountains' => '&nbsp;Mountains',
												'Extreme Adventure' => '&nbsp;Extreme Adventure',
												'Beaches' => '&nbsp;Beaches',
												'Historical Landmarks' => '&nbsp;Historical Landmarks',
												'Museums' => '&nbsp;Museums',
												'Waterfalls' => '&nbsp;Waterfalls',
												'Churches' => '&nbsp;Churches',
												'Caves' => '&nbsp;Caves'
											),
								'compare' => 'IN',
								'data_type' => 'CHAR',
								'default' => ''
							);
		register_wpas_form('attractions-search-form', $args);
	}
	add_action('init', 'attractions_ajax_search');
	
	function accommodations_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Accommodations'
							);
		$args['form'] = array(
							'auto_submit' => true,
							'name' => 'accommodations_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'meta_key' => 'price_range',
								'format' => 'select',
								'label' => 'Price Range',
								'values' => array(
											0 => '-',
											1 => 'P500 - P1000',
											2 => 'P1000 - P2000',
											3 => 'P2000 - P5000',
										),
								'compare' => '=',
								'data_type' => 'NUMERIC',
								'default' => 0
							);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'meta_key' => 'capacity',
								'format' => 'select',
								'label' => 'Capacity',
								'values' => array(
											0 => '-',
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
											5 => 5
										),
								'compare' => '=',
								'data_type' => 'NUMERIC',
								'default' => 0
							);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'label' => '',
								'format' => 'checkbox',
								'meta_key' => 'amenities',
								'values' => array(
												'Air-Conditioned' => '&nbsp;Air-Conditioned',
												'TV' => '&nbsp;TV',
												'Wi-Fi' => '&nbsp;Wi-Fi',
												'Breakfast' => '&nbsp;Breakfast',
												'Kitchen' => '&nbsp;Kitchen',
												'Pool' => '&nbsp;Pool'
											),
								'compare' => 'IN',
								'data_type' => 'CHAR',
								'default' => ''
							);
		register_wpas_form('accommodations-search-form', $args);
	}
	add_action('init', 'accommodations_ajax_search');
	
	function restaurants_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Restaurants'
							);
		$args['form'] = array(
							'auto_submit' => true,
							'name' => 'restaurants_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'label' => '',
								'format' => 'checkbox',
								'meta_key' => 'offers',
								'values' => array(
												'Filipino' => '&nbsp;Filipino',
												'American' => '&nbsp;American',
												'Coffee Shop' => '&nbsp;Coffee Shop',
												'Mexican' => '&nbsp;Mexican',
												'Desserts' => '&nbsp;Desserts',
												'Cakes' => '&nbsp;Cakes'
											),
								'compare' => 'IN',
								'data_type' => 'CHAR',
								'default' => ''
							);
		register_wpas_form('restaurants-search-form', $args);
	}
	add_action('init', 'restaurants_ajax_search');
	
	function transportations_ajax_search() {
		$args = array();
		$args['wp_query'] = array(
								'post_type' => 'post',
								'posts_per_page' => 5,
								'category_name' => 'Transportations'
							);
		$args['form'] = array(
							'auto_submit' => true,
							'name' => 'transportations_ajax_search'
						);
		$args['form']['ajax'] = array(
									'enabled' => true,
									'show_default_results' => false,
									'results_template' => 'content.php',
									'button_text' => 'Load More Results'
								);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'label' => '',
								'format' => 'checkbox',
								'meta_key' => 'capability',
								'values' => array(
												'2-wheels' => '&nbsp;2-wheels',
												'4-wheels' => '&nbsp;4-wheels',
												'With Driver' => '&nbsp;With Driver',
												'With Fuel' => '&nbsp;With Fuel'
											),
								'compare' => 'IN',
								'data_type' => 'CHAR',
								'default' => ''
							);
		$args['fields'][] = array(
								'type' => 'meta_key',
								'meta_key' => 'vehicle_capacity',
								'format' => 'select',
								'label' => 'Capacity',
								'values' => array(
											0 => '-',
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
											5 => 5
										),
								'compare' => '=',
								'data_type' => 'NUMERIC',
								'default' => 0
							);
		register_wpas_form('transportations-search-form', $args);
	}
	add_action('init', 'transportations_ajax_search');
	
?>
