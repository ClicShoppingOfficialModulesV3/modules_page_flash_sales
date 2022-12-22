<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class CfgmModulesProductsFlashSales
  {
    public $code = 'modules_products_flash_sales';
    public $directory;
    public $language_directory;
    public $site = 'Shop';
    public $key = 'MODULE_MODULES_PRODUCTS_FLASH_SALES_INSTALLED';
    public $title;
    public $template_integration = true;

    public function __construct()
    {
      $CLICSHOPPING_Template = Registry::get('TemplateAdmin');

      $this->directory = $CLICSHOPPING_Template->getDirectoryPathShopDefaultTemplateHtml() . '/modules/modules_products_flash_sales/';
      $this->language_directory = $CLICSHOPPING_Template->getPathLanguageShopDirectory();

      $this->title = CLICSHOPPING::getDef('module_cfg_modules_products_flash_sales_modules_title');

      $this->installDbMenuAdministration();
    }

    private static function installDbMenuAdministration()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $Qcheck = $CLICSHOPPING_Db->get('administrator_menu', 'app_code', ['app_code' => 'app_products_flash_sales']);

      if ($Qcheck->fetch() === false) {

        $sql_data_array = ['sort_order' => 1,
          'link' => 'index.php?A&Configuration\Modules&Modules&set=modules_products_flash_sales',
          'image' => '',
          'b2b_menu' => 0,
          'access' => 0,
          'app_code' => 'app_products_flash_sales'
        ];

        $insert_sql_data = ['parent_id' => 117];

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        $CLICSHOPPING_Db->save('administrator_menu', $sql_data_array);

        $id = $CLICSHOPPING_Db->lastInsertId();

        $languages = $CLICSHOPPING_Language->getLanguages();

        for ($i = 0, $n = count($languages); $i < $n; $i++) {

          $language_id = $languages[$i]['id'];

          if ($i == 0) {
//            $sql_data_array = ['label' => $CLICSHOPPING_Archive->getDef('title_menu')];
            $sql_data_array = ['label' => 'Products Flash Sales'];
          } elseif ($i == 1) {
            $sql_data_array = ['label' => 'Produits Ventes flash'];
          } else {
            $sql_data_array = ['label' => 'Products Flash Sales'];
          }

          $insert_sql_data = ['id' => (int)$id,
            'language_id' => (int)$language_id
          ];

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          $CLICSHOPPING_Db->save('administrator_menu_description', $sql_data_array);

        }
      }
    }
  }
