<?php

class DefaultController extends BasePageController
{
    public $layout = 'pages.views.templates.default';

    public function init()
    {
        parent::init();
    }

    public function actionView($alias = '')
    {
        $page_model = Page::model();
        $page = $page_model->active()->findByAlias($alias);

        $this->setPageMeta($this->page);
        // $this->setPageTemplate($this->page);

        if (!isset($page->id)) {
            throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
        }

        // $this->getPageLastUpdate($alias);

        // $this->breadcrumbs[] = array(
        //     'route' => false,
        //     'title' => $this->page->title,
        // );

        $this->render('view', array('model' => $page));
    }
}