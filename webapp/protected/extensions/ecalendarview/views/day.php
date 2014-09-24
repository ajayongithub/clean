<?php
/**
 * day.php
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2013 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */
?>

<thead>
  <tr class="month-year-row">
    <th class="previous">
      <?php echo CHtml::link('&larr;', $previousUrl, array('class' => 'navigation-link')); ?>
    </th>
    <th class="month-year">
      <?php echo Yii::t('ecalendarview', $dataProvider->getPagination()->getMiddleRelevantPageDate()->format('F')); ?>,
      <?php echo $dataProvider->getPagination()->getMiddleRelevantPageDate()->format('Y'); ?>
    </th>
    <th class="next">
      <?php echo CHtml::link('&rarr;', $nextUrl, array('class' => 'navigation-link')); ?>
    </th>
  </tr>
  <tr class="weekdays-row">
    <th class="<?php echo strtolower($dataProvider->getPagination()->getFirstPageDate()->format('D')); ?>" colspan="3">
      <?php echo Yii::t('ecalendarview', $dataProvider->getPagination()->getFirstPageDate()->format('D')); ?>
    </th>
  </tr>
</thead>

<tbody>
  <?php $data = $dataProvider->getData(); ?>
  <tr>
    <?php
      $classes = array();

      if($data[0]->isCurrentDate) {
        $classes[] = 'current';
      } else {
        $classes[] = 'not-current';
      }

      if($data[0]->isRelevantDate) {
        $classes[] = 'relevant';
      } else {
        $classes[] = 'not-relevant';
      }

      $classes[] = strtolower($data[0]->date->format('D'));

      $classesStr = implode(' ', $classes);
    ?>
    <td class="<?php echo $classesStr; ?>" colspan="3">
      <?php $this->getOwner()->renderFile($itemViewFile, array(
        'data' => $data[0],
      )); ?>
    </td>
  </tr>
</tbody>
