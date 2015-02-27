var cookieExpires = 7;
var commonEasing = 'easeOutExpo';
var windowScrollTop, windowScrollTopLast, uncompletedScroll = 0;

$(document).ready(function()
{
    fixMMenuvisibility();

    $(window).on('resize', function(){ fixMMenuvisibility(); });

    initSlideUpButton();

    initNotification();

    initExpandableNav();

    initDelConfirmations();
});

var expand = function(expandable)
{

    var expanded = expandable.css('display') == 'none';

    expandContainer(expandable, expanded);
};

function initExpandableNav()
{

    var container = $('.content .aside .nav');
    var btns = container.find(' > li i');

    btns.each(function(){
        $(this).on('click', function(){
            expandNav(this);
        });
    });
}

function initSlideUpButton()
{
    var container = $('.slide-up');

    $(window).scroll(function () {
        windowScrollTop = $(window).scrollTop();

        if(windowScrollTop || windowScrollTopLast) container.fadeIn(); else container.fadeOut();

        if(windowScrollTop && windowScrollTopLast && container.hasClass('top') && !uncompletedScroll) container.removeClass('top');

    });

    container.on('click', function(){
        uncompletedScroll = 1;

        if((windowScrollTop == 0) && windowScrollTopLast){
            $(this).removeClass('top');
            $('html,body').animate({scrollTop:windowScrollTopLast}, 400, 'easeOutQuint', function(){
                uncompletedScroll = 0;
            });
        }else{
            windowScrollTopLast = windowScrollTop;
            $(this).addClass('top');
            $('html,body').animate({scrollTop:0}, 400, 'easeOutQuint', function(){
                uncompletedScroll = 0;
            });
        }
    });

    /*
    container.on('click', function(){
        if((windowScrollTop == 0) && (windowScrollTopLast > 0)){
            $(this).removeClass('top');
            $('html,body').animate({scrollTop:windowScrollTopLast}, 400, 'easeOutQuint');
        }else{
            windowScrollTopLast = windowScrollTop;
            $(this).addClass('top');
            $('html,body').animate({scrollTop:0}, 400, 'easeOutQuint');
        }
    });
    */
}

function initDelConfirmations(){
    var containers = $('.edit-grid .items .c1');
    var confirmation = $('.del-confirm-src').html();
    var id = 0;
    var location = '';

    containers.on('mouseover', function(){
        id = Math.round($(this).text());
        containers.find('.del-confirm').remove();
        $(confirmation).appendTo(this);
        containers.find('a').on('click', function(e){
            e.preventDefault();
            location = $(this).attr('href');
            location += '/'+id;
            deleteItem(location, id);
        });
    });
}

function expandNav(el) {

    var clickable = $(el);
    var container = $(el).parent();
    var expandable = container.find('ul');

    expand(expandable);
}


function fixMMenuvisibility() {

    var expandable = $('.menu');
    var width = $(document).width();

    if(width < 800){
        expandContainer(expandable, false, true);
    }else{
        expandContainer(expandable, true);
    }
}

function initNotification(){

    var cookieName = 'notificationCollapsed';
    var expandable = $('.notification');
    var btn = expandable.find('.close');

    if(cookie(cookieName)) {
        expandable.hide();
    }else if(typeof(notificationOpened) != 'undefined'){
        expandable.show();
    }

    btn.on(
        'click',
        function()
        {
            expandContainer(expandable, false);
            cookie(cookieName, 1);
        }
    );
}


function signup() {

    var container = $('.login.form');
    var form = container.find('form');

    var options = {
        success: function (response){
            if(response.message){
                alert(response.message);
            }else if(response.location){
                document.location.assign(response.location);
            }else if(response.html){

            }
        },
        url: '/signup/do/',
        dataType:  'json'
    };

    form.ajaxSubmit(options);

    return false;
}

function login() {

    var container = $('.login.form');
    var form = container.find('form');

    var options = {
        success: function (response){
            if(response.message){
                alert(response.message);
            }else if(response.location){
                document.location.assign(response.location);
            }else if(response.html){

            }
        },
        dataType:  'json'
    };

    form.ajaxSubmit(options);

    return false;
}

function saveItem() {

    var container = $('.edit-form');
    var form = container.find('form');

    var options = {
        success: function (response){
            if(response.message){
                ohSnap(response.message, 'red');
            }else if(response.okMessage){
                ohSnap(response.okMessage, 'green');
            }
            if(response.location){
                document.location.assign(response.location);
            }
        },
        dataType:  'json'
    };

    form.ajaxSubmit(options);

    return false;
}

function deleteItem(location, id) {

    var row = $('.edit-grid #row'+id);

    $.get(location, function(response){
        if(response.message){
            ohSnap(response.message, 'red');
        }else if(response.okMessage){
            ohSnap(response.okMessage, 'green');
            row.slideUp('fast', commonEasing);
        }
        if(response.location){
            document.location.assign(response.location);
        }
    }, 'json');

    return false;
}



function wait(el){
    el.addClass('fa-spinner');
}

function waitRelease(el){
    el.removeClass('fa-spinner');
}

function toggleState(objs){
    var state, altState;

    if(typeof(swap) == 'undefined') var swap = true;

    objs.each(function(){
        state = $(this).html();
        altState = $(this).attr('opt');

        if(swap) $(this).attr('opt', state);
        if(altState) $(this).html(altState);
    });
}

function expandContainer(expandable, expanded, fast) {

    var parent = expandable.parent();

    if(typeof (fast) != 'undefined') fast = 0; else fast = 500;

    if(expanded){
        expandable.slideDown(fast, 'easeOutQuint', function(){
            parent.addClass('active');
        });
    }else{
        expandable.slideUp(fast, 'easeOutQuint', function(){
            parent.removeClass('active');
        });
    }
}

function cookie(name, value)
{
    var valueType = typeof (value);

    if(valueType != 'undefined'){
        if(valueType != 'null'){
            return $.cookie(name, value, { expires: cookieExpires, path: '/' });
        }else{
            return $.removeCookie(name, value, { path: '/' });
        }

    }else{
        return $.cookie(name);
    }
}

function showRegionSelector(countryId, regionId){
    var container = $('.region-selector');

    $.post('/ajaj/cities/showRegionSelector',
        {
            countryId: countryId,
            regionId: regionId
        },
        function(response){
            container.html(response.html);
        }, 'json');
}

function showCitySelector(countryId, regionId, cityId){
    var container = $('.region-selector');

    container.find('.form-row:last-child').remove();

    $.post('/ajaj/cities/showCitySelector',
        {
            countryId: countryId,
            regionId: regionId,
            cityId: cityId
        },
        function(response){
            container.html(response.html);
    }, 'json');
}

function showSearchFormCitySelector(regionId){
    var container = $('.search-form .region-selector');

    $.post('/ajaj/cities/showSearchFormCitySelector',
        {regionId: regionId},
        function(response){
            container.html(response.html);
        }, 'json');
}