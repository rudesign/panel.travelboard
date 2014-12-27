var cookieExpires = 7;

$(document).ready(function(){

    fixMMenuvisibility();

    $(window).on('resize', function(){ fixMMenuvisibility(); });

    initNotification();

    initExpandableNav();
});

var expand = function(expandable) {

    var expanded = expandable.css('display') == 'none';

    expandContainer(expandable, expanded);
};

function initExpandableNav() {

    var container = $('.content .aside .nav');
    var btns = container.find(' > li i');

    btns.each(function(){
        $(this).on('click', function(){
            expandNav(this);
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

function wait(el){
    el.addClass('fa-spinner');
}

function release(el){
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