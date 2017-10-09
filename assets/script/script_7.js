function tab_switch(tab, content, e)
{
    var tab_trigger, tab_content, contents, tabs, i, j, activated_tab;

    tab_trigger = tab;
    tab_content = get._id(content);
    contents = get._class('tab_content_inner');
    tabs = get._class('tab_link');

    for (i = 0; i < contents.length; i++)
    {
        contents[i].classList.remove('show_content');
    }

    for (j = 0; j < tabs.length; j++)
    {
        tabs[j].classList.remove('active_tab');
    }

    activated_tab= e.currentTarget;
    activated_tab.classList.add('active_tab');
    tab_content.classList.add('show_content');
}