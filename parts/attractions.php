<?php

echo "
<div class='content-container'>
    <div class='content-left'>
";
if (has_post_thumbnail()) {
    the_post_thumbnail(array(200, 200));
} else {
    $thumbnail = "<img src='' width=200 height=200 />";
    echo $thumbnail;
}

$title = get_the_title();
$address = CFS()->get('address');
$etos = CFS()->get('etos');
$description = CFS()->get('description');
$fees = CFS()->get('fees');
$more_info_button = more_info_modal(get_the_ID(), get_the_title());


$html = "
    </div>
    <div class='content-middle'>
        <div><h4>$title</h4></div>
        <div>$address</div>
        <div>$etos</div>
        <hr>
        <div>$fees</div>
    </div>
    <div class='content-right'>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <div>$more_info_button</div>
    </div>
</div>
";

echo $html;

?>
