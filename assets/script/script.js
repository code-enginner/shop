$(document).ready(function ()
{
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});


var admin_menu_opener = get._id('top_left_menu');
admin_menu_opener.onclick= function ()
{
    var admin_menu = get._id('sub_admin_menu');
    if (admin_menu.style.height === '5.2em')
    {
        admin_menu.style.height = 0;
    }
    else
    {
        admin_menu.style.height = '5.2em';
    }
};


var logout = get._id('exit');
logout.addEventListener('click', exit);
function exit()
{
    var parent = get._id('sub_admin_menu');
    parent.classList.toggle('_fix');
}

var _close, _cancel;
_close = get._id('_close');
_cancel = get._id('_cancel');
_close.addEventListener('click', adminLogout);
_cancel.addEventListener('click', adminLogout);
function adminLogout(e)
{
    var attr, wrapper, body;
    attr = e.target.getAttribute('id');
    wrapper = get._id('sub_admin_menu');
    body = document.body;
    if (attr === '_cancel')
    {
        wrapper.classList.toggle('_fix', false);
        return false;
    }
    else if (attr === '_close')
    {
        return window.location = 'logout.php';
    }
}



document.body.onclick = function (e)
{
    var attr2 = e.target.getAttribute('id');
    if (attr2 === 'myModal')
    {
        var wrapper = get._id('sub_admin_menu');
        wrapper.classList.toggle('_fix', false);
        return false;
    }
};

document.body.onkeyup = function (e)
{
    if (e.keyCode === 27)
    {
        var wrapper = get._id('sub_admin_menu');
        wrapper.classList.toggle('_fix', false);
        return false;
    }
};



//var item = document.getElementsByClassName('cms_item');
//for (var i = 0; i < item.length; i++)
//{
//    item[i].addEventListener('click', function () {
//        if (this.className === 'active')
//        {
//            this.classList.remove('active');
//            this.onmouseover = function ()
//            {
//                this.style.backgroundColor = '#01579b';
//            };
//        }
//        else
//        {
//            this.classList.add('active');
//        }
//    });
//}



var cat_delete = get._id('_delete');
cat_delete.addEventListener('click', catDelete);
function catDelete ()
{
    return window.location = 'cat_delete.php';
}

