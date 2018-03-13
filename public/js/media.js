jQuery(document).ready(function($) {
    var $body = $('body');

    // on popup opening
    $body.on('click', '.media-popin-with-tabs', function(event) {

        // List Tabs Container
        var $tabsListContainer = $(this).attr('data-modal-content-id') + '_tabcontainer';
        
        // Find opened tab
        var $selectedTab = $('.' + $tabsListContainer).find('a[aria-selected=true]');

        // Find tab content container
        var $tabContainer = $('#'+$($selectedTab).attr('aria-controls'));

        // Where to find content to load
        var url = $($selectedTab).attr('data-url');


        $.ajax({
            type: 'POST',
            url: url
        }).success(function(data) {
            $($tabContainer).html(data);
        }).error(function(xhr, ajaxOptions, thrownError) {
            $($tabContainer).html(xhr.responseText);
        });
    });


    // On tab click
    $body.on('click', '.js-tablist__link', function(event) {
        // Where to find content to load
        var url = $(this).attr('data-url');

        // Find tab content container
        var $tabContainer = $('#'+$(this).attr('aria-controls'));

        $.ajax({
            type: 'POST',
            url: url
        }).success(function(data) {
            $($tabContainer).html(data);
        }).error(function(xhr, ajaxOptions, thrownError) {
            $($tabContainer).html(xhr.responseText);
        });
    });
});