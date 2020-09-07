<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рыбный сайт");
$GLOBALS["arrFilterMainTheme"] = array("PROPERTY_MAIN_VALUE" => 1);
$GLOBALS["arrFilterMain"] = array("PROPERTY_MAIN_VALUE" => 1);
?>

	<!-- About Section -->
  <section class="page-section bg-primary" id="home">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">О прикорме</h2>
          <hr class="divider light my-4">
          <p class="text-white-50 mb-4">Споры о том, на что ловить и чем лучше прикармливать, наверное, никогда не закончатся. Одни предпочи-тают новомодные прикор-мки, изготовленные фирма-ми, специализи-рующимися на их производ-стве; другие ни за что не променяют кастрюлю с душистым варевом, над которой они колдовали не один час, словно баба-яга над зельем. Но речь не об этом. Я не буду давать советы и рецепты, а выскажусь по поводу некоторых заблуждений. В большинстве статей пишут, что рыбу можно перекормить большим количеством прикормки. Но никто не пишет конкретных цифр - сколько "много", а сколько "мало" или "достаточно". Потому что никто не знает и никогда не узнает, сколько же это "много". Для одного и килограмм - уже много, а для другого и ведра кажется мало. Но причина не в этом. Давайте на проблему посмотрим с другой стороны.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="page-section">
    <div class="container">
      <h2 class="text-center mt-0">Почему мы?</h2>
      <hr class="divider my-4">
    </div>
  </section>

  <!-- Portfolio Section -->
  <section id="portfolio">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/1.jpg">
            <img class="img-fluid" src="img/1.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-name">Прекраснвые пейзажи</div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/2.jpg">
            <img class="img-fluid" src="img/2.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-name">Крупная рыба</div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/3.jpg">
            <img class="img-fluid" src="img/3.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-name">Тихие места</div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/4.jpg">
            <img class="img-fluid" src="img/4.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-name">Дзен</div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/5.jpg">
            <img class="img-fluid" src="img/5.jpg" alt="">
            <div class="portfolio-box-caption">
              <div class="project-name">Оcнащение плавсредствами</div>
            </div>
          </a>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="portfolio-box" href="img/6.jpg">
            <img class="img-fluid" src="img/6.jpg" alt="">
            <div class="portfolio-box-caption p-3">
              <div class="project-name">Хорошее настроение</div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="page-section bg-dark text-white" id="news">
    <div class="container text-center">
	
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"news_list", 
	array(
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESCRIPTION",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "#SITE_DIR#/news.php?ID=#ELEMENT_ID#",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "news_list",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);?>

    </div>


  </section>

  


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>