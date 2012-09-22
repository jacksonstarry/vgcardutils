var makePagingUrls = function(data) {
	var __paging_html="";
	var page = data.page;
	var current = data.current;
	var count = data.count;
	var prevPage = data.prevPage;
	var nextPage = data.nextPage;
	var pageCount = data.pageCount;
	var limit = data.limit;
	
	if(prevPage) {
		__paging_html +=
		'<span class="prev"><a href="javascript:queryCards(' + (page-1) +
		')" rel="prev">&lt; 上一页</a></span>';
	}
	
	if(nextPage) {
		__paging_html +=
		'<span class="prev"><a href="javascript:queryCards(' + (page+1) +
		')" rel="prev">下一页 &gt; </a></span>';
	}
	
	jQuery("#queries_paging").html(__paging_html);
}

var queryCards = function(page) {
	var urlParams = decodeURI( window.location.search.substring(1) ); 
	var keyValue_Collection = {};

	if(urlParams == false | urlParams == '') {
	} else {

		var pairs = urlParams.split("&amp;amp;amp;amp;");


		for(var value in pairs)
		{
			try {
				var equalsignPosition = pairs[value].indexOf("=");
			
				if (equalsignPosition == -1)
					keyValue_Collection[ pairs[value] ] = '';
				else
					keyValue_Collection[ pairs[value].substring(0, equalsignPosition) ] = pairs[value].substr(equalsignPosition + 1);
			}catch(e){}
			
		}
	}
	jQuery.ajax(
			{async:true, 

					 dataType:"jsonp", 
					 success:function (data, textStatus) {
						 var __queries_result = '' ;
						 for( var i=0;i<data.results.length;i++ ) {
							__queries_result+='<div style="float:left;display:block;padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px;">';
							__queries_result+="<h2>";
							__queries_result+=data.results[i].VgCard.serial;
							__queries_result+="&nbsp;";
							__queries_result+=data.results[i].VgCard.title;
							__queries_result+="</h2>";
							__queries_result+="<small>";
							__queries_result+=data.results[i].VgCard.subtitle;
							__queries_result+="&nbsp;";
							__queries_result+=data.results[i].VgRarity.title;
							__queries_result+="</small>";
							__queries_result+="<br />";
							__queries_result+='<img class="galleryImageBorder" width="126" height="183" style="float:left;display:block;border-style: solid;border-color: #ccc #aaa #aaa #ccc;margin-top: 5px; margin-bottom: 5px; margin-left: 0px; margin-right: 5px; border-width:1px;padding:3px;" src="';
							__queries_result+='http:\/\/vgproject.colintrinity.com\/img\/cards\/thumbnail\/thumbnail_' + (data.results[i].VgCard.serial).replace(/[^\d\w]/g,"_") + ".jpg";
							__queries_result+='" />';
							__queries_result+='<p style="width:300px;float:left;display:block;">';
							__queries_result+='势力《'+data.results[i].VgClan.title;
							__queries_result+='》&nbsp种族&lt;'+data.results[i].VgRace.title;
							__queries_result+='&gt;<br />';
							__queries_result+='技能：';
							__queries_result+=(data.results[i].VgCard.effect).replace("/\n/g","<br />");
							__queries_result+='</p>';
							__queries_result+='</div>';
							if(i%2!=0){__queries_result+='<div style="clear:both;"></div>';}
						 }
						
						 jQuery("#queries_result").html(__queries_result);
						 makePagingUrls(data.paging);
					}, 

					url:"http:\/\/vgproject.colintrinity.com\/queries\/view\/type:jsonp" + "\/page:"+page,
					data:keyValue_Collection,
					crossDomain:true
					});
	}
