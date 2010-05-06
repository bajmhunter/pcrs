var timeOut= 50;
var closeTimer = 0;
var showMenuItem = 0;

function menuOpen(ID)
{
	
	menuCancelCloseTimer();
	if(showMenuItem)
            showMenuItem.style.visibility = 'hidden';

        showMenuItem = document.getElementById(ID);
	showMenuItem.style.visibility = 'visible';
}

function menuClose()
{
	if(showMenuItem) showMenuItem.style.visibility = 'hidden';
}


function menuCloseTimer()
{
	closeTimer = window.setTimeout(menuClose, timeOut);
}


function menuCancelCloseTimer()
{
	if(closeTimer)
	{
		window.clearTimeout(closeTimer);
		closeTimer = null;
	}
}

document.onclick = menuClose;
