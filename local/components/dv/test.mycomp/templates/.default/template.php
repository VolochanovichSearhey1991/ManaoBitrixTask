<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
		die();
	} 
?>
	<table>
		<?foreach($arResult as $value) { 
			
			foreach($value as $key => $subValue) {
		?>
		<tr>
			<?if ($key == 1 || $key == 3) {?>
			<td><img src="<?=CFile::GetPath($subValue)?>" alt="not found"/></td>
			<?} else {?>
			<td><?echo $subValue;?></td>
			<?}?>
		</tr>
		
		<?}?> 
		<tr><td>----------------------------------------------------------------------------------------------------------</td></tr>
		<?}?>
	</table>
?>	
	