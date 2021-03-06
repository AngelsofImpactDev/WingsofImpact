<?php
	include('ue-includes/ue-ses_check.php');
	
	//Get All POST Vars
	$auPostedElements = array();
	foreach($_POST as $postedElementsKey => $postedElementsVal) {
		$auPostedElements["$postedElementsKey"] = ueReceiveInput($postedElementsKey,$postedElementsVal);
	}
	
	$quecek				= true;
	$id					= $auPostedElements['imageAreaCorrespondingId'];
	$imagelisttable		= $auPostedElements['imagelisttable'];
	$parentid			= $auPostedElements['parentid'];
	$table				= $auPostedElements['imageAreaCorrespondingTable'];
	$column				= $auPostedElements['imageAreaCorrespondingColumn'];
	$folder				= $auPostedElements['imageAreaCorrespondingFolder'];
	$src				= $auPostedElements['imageAreaCorrespondingSrc'];
	$page				= $auPostedElements['frompage'];
	$type				= $auPostedElements['action'];
	$fullfilesrc		= $folder.$src;
	
	if($imagelisttable != '' && $parentid > 0) {
		$pageparam			= '?id='.$parentid.'&imagelisttable='.$imagelisttable.'&detailmode=edit';
	}
	else if($id == '' && $parentid > 0) {
		$pageparam			= '?id='.$parentid.'&detailmode=edit';
	}
	else {
		$pageparam			= '?id='.$id.'&detailmode=edit';
	}
	
	if(file_exists($fullfilesrc) == false) {
		header("Location: $page".$pageparam.'&err=Image Not Found');
		exit();
	}
	else {
		switch($auPostedElements['imageEditMode']) {
			case 'Apply Crop':
				if((int)$auPostedElements['imageAreaEditW'] > 0 && (int)$auPostedElements['imageAreaEditH'] > 0) {
					imageCropper($fullfilesrc,(int)$auPostedElements['imageAreaEditX'],(int)$auPostedElements['imageAreaEditY'],(int)$auPostedElements['imageAreaEditW'],(int)$auPostedElements['imageAreaEditH']);
					$quecek = true;
				}
				else {
					header("Location: $page".$pageparam.'&err=Crop is too small');
					exit();
				}
			break;
			case 'Apply Filter':
				if($auPostedElements['filterMode'] == 'greyscale') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'greyscaleEnhanced') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'greyscaleDramatic') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'blackAndWhite') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'sepia') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'negative') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'vintage') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else if($auPostedElements['filterMode'] == 'sharpen') {
					imageFilterer($fullfilesrc,$auPostedElements['filterMode']);
					$quecek = true;
				}
				else {
					header("Location: $page".$pageparam.'&err=Filter not found');
					exit();
				}
			break;
			case 'Apply Watermark':
				if(file_exists('upload/watermark/'.ueGetSiteData('watermark'))) {
					imageWatermarker($fullfilesrc,'upload/watermark/'.ueGetSiteData('watermark'));
				}
				else {
					header("Location: $page".$pageparam.'&err=Watermark not found');
					exit();
				}
			break;
			case 'Apply Rotation':
				if($auPostedElements['rotateMode'] != 'left' || $auPostedElements['rotateMode'] != 'upside' || $auPostedElements['rotateMode'] != 'right') {
					imageRotater($fullfilesrc,$auPostedElements['rotateMode']);
					$quecek = true;
				}
				else {
					header("Location: $page".$pageparam.'&err=Failed to rotate');
					exit();
				}
			break;
			case 'Apply Compression':
				if($auPostedElements['compressMode'] >= 0) {
					$uploadedExt = pathinfo($fullfilesrc);
					$returnCompress = imageConverter($fullfilesrc,'jpg',$auPostedElements['compressMode']);
					
					if($id > 0 && $table != '' && $column != '' && $uploadedExt['extension'] != 'jpg') {
						@ ue_query("UPDATE ".$table." SET ".$column." = '".$returnCompress."' WHERE ".$table."_id = '".$id."' LIMIT 1");
					}
					else if($parentid > 0 && $table != '' && $uploadedExt['extension'] != 'jpg') { //RTFI Image Editor Action
						$getCurrentDescData = ue_query("SELECT * FROM ".$table." WHERE ".$table."_id = '".$parentid."' LIMIT 1");
						@ $getCurrentDescRes = ue_fetch_array($getCurrentDescData);
						if($getCurrentDescRes[$table.'_desc']) {
							$hasilReplaceDesc = str_replace($src,$returnCompress,$getCurrentDescRes[$table.'_desc']);
							@ ue_query("UPDATE ".$table." SET ".$table."_desc = '".$hasilReplaceDesc."' WHERE ".$table."_id = '".$parentid."' LIMIT 1");
						}
					}
				}
				else {
					header("Location: $page".$pageparam.'&err=Failed to compress');
					exit();
				}
			break;
		}
	}
	
	if($quecek) {
		header("Location: $page".$pageparam.'&sta=Edit Complete, You might need to Refresh your browser.');
	}
	else {
		header("Location: $page".$pageparam.'&err=Edit Failed');
	}
?>