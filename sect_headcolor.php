<style>
.red{
		background:red;
		width: 300px;
		height: 200px;
		
	}
</style>
<div class="red">
	<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"my_template", 
	array(
		"ROOT_MENU_TYPE" => "new_type",
		"MAX_LEVEL" => "3",
		"CHILD_MENU_TYPE" => "new_type",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "my_template",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
</div>