<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponent $this */
/** @var array $this->arParams */
/** @var array $this->arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
class Photo extends CBitrixComponent {
	
	private function  setFilter() {

		if($this->arParams["USE_FILTER"]=="Y") {
			if(strlen($this->arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $this->arParams["FILTER_NAME"]))
				$this->arParams["FILTER_NAME"] = "arrFilter";
		}
		else {
			$this->arParams["FILTER_NAME"] = "";
		}
			
	}

	private function useSefMode($arDefaultUrlTemplates404, $arDefaultVariableAliases404, $arComponentVariables) {

		GLOBAL $APPLICATION; 
		$arVariables = array();

		$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);
		$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $this->arParams["VARIABLE_ALIASES"]);
		$engine = new CComponentEngine($this);
		if (CModule::IncludeModule('iblock'))
		{
			$engine->addGreedyPart("#SECTION_CODE_PATH#");
			$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
		}
		$componentPage = $engine->ParseComponentPath(
			$this->arParams["SEF_FOLDER"],
			$arUrlTemplates,
			$arVariables
		);

		$b404 = false;
		if(!$componentPage)
		{
			$componentPage = "sections_top";
			$b404 = true;
		}

		if(
			$componentPage == "section"
			&& isset($arVariables["SECTION_ID"])
			&& intval($arVariables["SECTION_ID"])."" !== $arVariables["SECTION_ID"]
		)
			$b404 = true;

		if($b404 && CModule::IncludeModule('iblock'))
		{
			$folder404 = str_replace("\\", "/", $this->arParams["SEF_FOLDER"]);
			if ($folder404 != "/")
				$folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
			if (substr($folder404, -1) == "/")
				$folder404 .= "index.php";

			if ($folder404 != $APPLICATION->GetCurPage(true))
			{
				\Bitrix\Iblock\Component\Tools::process404(
					""
					,($this->arParams["SET_STATUS_404"] === "Y")
					,($this->arParams["SET_STATUS_404"] === "Y")
					,($this->arParams["SHOW_404"] === "Y")
					,$this->arParams["FILE_404"]
				);
			}
		}

		CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

		$this->arResult = array(
			"FOLDER" => $this->arParams["SEF_FOLDER"],
			"URL_TEMPLATES" => $arUrlTemplates,
			"VARIABLES" => $arVariables,
			"ALIASES" => $arVariableAliases,
		);

		return $componentPage;

	}

	private function useStandartMode($arDefaultVariableAliases, $arComponentVariables) {

		GLOBAL $APPLICATION;
		$arVariables = array();

		$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $this->arParams["VARIABLE_ALIASES"]);
		CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
		$componentPage = "";

		if(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
			$componentPage = "detail";
		elseif(isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
			$componentPage = "detail";
		elseif(isset($arVariables["SECTION_ID"]) && intval($arVariables["SECTION_ID"]) > 0)
			$componentPage = "section";
		elseif(isset($arVariables["SECTION_CODE"]) && strlen($arVariables["SECTION_CODE"]) > 0)
			$componentPage = "section";
		elseif(isset($arVariables["PARAM1"]) && strlen($arVariables["PARAM1"]) > 0)
			$componentPage = "exampage";
		else
			$componentPage = "sections_top";

		$this->arResult = array(
			"FOLDER" => "",
			"URL_TEMPLATES" => Array(
				"section" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["SECTION_ID"]."=#SECTION_ID#",
				"detail" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["SECTION_ID"]."=#SECTION_ID#"."&".$arVariableAliases["ELEMENT_ID"]."=#ELEMENT_ID#",
				"exampage" => htmlspecialcharsbx($APPLICATION->GetCurPage())."?".$arVariableAliases["PARAM1"]."=#PARAM1#"."&".$arVariableAliases["PARAM2"]."=#PARAM2#",
			),
			"VARIABLES" => $arVariables,
			"ALIASES" => $arVariableAliases
		);

		return $componentPage;

	}

    public function executeComponent() {
	
		$this->setFilter();

		$arDefaultUrlTemplates404 = array(
			"sections_top" => "",
			"section" => "#SECTION_ID#",
			"detail" => "#SECTION_ID#/#ELEMENT_ID#/",
			"exampage" => "exam/new/#PARAM1#/?PARAM2=#PARAM2#",
		);

		$arDefaultVariableAliases404 = array(
			
		);

		$arDefaultVariableAliases = array(
			
		);

		$arComponentVariables = array(
			"SECTION_ID",
			"SECTION_CODE",
			"ELEMENT_ID",
			"ELEMENT_CODE",
			"PARAM1",
			"PARAM2",
		);

		if($this->arParams["SEF_MODE"] == "Y")
		{
			$componentPage = $this->useSefMode($arDefaultUrlTemplates404, $arDefaultVariableAliases404, $arComponentVariables);
		}
		else
		{
			$componentPage = $this->useStandartMode($arDefaultVariableAliases, $arComponentVariables);
		}

		$this->IncludeComponentTemplate($componentPage);
    }

}

?>