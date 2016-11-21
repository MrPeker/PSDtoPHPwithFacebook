var clickSearch = 0;
function searchClick()
{	
	if(clickSearch % 2 == 0)
	{
		$('div.header-pages>ul>li').stop().animate({paddingRight: "5%"},300);
		$('div.header-search>form>input').stop().animate({left: "-220px" },300);
		$('div.header-search>form>input').show('fast');
		
		clickSearch++
	}
	else 
	{
		$('div.header-search>form>input').hide('fast');
		$('div.header-pages>ul>li').stop().animate({paddingRight: "10%"},300);
		$('div.header-search>form>input').animate({left: "-220px" },300);
		clickSearch++
	}
	
}
