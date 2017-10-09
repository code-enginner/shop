//var modal = get._id('register');
//modal.addEventListener('click', function (e)
//{
//    e.preventDefault();
//    if (this.getAttribute("data-modal-hide") === 'true')
//    {
//        console.log('yes');
//    }
//
//});

var register = get._id('register');
register.addEventListener('click', function ()
{
    var modal = get._id('modal');
    modal.classList.add('fillBack_active');
    document.body.style.overflow = 'hidden';
});

var modal_close = get._class('modal_close');
for (var i = 0; i < modal_close.length; i++)
{
    modal_close[i].addEventListener('click', function ()
    {
        var modal, login_modal;
        modal = get._id('modal');
        modal.classList.remove('fillBack_active');

        login_modal = get._id('login_modal');
        login_modal.classList.remove('fillBack_active');
        document.body.style.overflow = 'visible';
    });
}



var user_login = get._id('user_login');
user_login.addEventListener('click', function ()
{
    var login_modal = get._id('login_modal');
    login_modal.classList.add('fillBack_active');
    document.body.style.overflow = 'hidden';
});

var fields = get._class('user_fields');
console.log(fields);




var registering = get._id('registering');
registering.addEventListener('click', function ()
{

});