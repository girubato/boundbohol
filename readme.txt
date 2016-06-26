Installation Procedure
1. download wordpress 4.4.2
2. change the default directories - please see edit_directories.sh on how to do it
3. create database
4. install wordpress
5. delete all the default themes in the themes folder
6. download the boundbohol theme in github https://github.com/jpestilos/boundbohol.git
7. add the boundbohol theme in the themes folder
8. activate the boundbohol theme

--------------------------------------------------------------------------------------

Required Plugin - Custom Field Suite
  -- this will be used for adding additional information like address, fees, description and etc...
  -- this was chosen instead of ACF(Advanced Custom Fields) because this is easier to use and is lightweight
  -- https://github.com/mgibbs189/custom-field-suite
  -- http://docs.customfieldsuite.com/
Installation Procedure
1. Download the plugin
2. Edit the wp-admin keywords to admn inside the includes/upgrade.php file
3. Activate the plugin

--------------------------------------------------------------------------------------

Required Feature - Wp Advanced Search
  -- This is already included in the boundbohol theme. This is just a reminder.
  -- https://github.com/bootsz/wp-advanced-search
  -- wpadvancedsearch.com 
Installation Procedure
1. copy the wp-advanced-search folder into the theme
2. rename the folder wp-advanced-search to search
3. changed wp-admin to admn in ./src/Factory.php file. lines 197 and 259.
4. removed the caching of results in ./js/scripts.js. lines 122 to 130.
/*
    if (storage != null) {
        log("localStorage found");
        loadInstance();
    } else { */
        setPage(1);
        setRequest($(__WPAS.FORM).serialize());
//  }
5. added the automatic loading functionality while scrolling down the results in ./js/scripts.js. insert the code below on line number 177.
                        $(window).scroll(function() {
                            if ($(window).scrollTop() >= (($(document).height() - $(window).height()) - $('button#wpas-load-btn').innerHeight())) {
                                if( $('button#wpas-load-btn').is(':hidden') ){
                                }
                                else {
                                    setPage(parseInt(CURRENT_PAGE) + 1)
                                    sendRequest(REQUEST_DATA,CURRENT_PAGE);
                                }
                            }
                        });

--------------------------------------------------------------------------------------

Needed Categories
1. Attractions
2. Accommodations
3. Restaurants
4. Transportations

--------------------------------------------------------------------------------------

Posts for Attractions Category
 -- still finalizing how to maximize the use of Custom Field Suite
 -- will have to decide the final keywords to be used
