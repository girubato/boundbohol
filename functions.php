<?php

    function more_info_modal($id='', $title='') {
        list($the_custom_amount_meta_pop_up, $update_defaults_script) = the_custom_amount_meta_pop_up('total-amount-post-id-' . $id);
        $html = '
            <button onclick="'.$update_defaults_script.'" type="button" class="btn btn-primary" data-toggle="modal" data-target="#post-modal-id-'.$id.'"> More Info </button>
        
            <div class="modal fade large" id="post-modal-id-'.$id.'" tabindex="-1" role="dialog" aria-labelledby="post-label-id-'.$id.'">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modal-title-id-'.$id.'">'.$title.'</h4>
                        </div> -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab">Photos</a></li>
                                        <li role="presentation"><a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
                                    <!-- disabled for now
                                        <li role="presentation"><a href="#map" aria-controls="map" role="tab" data-toggle="tab">Map</a></li>
                                        <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                                    -->
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="photos">
                                        
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="videos">
                                        
                                        </div>
                                    <!-- disabled for now
                                        <div role="tabpanel" class="tab-pane" id="map">
                                        
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="reviews">
                                        
                                        </div>
                                    -->
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <h4>'.$title.'</h4>
                                    '.get_the_excerpt().'
                                    <br>
                                    <!--
                                    <div>&nbsp;</div>
                                    ' . $the_custom_amount_meta_pop_up . '
                                    <div>&nbsp;</div>
                                    <div class="total-amount-post" id="total-amount-post-id-'. $id .'-pop-up"></div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        echo $html;
    }

    function the_custom_amount_meta_pop_up($total_amount_id='') {
        $html = '';
        $update_defaults_script = '';
        if ( $keys = get_post_custom_keys() ) {
            foreach ( (array) $keys as $key ) {
                $meta_key = trim($key);
                if ( is_protected_meta( $meta_key, 'post' ) ) {
                    continue;
                } elseif (!preg_match('/\_prices\_/i', $meta_key)) {
                    continue;
                }
                $value = array_shift(get_post_custom_values($key));
                $token = explode('---', $value);
                $label = array_shift($token);
                $amount = array_shift($token);
                $default = array_shift($token);
                if (preg_match('/^number\_/i', $meta_key)) {
                    $html .= "<div>";
                    $html .= "<div class='custom-amount-label'>$label</div>";
                    $html .= "<div class='float-left'>";
                    $html .= "<a href='javascript:void(0);' onclick='plusMinusNumPopUp(\"-\", \"$meta_key\", $amount, \"$total_amount_id\")'>-</a>";
                    $html .= "&nbsp;<input id='{$meta_key}_number_pop_up' type='text' value=$default disabled='disabled' size=3 />";
                    $html .= "&nbsp;<a href='javascript:void(0);' onclick='plusMinusNumPopUp(\"+\", \"$meta_key\", $amount, \"$total_amount_id\")'>+</a></div>";
                    $html .= "<div class='float-right'' id='{$meta_key}_amount_pop_up'>P".($amount*$default)."</div><div class='clear'></div>";
                    $html .= "</div>";
                    $update_defaults_script .= "updateTotalAmountDefaults('$total_amount_id', '$meta_key');";
                }
            }
        }
        return array($html, $update_defaults_script);
    }

    function the_custom_amount_meta($total_amount_id='', $return=false) {
        $html = '';
        if ( $keys = get_post_custom_keys() ) {
            $set_defaults_script = '';
            $total_amount = 0;
            foreach ( (array) $keys as $key ) {
                $meta_key = trim($key);
                if ( is_protected_meta( $meta_key, 'post' ) ) {
                    continue;
                } elseif (!preg_match('/\_prices\_/i', $meta_key)) {
                    continue;
                }
                $value = array_shift(get_post_custom_values($key));
                $token = explode('---', $value);
                $label = array_shift($token);
                $amount = array_shift($token);
                $default = array_shift($token);
                if (preg_match('/^number\_/i', $meta_key)) {
                    $html .= "<div>";
                    $html .= "<div class='custom-amount-label'>$label</div>";
                    $html .= "<div class='float-left'>";
                    $html .= "<a href='javascript:void(0);' onclick='plusMinusNum(\"-\", \"$meta_key\", $amount, \"$total_amount_id\")'>-</a>";
                    $html .= "&nbsp;<input id='{$meta_key}_number' type='text' value=$default disabled='disabled' size=3 />";
                    $html .= "&nbsp;<a href='javascript:void(0);' onclick='plusMinusNum(\"+\", \"$meta_key\", $amount, \"$total_amount_id\")'>+</a></div>";
                    $html .= "<div class='float-right'' id='{$meta_key}_amount'>P".($amount*$default)."</div><div class='clear'></div>";
                    $html .= "</div>";
                    $set_defaults_script .= "setTotalAmountDefaults('$total_amount_id', '$meta_key', '$default', '$amount', '$total_amount');";
                } elseif (preg_match('/^checkbox\_/', $meta_key)) {
                /**
                    $checked = $default ? 'checked' : '';
                    print "<div>";
                    print "<input ref='javascript:void(0);' onclick='onOffCheckbox(\"$meta_key\", $amount, \"$total_amount_id\")' type='checkbox' id='{$meta_key}_checkbox' $checked />&nbsp;$label";
                    print "</div>";
                 */
                }
                $total_amount += $amount*$default;
            }
            $html .= "<script type='text/javascript'>";
            $html .= $set_defaults_script;
            $html .= "updateTotalAmount('$total_amount_id', $total_amount);";
            $html .= "</script>";
        }
        if ($return) return $html;
        echo $html;
    }

	function theme_add_bootstrap() {
		wp_register_script( 'scripts-js', get_template_directory_uri() . '/js/scripts.js', 'jquery', '1.0',  false);
		wp_enqueue_script( 'scripts-js' );
		wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(), '3.3.6', true);
	}
	add_action('wp_enqueue_scripts', 'theme_add_bootstrap');
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
