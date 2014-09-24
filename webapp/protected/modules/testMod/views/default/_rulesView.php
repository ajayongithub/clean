<?php	$this->widget('zii.widgets.grid.CGridView', array(
		'cssFile'=>false,
		'dataProvider'=>$dataProvider,
		'columns'=>array(
			array('type'=>'raw',
				'name'=> 'recurrence',
				'value'=> 'CHtml::dropDownList(\'recurrinRow\'.$row,
									$data->recurrence,
									array(
									 \'\'=>\'All\',
									 \'1\'=>\'First\',
									 \'2\'=>\'Second\',
									 \'3\'=>\'Third\',
									 \'4\'=>\'Fourth\',
									 \'5\'=>\'Fifth\',
									)
								  )'
			),
			array(
            'type'=>'raw',
            'name'=>'day',
        'value'=> ' CHtml::dropDownList(\'dayInRow\'.$row,$data->day,array(
                    \'MO\'=>\'Monday\',
                    \'TU\'=>\'Tuesday\',
                    \'WE\'=>\'Wednesday\',
                    \'TH\'=>\'Thursday\',
                   \'FR\'=>\'Friday\',
                   \'SA\'=>\'Saturday\',
                   \'SU\'=>\'Sunday\',))',  
                ),
            array(
				'type'=>'raw',
            	'name'=>'ts_id',
            	'value'=>'CHtml::dropDownList(\'tsInRow\'.$row,
            						$data->ts_id,
            						CHtml::listData(TimeSlots::model()->findAll(), \'id\', \'slot_name\')
            					)'
            ),
            array(
			'class' => 'CButtonColumn',
            'template'=>'{update}|{delete}',
            'buttons'=>array(
            'update'=>array('label'=>'Update','click'=>'js:function(){ alert(\'I got called\');}'),
            'delete'=>array('label'=>'Delete','click'=>'js:function(){ alert(\'I got called\');}'),
            ),
			),
		)
	)); 
?>
