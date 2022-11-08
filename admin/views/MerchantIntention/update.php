<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商家》意向入驻管理》添加入驻》添加</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'merchant_num'); ?></td>
                        <td colspan="3"><!-- 自动生成订单编号 -->
                             <?php echo $model->merchant_num; ?>
                        </td>
                    </tr>

                     <tr>
                        <td><?php echo $form->labelEx($model, 'merchant_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'merchant_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'merchant_name', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'merchant_nature'); ?></td>
                        <td>
                            <!--商家性质需要一个下拉选框-->
                            <?php echo $form->error($model, 'merchant_nature', $htmlOptions = array()); ?>
                            <?php echo $form->dropdownlist($model, 'merchant_nature', ['个体户'=>'个体户','有限责任公司'=>'有限责任公司','股份有限公司'=>'股份有限公司'],array('class' => 'dropdownlist')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'merchant_address'); ?></td>
                        <td  colspan="3">
                            <?php echo $form->textField($model, 'merchant_address', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'merchant_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'merchant_detail_address'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'merchant_detail_address', array('class' => 'input-text')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, '营业期限'); ?></td>
                            <!--营业日期需要两个date-->
                        <td colspan="3">    
                            
                            <input class="input-text" name="model[<?php echo $v->id;?>][business_start_time]" value="<?php echo $model->business_start_time;?>" onclick="fnSetDateTime(this);">
                            <?php echo $form->labelEx($model, '至'); ?>
                            
                             <input class="input-text" name="model[<?php echo $v->id;?>][business_end_time]" value="<?php echo $model->business_end_time;?>" onclick="fnSetDateTime(this);">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'business_license'); ?></td>
                        <td colspan="3">
                            <!--上传文件-->
                            <?php echo $form->hiddenField($model, 'business_license', array('class' => 'input-text fl')); ?>
                            <?php if($model->business_license!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_business_license"><a href="<?php echo $model->business_license;?>" target="_blank"><img src="<?php echo $model->business_license;?>" width="100"></a></div><?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_business_license', 'jpg');</script>
                            <?php echo $form->error($model, 'business_license', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'merchant_num', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'id', array('class' => 'input-text')); ?>
                </table>
                <div class="mt15">
                <table style='margin-top:5px;'>
                    <tr class="table-title">
                        <td colspan="4">联系人信息</td>
                    </tr>
                    <tr>
                        <td  width="15%"><?php echo $form->labelEx($model, 'contact_GF_account'); ?></td>
                        <td width="85%">
                            <?php echo $form->textField($model, 'contact_GF_account', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_GF_account', $htmlOptions = array()); ?>
                        </td>
                        <td  width="15%"><?php echo $form->labelEx($model, 'contact_name'); ?></td>
                        <td width="85%">
                            <?php echo $form->textField($model, 'contact_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text','maxlength'=>'11')); ?>
                            <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'contact_email'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'contact_email', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                </div>
              
            </div><!--box-detail-tab-item end   style="display:block;"-->
            
        </div><!--box-detail-bd end-->
        
        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button></div>
       
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 设置时间
var fnSetDateTime=function(){
    WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss'});
};</script>