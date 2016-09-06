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
        <br />
        <br />
        <br />
        <br />
        <br />
";
more_info_modal($post_info);
echo "
    </div>
</div>
";

?>
