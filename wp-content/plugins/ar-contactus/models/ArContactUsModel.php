<?php
ArContactUsLoader::loadModel('ArContactUsModelAbstract');
ArContactUsLoader::loadModel('ArContactUsConfigModel');

class ArContactUsModel extends ArContactUsModelAbstract
{
    const TYPE_LINK = 0;
    const TYPE_INTEGRATION = 1;
    const TYPE_JS = 2;
    const TYPE_CALLBACK = 3;
    const TYPE_CONTENT = 4;
    
    const TARGET_NEW_WINDOW = 0;
    const TARGET_SAME_WINDOW = 1;
    
    public $id;
    public $icon;
    public $fa_icon;
    public $color;
    public $link;
    public $target;
    public $type;
    public $display;
    public $integration;
    public $js;
    public $title;
    public $subtitle;
    public $content;
    public $params;
    public $status;
    public $registered_only;
    public $position;
    public $shortcode;
    
    public function rules()
    {
        return array(
            array(
                array(
                    'icon',
                    'color',
                    'link',
                    'target',
                    'type',
                    'display',
                    'integration',
                    'js',
                    'title',
                    'subtitle',
                    'content',
                    'params',
                    'status',
                    'registered_only',
                    'position'
                ), 'safe'
            ),
            array(
                array(
                    'icon',
                    'color',
                    'title'
                ), 'validateRequired'
            )
        );
    }
    
    public function scheme()
    {
        return array(
            'id' => self::FIELD_INT,
            'icon' => self::FIELD_STRING,
            'color' => self::FIELD_STRING,
            'link' => self::FIELD_STRING,
            'target' => self::FIELD_INT,
            'js' => self::FIELD_STRING,
            'integration' => self::FIELD_STRING,
            'title' => self::FIELD_STRING,
            'subtitle' => self::FIELD_STRING,
            'content' => self::FIELD_STRING,
            'params' => self::FIELD_STRING,
            'status' => self::FIELD_INT,
            'registered_only' => self::FIELD_INT,
            'type' => self::FIELD_INT,
            'display' => self::FIELD_INT,
            'position' => self::FIELD_INT
        );
    }
    
    public static function tableName()
    {
        return self::dbPrefix().'arcontactus';
    }
    
    public static function createTable()
    {
        return self::getDb()->query("CREATE TABLE IF NOT EXISTS `" . self::tableName() . "` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `icon` VARCHAR(50) NULL DEFAULT NULL,
            `color` VARCHAR(10) NULL DEFAULT NULL,
            `type` TINYINT(3) UNSIGNED NULL DEFAULT '0',
            `display` TINYINT(3) UNSIGNED NULL DEFAULT '1',
            `link` VARCHAR(255) NULL DEFAULT NULL,
            `target` TINYINT(3) UNSIGNED NULL DEFAULT '0',
            `integration` VARCHAR(50) NULL DEFAULT NULL,
            `js` TEXT NULL,
            `title` VARCHAR(255) NULL DEFAULT NULL,
            `subtitle` VARCHAR(255) NULL DEFAULT NULL,
            `content` TEXT NULL,
            `params` TEXT NULL,
            `status` TINYINT(3) UNSIGNED NULL DEFAULT '1',
            `registered_only` TINYINT(3) UNSIGNED NULL DEFAULT '0',
            `position` INT(10) UNSIGNED NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            INDEX `position` (`position`)
        )
        COLLATE='utf8_general_ci';");
    }
    
    public static function truncate()
    {
        return self::getDb()->query("TRUNCATE `" . self::tableName() . "`");
    }
    
    public static function dropTable()
    {
        return self::getDb()->query("DROP TABLE IF EXISTS `" . self::tableName() . "`");
    }
    
    public static function getLastPostion()
    {
        $model = self::find()->orderBy('`position` DESC')->one();
        return $model? $model->position : 0;
    }
    
    public static function getDefaultMenuItems()
    {
        return array(
            array(
                'icon' => 'facebook-messenger',
                'color' => '567AFF',
                'link' => 'https://m.me/page_name',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Messenger',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'whatsapp',
                'color' => '1EBEA5',
                'link' => 'https://wa.me/phone_number',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Whatsapp',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'viber',
                'color' => '812379',
                'link' => 'viber://chat?number=%2Bphone_number',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Viber',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'telegram-plane',
                'color' => '20AFDE',
                'link' => 'https://t.me/your_nickname',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Telegram',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'skype',
                'color' => '1C9CC5',
                'link' => 'skype:your_nickname?chat',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Skype',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'envelope',
                'color' => 'FF643A',
                'link' => 'mailto:email@mysite.com',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Email us',
                'display' => 1,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'phone',
                'color' => '3EB891',
                'link' => 'tel:your_phone_number',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Direct call',
                'display' => 3,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'comment-dots-light',
                'color' => '5092E2',
                'link' => 'sms:your_phone_number',
                'target' => self::TARGET_NEW_WINDOW,
                'title' => 'Direct SMS',
                'display' => 3,
                'type' => 0,
                'status' => 0
            ),
            array(
                'icon' => 'phone',
                'color' => '4EB625',
                'title' => 'Callback request',
                'display' => 1,
                'type' => 3,
                'status' => 1
            ),
        );
    }
    
    public function getIcon()
    {
        return ArContactUsConfigModel::getIcon($this->icon);
    }
    
    public function getShortcode()
    {
        return '[contactus_menu_item id="' . $this->id . '"]';
    }
    
    public static function createDefaultMenuItems()
    {
        foreach (self::getDefaultMenuItems() as $k => $item){
            $model = new self();
            $model->icon = $item['icon'];
            $model->color = $item['color'];
            $model->link = $item['link'];
            $model->title = $item['title'];
            $model->status = $item['status'];
            $model->type = $item['type'];
            $model->display = $item['display'];
            $model->target = $item['target'];
            $model->position = $k + 1;
            $model->registered_only = 0;
            $model->save();
        }
    }
    
    public function isFontAwesome()
    {
        return ArContactUsConfigModel::isFontAwesomeStatic($this->icon);
    }
}
