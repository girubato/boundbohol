<?php

echo "
<div class='row item-border'>
    <div class='col-xs-3 nopadding'>
";
if (has_post_thumbnail()) {
    the_post_thumbnail(array(170, 170));
} else {
    $thumbnail = "<img src='' width=170 height=170 />";
    echo $thumbnail;
}

$post_info = array();
$post_info['post_id'] = get_the_ID();
$post_info['title'] = $title = get_the_title();
$post_info['address'] = $address = CFS()->get('address');
$post_info['etos'] = $etos = CFS()->get('etos');
$post_info['description'] = $description = CFS()->get('description');
$post_info['fees'] = $fees = CFS()->get('fees');
$post_info['pg_id'] = CFS()->get('photo_gallery_id');
$post_info['vg_id'] = CFS()->get('video_gallery_id');
if (!is_numeric($post_info['pg_id'])) {
    $post_info['pg_id'] = 0;
}
if (!is_numeric($post_info['vg_id'])) {
    $post_info['vg_id'] = 0;
}
$atib = '&nbsp;';
$total_amount_id = 'total-amount-post-id-' . $post_info['post_id'];
if (empty($fees)) {
    $fees = the_custom_amount_meta($cat, $post_info['post_id'], $total_amount_id, true);
    $atib = "<button onclick='add_to_itinerary(\"$cat\", \"{$post_info['post_id']}\");' type='button' class='btn btn-primary'>Add to<br>Itinerary</button>";
}

echo "
    </div>
    <div class='col-xs-7'>
        <div><h4>$title</h4></div>
        <div>$address</div>
        <div>$etos</div>
        <hr>
        <div>$fees</div>
    </div>
    <div class='col-xs-2 nopadding'>
        <div id='$total_amount_id'></div>
        <div>$atib</div>
        <br />
        <br />
        <br />
        <div>
";
more_info_modal($post_info, $cat, $total_amount_id, $atib);
echo "
        </div>
    </div>
</div>
";

?>
