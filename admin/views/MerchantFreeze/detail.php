<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商家》冻结管理》冻结商家》详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">冻结信息</td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_num'); ?></td>
                        <td colspan="3">
                             <?php echo $model->merchant_num; ?>
                        </td>
                    </tr>
                    <?php $merchant_intention=MerchantIntention::model()->find(array(
                    'select' =>array('merchant_num','merchant_name','merchant_nature'),
                    'order' => 'merchant_num',
                    'condition' => 'merchant_num='.$model->merchant_num,
                    )); ?>

                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_name'); ?></td>
                        <td colspan="3">
                             <?php echo $merchant_intention->merchant_name; ?>
                        </td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_nature'); ?></td>
                        <td colspan="3">
                             <?php echo $merchant_intention->merchant_nature; ?>
                        </td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_freeze_treatment'); ?></td>
                        <td colspan="3">
                             <?php echo $model->merchant_freeze_treatment; ?>
                        </td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_freeze_reason'); ?></td>
                        <td colspan="3">
                             <?php echo $model->merchant_freeze_reason; ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">操作信息</td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_freeze_state'); ?></td>
                        <td colspan="3">
                             <?php echo $model->merchant_freeze_state; ?>
                        </td>
                    </tr>
                </table>
                </div>
              
            </div><!--box-detail-tab-item end   style="display:block;"-->
            
        </div><!--box-detail-bd end-->
        
        <div class="box-detail-submit">
            <?php if($model->merchant_freeze_state=='待审核'){?>
            <button onclick="detailUrl()" class="btn btn-blue" type="button">撤销</button><?php }else{?>
                <button onclick="deleteUrl" class="btn btn-blue" type="button">删除</button>
            <?php } ?>
            <button class="btn" type="button" onclick="we.back();">取消</button></div>
       
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 设置时间
var fnSetDateTime=function(){
    WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss'});
};</script>
<script>
var deleteUrl=function() {
    <?php $model->merchant_freeze_state=''; ?>;
};
var detailUrl=function(){'<?php echo $this->createUrl('detail', array('id'=>'ID')); ?>';
};
</script>