<?php function ip2location($ip2locationIpAddr){$hasilip2loc=ue_query("SELECT * FROM ip2location WHERE INET_ATON('".$ip2locationIpAddr."') <= ip2location_to LIMIT 1");@ $hasilip2loc=ue_fetch_array($hasilip2loc);if($hasilip2loc['ip2location_countrycode']==''||$hasilip2loc['ip2location_countrycode']=='-'||is_array($hasilip2loc)==false){$hasilip2locRet=array('code'=>'-','country'=>'Others','region'=>'Others','city'=>'Others');}else{$hasilip2locRet=array('code'=>$hasilip2loc['ip2location_countrycode'],'country'=>$hasilip2loc['ip2location_country'],'region'=>$hasilip2loc['ip2location_region'],'city'=>$hasilip2loc['ip2location_city']);}return $hasilip2locRet;}function ueBotDetect(){if(isset($_SERVER['HTTP_USER_AGENT'])&&preg_match('/bot|crawl|slurp|spider/i',$_SERVER['HTTP_USER_AGENT'])){return TRUE;}else{return FALSE;}}function writeAnalytics($writeAnalyticsName,$writeAnalyticsPublicKey='',$writeAnalyticsDesc='',$writeAnalyticsSubscriberId='',$writeAnalyticsProductId='',$writeAnalyticsNewsId='',$writeAnalyticsPurchaseId='',$writeAnalyticsShippingId='',$writeAnalyticsFavoriteId=''){if($GLOBALS['ue_globvar_analytics_enabled']==true&&$writeAnalyticsName!=''&&$writeAnalyticsName!=false){if(!ueBotDetect()){$writeAnalyticsName=ue_real_escape_string($writeAnalyticsName);$writeAnalyticsPublicKey=ue_real_escape_string($writeAnalyticsPublicKey);$writeAnalyticsDesc=ue_real_escape_string($writeAnalyticsDesc);$writeAnalyticsSubscriberId=ue_real_escape_string($writeAnalyticsSubscriberId);$writeAnalyticsProductId=ue_real_escape_string($writeAnalyticsProductId);$writeAnalyticsNewsId=ue_real_escape_string($writeAnalyticsNewsId);$writeAnalyticsPurchaseId=ue_real_escape_string($writeAnalyticsPurchaseId);$writeAnalyticsShippingId=ue_real_escape_string($writeAnalyticsShippingId);$writeAnalyticsFavoriteId=ue_real_escape_string($writeAnalyticsFavoriteId);$currentTime=time();$analyticsWriteFlag=true;if($_COOKIE['ueAnalytics']){$campaign_publickey=ue_real_escape_string($_COOKIE['ueAnalytics']);}else if($writeAnalyticsName==$GLOBALS['ue_globvar_analytics_goals'][0]&&$writeAnalyticsPublicKey!=''){$campaign_publickey=$writeAnalyticsPublicKey;}$campaignQuery=ue_query("SELECT * FROM campaign WHERE campaign_publickey = '".$campaign_publickey."' LIMIT 1");@ $campaignRes=ue_fetch_array($campaignQuery);if($campaignRes['campaign_enabled']=='e'||$GLOBALS['ue_globvar_analytics_full_tracking']==true){if($_SESSION['currentUserId']!=''){$userAnalyticsQue=ue_query("SELECT user_id,user_gender,user_dob FROM user WHERE user_id = '".$_SESSION['currentUserId']."' LIMIT 1");$userAnalyticsRes=ue_fetch_array($userAnalyticsQue);$writeAnalyticsUserId=$userAnalyticsRes['user_id'];$writeAnalyticsGender=$userAnalyticsRes['user_gender'];$currentUserAge=ueSinceTimestamp($userAnalyticsRes['user_dob']);$writeAnalyticsDob=$currentUserAge['year'];}else if($_SESSION['guestAccount']){$writeAnalyticsUserId=0;$writeAnalyticsGender='-';$writeAnalyticsDob=0;}else{$writeAnalyticsUserId=0;$writeAnalyticsGender='-';$writeAnalyticsDob=0;}$userLocationData=ueGetClientIp();$writeAnalyticsCountryCode='';$writeAnalyticsCountry='';$writeAnalyticsRegion='';$writeAnalyticsCity='';$writeAnalyticsLandingpage=currentPage('clean');$writeAnalyticsLandingurl=currentPage('full');if($writeAnalyticsLandingpage=='product'||$writeAnalyticsLandingpage=='news'||$writeAnalyticsLandingpage=='blog'){$writeAnalyticsSearchterm=ue_real_escape_string($_GET['search']);}$writeAnalyticsSource=ue_real_escape_string($_COOKIE['ueSource']);$writeAnalyticsMedium=ue_real_escape_string($_COOKIE['ueMedium']);$writeAnalyticsTerm=ue_real_escape_string($_COOKIE['ueTerm']);$writeAnalyticsContent=ue_real_escape_string($_COOKIE['ueContent']);$clientBrowserData=ueDetectBrowser();$writeAnalyticsBrowserName=$clientBrowserData['name'];$writeAnalyticsBrowserOs=$clientBrowserData['os'];$writeAnalyticsBrowserType=$clientBrowserData['type'];}if($writeAnalyticsName==$GLOBALS['ue_globvar_analytics_goals'][0]){if(isset($_SESSION['ueAnalyticsVisitFlag'])){$analyticsWriteFlag=false;}else{$_SESSION['ueAnalyticsVisitFlag']='y';$analyticsInitVisifFlag='e';}}if($analyticsInitVisifFlag!='e'){$analyticsInitVisifFlag='d';}if($GLOBALS['ue_globvar_analytics_allpage_tracking']){if($writeAnalyticsLandingpage!='productdetail'&&$writeAnalyticsLandingpage!='newsdetail.php'){$analyticsWriteFlag=true;}}if($writeAnalyticsName==$GLOBALS['ue_globvar_analytics_goals'][6]){if(!is_array($_SESSION['ueAnalyticsViewProductFlag'])){$_SESSION['ueAnalyticsViewProductFlag']=array();$_SESSION['ueAnalyticsViewProductFlag'][]=$writeAnalyticsProductId;}else if(in_array($writeAnalyticsProductId,$_SESSION['ueAnalyticsViewProductFlag'])){$analyticsWriteFlag=false;}else{if(count($_SESSION['ueAnalyticsViewProductFlag'])<=$GLOBALS['ue_globvar_analytics_maximum_products']){$_SESSION['ueAnalyticsViewProductFlag'][]=$writeAnalyticsProductId;}else{$analyticsWriteFlag=false;}}}if($campaignRes['campaign_enabled']=='e'){if($analyticsWriteFlag){ue_query("INSERT INTO analytics VALUES(
						'',
						'$currentTime',
						'$writeAnalyticsName',
						'$writeAnalyticsDesc',
						'$writeAnalyticsGender',
						'$writeAnalyticsDob',
						'$userLocationData',
						'$writeAnalyticsCountryCode',
						'$writeAnalyticsCountry',
						'$writeAnalyticsRegion',
						'$writeAnalyticsCity',
						'$analyticsInitVisifFlag',
						'$writeAnalyticsLandingpage',
						'$writeAnalyticsLandingurl',
						'$writeAnalyticsSearchterm',
						'$writeAnalyticsSource',
						'$writeAnalyticsMedium',
						'$writeAnalyticsTerm',
						'$writeAnalyticsContent',
						'$writeAnalyticsBrowserName',
						'$writeAnalyticsBrowserOs',
						'$writeAnalyticsBrowserType',
						'".$campaignRes['campaign_id']."',
						'$writeAnalyticsUserId',
						'$writeAnalyticsSubscriberId',
						'$writeAnalyticsProductId',
						'$writeAnalyticsNewsId',
						'$writeAnalyticsPurchaseId',
						'$writeAnalyticsShippingId',
						'$writeAnalyticsFavoriteId'
					)");}}else if($GLOBALS['ue_globvar_analytics_full_tracking']==true){if($analyticsWriteFlag){ue_query("INSERT INTO analytics VALUES(
						'',
						'$currentTime',
						'$writeAnalyticsName',
						'$writeAnalyticsDesc',
						'$writeAnalyticsGender',
						'$writeAnalyticsDob',
						'$userLocationData',
						'$writeAnalyticsCountryCode',
						'$writeAnalyticsCountry',
						'$writeAnalyticsRegion',
						'$writeAnalyticsCity',
						'$analyticsInitVisifFlag',
						'$writeAnalyticsLandingpage',
						'$writeAnalyticsLandingurl',
						'$writeAnalyticsSearchterm',
						'$writeAnalyticsSource',
						'$writeAnalyticsMedium',
						'$writeAnalyticsTerm',
						'$writeAnalyticsContent',
						'$writeAnalyticsBrowserName',
						'$writeAnalyticsBrowserOs',
						'$writeAnalyticsBrowserType',
						'0',
						'$writeAnalyticsUserId',
						'$writeAnalyticsSubscriberId',
						'$writeAnalyticsProductId',
						'$writeAnalyticsNewsId',
						'$writeAnalyticsPurchaseId',
						'$writeAnalyticsShippingId',
						'$writeAnalyticsFavoriteId'
					)");}}}}}function ueAnalytics(){if($GLOBALS['ue_globvar_analytics_enabled']){if(!ueBotDetect()){$campaignFound=false;$utm_source=ue_real_escape_string($_GET['utm_source']);$utm_medium=ue_real_escape_string($_GET['utm_medium']);$utm_term=ue_real_escape_string($_GET['utm_term']);$utm_content=ue_real_escape_string($_GET['utm_content']);$utm_campaign=ue_real_escape_string($_GET['utm_campaign']);$ueAnalyticsClientKey=ue_real_escape_string($_COOKIE['ueAnalytics']);if(($utm_campaign!=''||$GLOBALS['ue_globvar_analytics_full_tracking']==true)&&$ueAnalyticsClientKey==''){if($utm_campaign){$campaignQuery=ue_query("SELECT campaign_enabled,campaign_publickey,campaign_maxtrackdate FROM campaign WHERE campaign_name = '".$utm_campaign."' LIMIT 1");@ $campaignRes=ue_fetch_array($campaignQuery);if($campaignRes['campaign_enabled']=='e'){$campaignFound=true;}}if($campaignFound==true){if(!$campaignRes['campaign_maxtrackdate']){$campaignRes['campaign_maxtrackdate']=30;}$campaignRes['campaign_maxtrackdate']=$campaignRes['campaign_maxtrackdate'] * 86400;ue_setcookie('ueAnalytics',$campaignRes['campaign_publickey'],time()+$campaignRes['campaign_maxtrackdate']);ue_setcookie('ueSource',$utm_source,time()+$campaignRes['campaign_maxtrackdate']);ue_setcookie('ueMedium',$utm_medium,time()+$campaignRes['campaign_maxtrackdate']);ue_setcookie('ueTerm',$utm_term,time()+$campaignRes['campaign_maxtrackdate']);ue_setcookie('ueContent',$utm_content,time()+$campaignRes['campaign_maxtrackdate']);}writeAnalytics($GLOBALS['ue_globvar_analytics_goals'][0],$campaignRes['campaign_publickey']);}}}}?>