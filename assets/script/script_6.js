var show_more = get._class('show_more_info');
var content = get._class('more_info');

function show_content()
{
    for (var j = 0; j < show_more.length; j++)
    {
        (function (j)
        {
            show_more[j].addEventListener('click', function ()
            {
                var temp_0 = show_more[j].className;
                var allClass_0 = temp_0.split(' ');
                if (allClass_0[1] && allClass_0[1] === 'header_active')
                {
                    show_more[j].classList.remove('header_active');
                    show_more[j].innerHTML = 'نمایش اطلاعات بیشتر<i class="fa fa-angle-down"></i>';
                }
                else
                {
                    show_more[j].classList.add('header_active');
                    show_more[j].innerHTML = 'پنهان کن<i class="fa fa-angle-down"></i>';
                }


                var temp = content[j].className;
                var allClass = temp.split(' ');

                if (allClass[1] && allClass[1] === 'show')
                {
                    content[j].classList.remove('show');
                }
                else
                {
                    content[j].classList.add('show');
                }
            })
        })(j);
    }
}
show_content();