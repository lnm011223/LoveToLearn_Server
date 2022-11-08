<div class="box">
    <?php echo show_title($this,'详情');?>

    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'TUNAME'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'TUNAME', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'TUNAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'TCNAME'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'TCNAME', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'TCNAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'PHONE'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'PHONE', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'PHONE', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'TPWD'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'TPWD', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'TPWD', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'F_ROLENAME');
                            ?></td>
                        <td>
                            <?php echo Select2::activeDropDownList($model, 'F_ROLENAME', Chtml::listData(Role::model()->findAll(), 'f_rname', 'f_rname'), array('prompt'=>'请选择','style'=>'width:160px;'));
                            ?>
                            <?php echo $form->error($model, 'F_ROLENAME', $htmlOptions = array());
                            ?>
                        </td>
                    </tr>

                    </table>
                </div>


            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-light-green" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
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



