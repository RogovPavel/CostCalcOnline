<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $theme = '';
        /**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        /* Заголовок страницы*/
        public $pageName;
        
        protected function beforeAction($action) {
            if (!Yii::app()->user->isGuest) {
                $this->layout = '//layouts/column2';
                
                if (isset($_SESSION['theme']))
                    $this->theme = $_SESSION['theme'];
                else {
                    $settings = new Settings();
                    $settings->get_by_conditions(array(array(
                        'sql' => 's.user_id = :p_user_id',
                        'params' => array(':p_user_id' => Yii::app()->user->user_id)
                    )));
                    
                    if ($settings->theme != null && $settings->theme != '') {
                        $_SESSION['theme'] = $settings->theme;
                        $this->theme = $settings->theme;
                    }
                    else {
                        $_SESSION['theme'] = 'ui-sunny';
                        $this->theme = 'ui-sunny';
                    }
                }
                
            }
            
            
            return parent::beforeAction($action);
        }
}