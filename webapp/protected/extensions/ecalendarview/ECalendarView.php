<?php
/**
 * ECalendarView.php
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2013 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */

Yii::import('ecalendarview.ECalendarViewDataProvider');

/**
 * The calendar view renders days using customizable view.
 */
class ECalendarView extends CWidget {

  /**
   * @var string The identifier of calendar. It must be unique for each calendar rendered on the same view.
   */
  private $_id;

  /**
   * @var ECalendarViewDataProvider The data provider.
   */
  private $_dataProvider;

  /**
   * @var string The custom view that is used to render each day cell.
   */
  private $_itemView;

  /**
   * @var string The path to custom css file to style calendar.
   */
  private $_cssFile;

  /**
   * @var boolean True if page navigation should be performed using ajax calls if possible, otherwise false.
   */
  private $_ajaxUpdate;

  /**
   * Constructs the calendar and sets it's attributes to default values.
   * @param CBaseController $owner The owner of calendar.
   */
  public function __construct(CBaseController $owner) {
    parent::__construct($owner);
    $this->_id = 'ECalendarView';
    $this->_dataProvider = new ECalendarViewDataProvider();
    $this->_itemView = null;
    $this->_cssFile = null;
    $this->_ajaxUpdate = true;
    $this->getDataProvider()->getPagination()->setPageIndexVar($this->getId() . '_page');
  }

  /**
   * @see ECalendarView::$_id
   */
  public function setId($id) {
    $this->_id = $id;
  }

  /**
   * Sets the data provider's attributes.
   * @param array $config The attributes as key=>value map.
   */
  public function setDataProvider(array $config) {
    foreach($config as $key => $value) {
      $this->getDataProvider()->$key = $value;
    }
  }

  /**
   * @see ECalendarView::$_itemView
   */
  public function setItemView($itemView) {
    $this->_itemView = $itemView;
  }

  /**
   * @see ECalendarView::$_cssFile
   */
  public function setCssFile($cssFile) {
    $this->_cssFile = $cssFile;
  }

  /**
   * @see ECalendarView::$_ajaxUpdate
   */
  public function setAjaxUpdate($ajaxUpdate) {
    $this->_ajaxUpdate = (boolean) $ajaxUpdate;
  }

  /**
   * @see ECalendarView::$_id
   */
  public function getId() {
    return $this->_id;
  }

  /**
   * @see ECalendarView::$_dataProvider
   */
  public function getDataProvider() {
    return $this->_dataProvider;
  }

  /**
   * @see ECalendarView::$_itemView
   */
  public function getItemView() {
    return $this->_itemView;
  }

  /**
   * @see ECalendarView::$_cssFile
   */
  public function getCssFile() {
    return $this->_cssFile;
  }

  /**
   * @see ECalendarView::$_ajaxUpdate
   */
  public function getAjaxUpdatE() {
    return $this->_ajaxUpdate;
  }

  /**
   * Initializes the calendar.
   */
  public function init() {
    // register css
    $cssFilePath = $this->resolveCssFilePath($this->getCssFile(), 'styles.css');
    $publishedCssFilePath = Yii::app()->getAssetManager()->publish($cssFilePath);
    Yii::app()->clientScript->registerCssFile($publishedCssFilePath);

    // register js
    if($this->getAjaxUpdate()) {
      $jsFilePath = $this->resolveJsFilePath('ecalendarview.js');
      $publishedJsFilePath = Yii::app()->getAssetManager()->publish($jsFilePath);
      Yii::app()->clientScript->registerScriptFile($publishedJsFilePath, CClientScript::POS_END);
      Yii::app()->clientScript->registerScript('e-calendar-view', 'jQuery(\'.e-calendar-view\').ecalendarview();');
    }

    parent::init();
  }

  /**
   * Runs the calendar.
   */
  public function run() {
    $this->render('main', array(
      'id' => $this->getId(),
      'dataProvider' => $this->getDataProvider(),
      'itemViewFile' => $this->resolveViewFile($this->getItemView(), '_view'),
      'previousUrl' => $this->getUrl($this->getDataProvider()->getPagination()->getPageIndex() - 1),
      'nextUrl' => $this->getUrl($this->getDataProvider()->getPagination()->getPageIndex() + 1),
    ));
  }

  /**
   * Generates url for page navigation.
   * @param int $pageIndex The index of page.
   * @return string The url.
   */
  private function getUrl($pageIndex) {
    $params = $_GET;
    $params[$this->getDataProvider()->getPagination()->getPageIndexVar()] = $pageIndex;
    return Yii::app()->getController()->createUrl('', $params);
  }

  /**
   * Resolves path to css file that should be used.
   * @param string $customCssFile The custom css file path.
   * @param string $defaultCssFile The default css file path.
   * @return string The css file path.
   */
  private function resolveCssFilePath($customCssFile, $defaultCssFile) {
    return $customCssFile ? $customCssFile : dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/' . $defaultCssFile;
  }

  /**
   * Resolves path to js file.
   * @param string $jsFile The js file path.
   */
  private function resolveJsFilePath($jsFile) {
    return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets/' . $jsFile;
  }

  /**
   * Resolves the view file that should be used.
   * @param string $customView The custom view.
   * @param string $defaultView The default view.
   * @return string The view.
   */
  private function resolveViewFile($customView, $defaultView) {
    return $customView ? $this->getOwner()->getViewFile($customView) : $this->getViewFile($defaultView);
  }

}
