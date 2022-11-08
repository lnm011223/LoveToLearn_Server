<div class="box">
      <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>冻结商家</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('merchant_num');?></th>
                        <th><?php echo $model->getAttributeLabel('merchant_name');?></th>
                        <th><?php echo $model->getAttributeLabel('merchant_nature');?></th>
                        <th><?php echo $model->getAttributeLabel('merchant_freeze_treatment');?></th>
                        <th><?php echo $model->getAttributeLabel('merchant_freeze_reason');?></th>
                        <th><?php echo $model->getAttributeLabel('merchant_freeze_apply_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                  	<?php foreach($arclist as $v){ ?>
                    <?php $merchant_intention=MerchantIntention::model()->find(array(
                    'select' =>array('merchant_num','merchant_name','merchant_nature'),
                    'order' => 'merchant_num',
                    'condition' => 'merchant_num='.$v->merchant_num,
                    )); ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo CHtml::link($merchant_intention->merchant_num, array('detail', 'id'=>$v->id)); ?></td>
                        <td><?php echo CHtml::link($merchant_intention->merchant_name, array('detail', 'id'=>$v->id)); ?></td>
                        <td><?php  echo $merchant_intention->merchant_nature; ?></td>
                        <td><?php  echo $v->merchant_freeze_treatment; ?></td>
                        <td><?php  echo $v->merchant_freeze_reason;?></td>
                        <td><?php echo $v->merchant_freeze_apply_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
					<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>
