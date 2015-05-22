<?php

class FrontEndController extends BaseController
{
    public $page;
    public $pageIndex = 1;
    public $meta_title;
    public $pageDescription;
    public $pageKeywords;
    public $pageTemplate;

    public $buffer = array();

    /**
     * [behaviors description]
     * @return [type] [description]
     */
    public function behaviors()
    {
        return array(
            'InlineCommonWidgetsBehavior' => array(
                'class' => 'MInlineWidgetsBehavior',
                'location' => $this->_generateWidgetsLocations(),
                // 'startBlock' => '{{w:',
                // 'endBlock' => '}}',
                'widgets' => $this->_generateWidgetsList(),
            ),
        );
    }

    /**
     * [_generateWidgetsLocations description]
     * @return [type] [description]
     */
    private function _generateWidgetsLocations()
    {
        $modules = Yii::app()->getModulesNames();

        foreach ($modules as $module) {
            $locations[] = 'application.modules.' . $module . '.components.widgets';
        }

        return $locations;
    }

    /**
     * [_generateWidgetsList description]
     * @return [type] [description]
     */
    private function _generateWidgetsList()
    {
        $locations = $this->_generateWidgetsLocations();

        $list = array();

        foreach ($locations as $directory) {
            $path = Yii::getPathOfAlias($directory);

            if (is_dir($path)) {
                $files = CFileHelper::findFiles($path, array('fileTypes' => array('php'), 'level' => 0));

                if (count($files)) {
                    foreach ($files as $file) {
                        $list[] = basename($file, '.php');
                    }
                }
            }
        }

        return $list;
    }

    protected function setPageMeta($page)
    {
        $meta_title = '';

        $homepage = Page::model()->findByAlias('');
        if (!isset($page->id)) {
            $page = $homepage;
        }

        if (empty($page->meta_title)) {
            $meta_title = $homepage->meta_title;
        } else {
            $meta_title = $page->meta_title;
        }

        $meta_description = $homepage->meta_description;
        $meta_keywords = $homepage->meta_keywords;

        if (empty($meta_title)) {
            $meta_title = Yii::app()->name;
        }

        $this->meta_title = $meta_title;

        $meta_description = (!empty($meta_description)) ? $meta_description : $homepage->meta_description;
        $meta_keywords = (!empty($meta_keywords)) ? $meta_keywords : $homepage->meta_keywords;

        $this->setPageTitle($meta_title);

        $this->pageDescription = $meta_description;
        $this->pageKeywords = $meta_keywords;
        $this->pageIndex = $homepage->meta_index;
    }


    protected function setPageTemplate($page)
    {
        if (!empty($page->template)) {
            $this->layout = '//templates/' . $page->template;
        }
    }

}