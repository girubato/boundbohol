<div class='sidebar s0'>
    <div class="pad">
    </div>
</div>

<div class="sidebar s1">
		<div class="pad">
		
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" onclick="attractions_tab();" aria-expanded="true" aria-controls="collapseOne">
          Attractions
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
			<?php
				$search = new WP_Advanced_Search('attractions-search-form');
				$search->the_form();
			?>
	  </div>
    </div>
  </div>
<!--
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" onclick="accommodations_tab();" aria-expanded="false" aria-controls="collapseTwo">
          Accommodations
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
			<?php
				#$search = new WP_Advanced_Search('accommodations-search-form');
				#$search->the_form();
			?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" onclick="restaurants_tab();" aria-expanded="false" aria-controls="collapseThree">
          Restaurants
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
			<?php
				#$search = new WP_Advanced_Search('restaurants-search-form');
				#$search->the_form();
			?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" onclick="transportations_tab();" aria-expanded="false" aria-controls="collapseFour">
          Transportations
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
      <div class="panel-body">
			<?php
				#$search = new WP_Advanced_Search('transportations-search-form');
				#$search->the_form();
			?>
      </div>
    </div>
  </div>
-->
</div>
				
		</div>
	</div><!--/.sidebar-->

	<div class="sidebar s2">
		<div class="pad">
		</div>
	</div><!--/.sidebar-->
