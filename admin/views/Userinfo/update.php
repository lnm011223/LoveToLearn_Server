<div class="box">
    <?php echo show_title($this,"详情")?>
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model,'name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'education'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'education', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'education', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'sex'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'sex', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'sex', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'schoolname'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'schoolname', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'schoolname', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'parents'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'parents', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'parents', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'p_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'p_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'p_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <?php $model->idnum = AES_decrypt($model->find_id);?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'idnum'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model,'idnum', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'idnum', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'aller'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model,'aller', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'aller', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->

        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>


        <?php $this->endWidget();?>
    </div>
