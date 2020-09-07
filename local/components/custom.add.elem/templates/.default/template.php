<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	}
	
	?>
	<table>
	<form action="<?=$APPLICATION->GetCurPage(true)?>" method="get" name="addElem">
		<tr>
			<td>
			<label for="iblockID"> IBlock ID </label>
			</td>
			<td>
			<input type="text" name="iblockID" id="iblockID"/>
			</td>
		</tr>
		<tr>
			<td>
			<label for="elemName"> Element Name </label>
			</td>
			<td>
			<input type="text" name="elemName" id="elemName"/>
			</td>
		</tr>
		<tr>
			<td>
			<label for="elemCode"> Element Code </label>
			</td>
			<td>
			<input type="text" name="elemCode" id="elemCode"/>
			</td>
		</tr>
		<tr>
			<td>
			<label for="anounseText"> AnounseText </label>
			</td>
			<td>
			<textarea name="anounseText" id="anounseText" rows="10" cols="45"></textarea>
			</td>
		</tr>
		<tr>
			<td>
			<label for="detailedText"> detailed Text </label>
			</td>
			<td>
			<textarea name="detailedText" id="detailedText" rows="10" cols="45"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<input type="submit" value="add element"/>
			</td>
		</tr>
		
	</form>
	</table>
	
<?
	$iblockID = $_GET["iblockID"];
	$elemName = $_GET["elemName"];
	$elemCode = $_GET["elemCode"];
	$anounseText = $_GET["anounseText"];
	$detailedText = $_GET["detailedText"];
	
	$elem = new CIBlockElement;
	
	if (isset($_GET["iblockID"]) && isset($_GET["elemName"]) && isset($_GET["elemCode"]) && isset($_GET["anounseText"]) && isset($_GET["detailedText"]) &&
		$_GET["iblockID"] != "" && $_GET["elemName"] != "" && $_GET["elemCode"] != "" && $_GET["anounseText"] != "" && $_GET["detailedText"] != "")  {
			
		$arFieldsElem = Array(
		"MODIFIED_BY" => $USER->GetID(),
		"IBLOCK_SECTION_ID" => false,
		"IBLOCK_ID" => $iblockID,
		"NAME" => $elemName,
		"CODE" => $elemCode,
		"ACTIVE" => "Y",
		"PREVIEW_TEXT" => $anounseText,
		"DETAIL_TEXT" => $detailedText
	);
	
	if ($newElemId == $elem->Add($arFieldsElem)) {
		echo "new id = " . $newElemId;
	} else {
		echo $elem->LAST_ERROR;
	}
	
	
	} else 
		echo "false";

?>