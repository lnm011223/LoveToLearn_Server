<div class="box">
    <?php echo show_title($this,'修改密码');?>

    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">账号信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'TUNAME'); ?></td>
                        <td width="30%">
                            <?php echo $model->{'TUNAME'}; ?>
                            <?php echo $form->error($model, 'TUNAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'TCNAME'); ?></td>
                        <td width="30%">
                            <?php echo $model->{'TCNAME'}; ?>
                            <?php echo $form->error($model, 'TCNAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                    <tr>
                        <td>修改新密码</td>
                        <td>
                            <?php echo $form->passwordField($model, 'TPWD', array('class' => 'input-text','value'=>'')); ?>
                            <?php echo $form->error($model, 'TPWD', $htmlOptions = array()); ?>
                        </td>
                    </tr>



                </table>
            </div>


        </div><!--box-detail-tab-item end   style="display:block;"-->
    </div><!--box-detail-bd end-->
    <div class="box-detail-submit">
        <button onclick="submitType='baocunPWD'" class="btn btn-light-green" type="submit">保存</button>
    </div>
    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        var $date=$('#<?php echo get_class($model);?>_date');
        $date.on('click', function(){
            WdatePicker({
                startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});});
    });
</script>



