<?php
/**
 * month.php
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
    <th class="month-year" colspan="5">
      <?php echo Yii::t('ecalendarview', $dataProvider->getPagination()->getMiddleRelevantPageDate()->format('F')); ?>,
      <?php echo $dataProvider->getPagination()->getMiddleRelevantPageDate()->format('Y'); ?>
    </th>
    <th class="next">
      <?php echo CHtml::link('&rarr;', $nextUrl, array('class' => 'navigation-link')); ?>
    </th>
  </tr>
  <tr class="weekdays-row">
    <?php if(!$dataProvider->getPagination()->getIsMondayFirst()): ?>
      <th class="sun"><?php echo Yii::t('ecalendarview', 'Sun'); ?></th>
    <?php endif ?>
    <th class="mon"><?php echo Yii::t('ecalendarview', 'Mon'); ?></th>
    <th class="tue"><?php echo Yii::t('ecalendarview', 'Tue'); ?></th>
    <th class="wed"><?php echo Yii::t('ecalendarview', 'Wed'); ?></th>
    <th class="thu"><?php echo Yii::t('ecalendarview', 'Thu'); ?></th>
    <th class="fri"><?php echo Yii::t('ecalendarview', 'Fri'); ?></th>
    <th class="sat"><?php echo Yii::t('ecalendarview', 'Sat'); ?></th>
    <?php if($dataProvider->getPagination()->getIsMondayFirst()): ?>
      <th class="sun"><?php echo Yii::t('ecalendarview', 'Sun'); ?></th>
    <?php endif ?>
  </tr>
</thead>

<tbody>
  <?php $data = $dataProvider->getData(); ?>
  <?php $i = 0; ?>
  <?php while($i < count($data)): ?>
    <tr>
      <?php for($j = 0; $j < 7; ++ $i, ++ $j): ?>
        <?php
          $classes = array();

          if($data[$i]->isCurrentDate) {
            $classes[] = 'current';
          } else {
            $classes[] = 'not-current';
          }

          if($data[$i]->isRelevantDate) {
            $classes[] = 'relevant';
          } else {
            $classes[] = 'not-relevant';
          }

          $classes[] = strtolower($data[$i]->date->format('D'));

          $classesStr = implode(' ', $classes);
        ?>
        <td class="<?php echo $classesStr; ?>">
          <?php $this->getOwner()->renderFile($itemViewFile, array(
            'data' => $data[$i],
          )); ?>
        </td>
      <?php endfor ?>
    </tr>
  <?php endwhile ?>
</tbody>
