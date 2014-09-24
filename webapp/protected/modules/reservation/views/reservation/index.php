<?php if(Yum::hasFlash()) {
echo '<div class="success">';
//echo Yum::getFlash(); 
Yum::renderFlash();
echo '</div>';
} 
?>

<h2><?php echo Yii::t('reservation','Available Reservations for:').' '.$location; ?></h2>
<h3><?php echo Yii::t('reservation','Next Service Type:').' '.Yii::t('reservation',Plans::$service_type[$serviceType]); ?></h3>
<div class="bulle">
<table class="table">
	<?php if($newSched!=null){?>
		<?php echo '<thead><th><a>'.Yii::t('reservation','Date').'</a></th><th><a>'.Yii::t('reservation','Slot').'</a></th><th><a>'.Yii::t('reservation','Slot Begin').'</a></th><th><a>'.Yii::t('reservation','Slot End').'</a></th><th><a>'.Yii::t('reservation','Action').'</a></th></thead>';?>	
		<?php	foreach($newSched as $sched){ ?>
			<tr>
			<?php //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($sched['sched_date'], 'dd-MM-yyyy'),'long',null); ?>
			<td><?php echo $sched['sched_date']; ?></td>
				<td><?php echo Yii::t('reservation',$sched['slot_name']); ?></td>
				<td><?php echo $sched['slot_begin']; ?></td>
				<td><?php echo $sched['slot_end']; ?></td>
				<td><form id="<?php echo $sched['id']; ?>" action="<?php echo Yii::app()->createUrl('/reservation/reservation/reserve');?>" method="post">
						<input type="hidden" name="id" value="<?php echo $sched['id'];?>"/>
						<input type="hidden" name="type" value="<?php echo $serviceType;?>"/>
						<input type="submit" value="<?php echo  Yii::t('reservation','Reserve'); ?>" class="btn btn-small" />
						</form></td>
			</tr>
<?php 		}
		}?></table>
</div>


<!--  -->
<h2><?php echo Yii::t('reservation','History of reservations');?></h2>
<div class="bulle">
<table class="table">
	<?php if($history!=null){?>
	<?php echo  '<thead><th><a>'.Yii::t('reservation','At').'</a></th><th><a>'.Yii::t('reservation','Reserved for').'</a></th><th><a>'.Yii::t('reservation','Slot Name').'</a></th><th><a>'.Yii::t('reservation','Reserved On').'</a></th><th><a>'.Yii::t('reservation','Type').'</a></th><th><a>'.Yii::t('reservation','Status').'</a></th><th><a>'.Yii::t('reservation','Action').'</a></th></thead>';?>	
		<?php	foreach($history as $rec){ ?>
			<tr>
				<td><?php echo $rec['location_address']; ?></td>
				<?php //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($rec['sched_date'], 'dd-MM-yyyy'),'long',null); ?>
				<td><?php echo $rec['sched_date']; ?></td>
				<td><?php echo Yii::t('reservation',$rec['slot_name']); ?></td>
				<?php //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($rec['reserved_on'], 'dd-MM-yyyy'),'long',null); ?>
				<td><?php $rec['reserved_on']; ?></td>
				<td><?php echo Plans::$service_type[($rec['service_type'])]; ?></td>
				<td><?php echo $rec['status']; ?></td> 
				<td><form id="<?php echo $rec['id']; ?>" action="<?php echo Yii::app()->createUrl('/reservation/reservation/cancel');?>" method="post">
						<input type="hidden" name="id" value="<?php echo $rec['id'];?>"/>
						<?php if(strcmp($rec['status'],'Reserved')==0){?>
						<input type="submit" value="<?php echo  Yii::t('reservation','Cancel'); ?>" class="btn btn-small" />
						<?php }?>
						</form></td>
			</tr>
<?php 		}
		}?></table>
</div>
