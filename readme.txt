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

Info needed in the Attraction Category Posts
1. Title
2. Featured Image = 200 x 200 image - we must create a default image if this is not available.
3. Category = Attractions
4. Custom Fields
  - Name = attraction_type is the needed keyword for setting the category filter of the Attraction
  - Value = e.g. Mountains, Beaches, etc...
  - Just add another attraction_type with a different value if the Attraction is under multiple category filters.
5. Field Group for Attractions Category - please see details below on the details in creating the field group.

Creating Field Groups for Attractions Category
Field Groups -> Add New
1. Title = Attractions Additional Information
2. Fields = (Label - Name - Field Type - Default Value - Validation - Notes) - Name is the only critical field used in the codes.
  - Address - address - Text - none - required - Up To You
  - Estimated Time of Stay - etos - Text - Estimated Time of Stay: - required - Up to You
  - Description - description - Textarea - none - required - Up to You
  - Fees - fees - Textarea - none - not required - This is still temporary until the fees feature is finalized.
  - Just add more if needed.
3. Placement Rules
  - Post Types = post
  - User Roles = blank
  - Posts = blank
  - Taxonomy Terms = (category)Attractions
  - Page Templates = blank
4. Extras - Up to You
Field Groups -> Tools
  - We can use the import/export feature and commit the necessary field groups in the boundbohol theme.

note: We can also create just one Field Group for all Categories but let's just separate them for now. We can just consolidate all of them later if we really need to.

--------------------------------------------------------------------------------------