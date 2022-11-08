<div class="box">
    <?php echo show_title($this,'修改信息');?>

    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">个人信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="2">主要信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'headimgurl'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'headimgurl', array('class' => 'input-text fl'));
                            ?>
                            <?php echo show_pic($model->headimgurl,get_class($model).'_'.'headimgurl')?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_headimgurl', 'jpg');
                            </script>
                            <?php echo $form->error($model, 'headimgurl', $htmlOptions = array());
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'TUNAME'); ?></td>
                        <td width="30%">
                            <?php echo $model->{'TUNAME'} ?>
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
                        <td width="30%"><?php echo $form->labelEx($model, 'blogIntrol'); ?></td>
                        <td width="30%">
                            <?php echo $form->textArea($model, 'blogIntrol', array('class' => 'input-text','maxlength'=>'2000')); ?>
                            <?php echo $form->error($model, 'blogIntrol', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="2">更多信息</td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'birthday'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'birthday', array('class' => 'Wdate')); ?>
                            <?php echo $form->error($model, 'birthday', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'userEmail'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'userEmail', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'userEmail', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'userQQ'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'userQQ', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'userQQ', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo $form->labelEx($model, 'wechat_num'); ?></td>
                        <td width="30%">
                            <?php echo $form->textField($model, 'wechat_num', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'wechat_num', $htmlOptions = array()); ?>
                        </td>
                    </tr>


                </table>
            </div>


        </div><!--box-detail-tab-item end   style="display:block;"-->
    </div><!--box-detail-bd end-->
    <div class="box-detail-submit">
        <button onclick="submitType='baocun'" class="btn btn-light-green" type="submit">保存</button>
    </div>
    <?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        var $date=$('#<?php echo get_class($model);?>_birthday');
        $date.on('click', function(){
            WdatePicker({
                startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});});
    });
</script>



