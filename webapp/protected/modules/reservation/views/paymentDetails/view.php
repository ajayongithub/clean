

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile'=>false ,
	'attributes' => array(
'id',
'order_id',
'payment_id',
'payment_issue_date',
'payment_confirm_date',
'amount',
'payment_type',
'status',
//'extra1',
	),
)); 
//string $text, mixed $url='#', array $htmlOptions=array ( )
echo CHtml::link('Download Mandate',Yii::app()->createUrl('reservation/paymentDetails/downloadMandate/orderId/'.$model->order_id),array('class'=>'btn'));
?>

