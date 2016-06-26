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

Edits made in wp-advanced-search plugin
1. renamed the folder wp-advanced-search to search
2. changed wp-admin to admn in ./src/Factory.php file. lines 197 and 259.
3. removed the caching of results in ./js/scripts.js. lines 122 to 130.
/*
    if (storage != null) {
        log("localStorage found");
        loadInstance();
    } else { */
        setPage(1);
        setRequest($(__WPAS.FORM).serialize());
//  }
4. added the automatic loading functionality while scrolling down the results in ./js/scripts.js. insert the code below on line number 177.
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


Needed Categories
1. Attractions
2. Accommodations
3. Restaurants
4. Transportations


What are needed in a Post for Attractions Category
1. Title
2. Category = Attractions
3. Featured Image
4. Content - this is still debatable if we should be using this for displaying the information like entrance fee, municipal fee and etc. I still haven't decided where to put the address, operating hours, estimated time of stay and etc...
5. Excerpt - will be used as the description for the pop-up?
6. Custom Fields - This is what we are using for knowing what attraction type this post belongs to 
   - name = attraction_type ==> value = Extreme Adventure (The value should be exactly the same in what's displayed in the checkboxes under Attractions Tab)
   - name = attraction_type ==> value = Mountains
