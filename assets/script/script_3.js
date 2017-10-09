function showContent(e, scope)
{
    var i, tabLink, tabContent, current_content;

    tabLink = get._class('tabLink');
    tabContent = get._class('tabContent');
    current_content = get._id(scope);

    for (i = 0; i < tabLink.length; i++)
    {
        tabLink[i].classList.remove('active');
    }

    for (i = 0; i < tabContent.length; i++)
    {
        tabContent[i].classList.remove('show_des');
    }

    e.currentTarget.classList.add('active');


    current_content.style.display = 'block';
    current_content.classList.add('show_des');
}


function closing(e, scope, trigger)
{
    var content, trigger_elm;
    trigger_elm = get._id(trigger);
    content = get._id(scope);

    if (content.classList.length > 2)
    {
        content.style.display = 'none';
        content.classList.remove('show_des');
    }

    if (trigger_elm.classList.length > 1)
    {
        trigger_elm.classList.remove('active');
    }
}

function tab_link(e, scope, parent)
{
    var i, tabLink, tabContent, result, par;

    tabLink = get._class('full_info_tabHeader');
    tabContent = get._class('full_info_tab_content');
    result = get._id(scope);
    par = get._class(parent);


    for (i = 0; i < tabLink.length; i++)
    {
        tabLink[i].classList.remove('active_2');
    }

    for (i = 0; i < tabContent.length; i++)
    {
        tabContent[i].classList.remove('show_content');
        //if (tabContent[i].style.maxHeight)
        //{
        //    tabContent[i].style.maxHeight = 0;
        //    tabContent[i].style.visibility = 'hidden';
        //}
    }

    e.currentTarget.classList.add('active_2');
    result.classList.add('show_content');
    //result.style.visibility = 'visible';
    //result.style.maxHeight = result.scrollHeight + 'px';
}
