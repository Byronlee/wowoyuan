// Apprise 1.5 by Daniel Raftery
// http://thrivingkings.com/apprise
//
// Button text added by Adam Bezulski
//

function apprise(string, args, callback)
	{
	var default_args =
		{
		'confirm'		:	false, 		// Ok and Cancel buttons
		'verify'		:	false,		// Yes and No buttons
		'input'			:	false, 		// Text input (can be true or string for default text)
		'animate'		:	false,		// Groovy animation (can true or number, default is 400)
		'textOk'		:	'确定',		// Ok button default text
		'textCancel'	:	'取消',	// Cancel button default text
		'textYes'		:	'Yes',		// Yes button default text
		'textNo'		:	'No'		// No button default text
		}
	
	if(args) 
		{
		for(var index in default_args) 
			{ if(typeof args[index] == "undefined") args[index] = default_args[index]; } 
		}
	
	var aHeight = $(document).height();
	var aWidth = $(document).width();
	$('body').append('<div class="appriseOverlay" id="aOverlay"></div>');
	$('.appriseOverlay').css('height', aHeight).css('width', aWidth).fadeIn(100);
	$('body').append('<div class="appriseOuter"></div>');
	$('.appriseOuter').append('<div class="appriseInner"></div>');
	$('.appriseInner').append(string);
   $('.appriseOuter').css("left", ( $(window).width()) /(5/2)+"px");
   $('.appriseOuter').css("top", ( $(window).height() ) / 2 + "px");
  
    
    if(args)
		{
		if(args['animate'])
			{ 
			var aniSpeed = args['animate'];
			if(isNaN(aniSpeed)) { aniSpeed = 400; }
		//	$('.appriseOuter').css('top', ( $(window).height() ) / 2 + "px").show().animate({top:"00px"}, aniSpeed);
			}
		else
			{ $('.appriseOuter').fadeIn(200); }
		}
	else
		{ $('.appriseOuter').fadeIn(200); }
    
    if(args)
    	{
    	if(args['input'])
    		{
    		if(typeof(args['input'])=='string')
    			{
//    			$('#appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" value="'+args['input']+'" /></div>');
    			}
    		else
    			{
				$('.appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" /></div>');
				}
			$('.aTextbox').focus();
    		}
    	}
    
    $('.appriseInner').append('<div class="aButtons"></div>');
    if(args)
    	{
		if(args['confirm'] || args['input'])
			{ 
			$('.aButtons').append('<button value="确定">'+args['textOk']+'</button>');
			$('.aButtons').append('<button value="取消">'+args['textCancel']+'</button>'); 
			 setTimeout("remove()",0);
			}
		else if(args['verify'])
			{
			$('.aButtons').append('<button value="确定">'+args['textYes']+'</button>');
			$('.aButtons').append('<button value="取消">'+args['textNo']+'</button>');
			 setTimeout("remove()",0);
			}
		else
			{ $('.aButtons').append('<button value="确定">'+args['textOk']+'</button>');
			 setTimeout("remove()",0);
			
			}
		}
    else
    	{ $('.aButtons').append('<button value="ok">确定</button>'); 
    	    setTimeout("remove()",0);
    	}
	function remove(){
		$('.appriseOverlay').hide();
		$('.appriseOuter').hide();
	}
	$(document).keydown(function(e) 
		{
		if($('.appriseOverlay').is(':visible'))
			{
			if(e.keyCode == 13) 
				{ $('.aButtons > button[value="确定"]').click(); }
			if(e.keyCode == 27) 
				{ $('.aButtons > button[value="取消"]').click();				
				}
			}
		});
	
	var aText = $('.aTextbox').val();
	if(!aText) { aText = false; }
	$('.aTextbox').keyup(function()
    	{ aText = $(this).val(); });
   
    $('.aButtons > button').click(function()
    	{
    	$('.appriseOverlay').remove();
		$('.appriseOuter').remove();
    	if(callback)
    		{
			var wButton = $(this).attr("value");
			if(wButton=='确定')
				{ 
				if(args)
					{
					if(args['input'])
						{ callback(aText); }
					else
						{ callback(true); }
					}
				else
					{ callback(true); }
				}
			else if(wButton=='取消')
				{ callback(false); }
			}
		});
	}
