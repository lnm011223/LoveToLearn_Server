    <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>题目信息修改</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list());?>

        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
         
                <div class="mt15">
                <table>
                	<tr class="table-title">
                    	<td colspan="6">题目</td>
                    </tr>


                    <tr>
                        <td><?php echo $form->labelEx($model, 'class'); ?></td>
                        <td>
                            <select name="grade">
                                <option value="">请选择</option>
                                <?php foreach($grade as $v){;?>
                                <option value="<?php echo $v->id;?>"<?php if($v->id==$model->classNum){?> selected<?php }?>><?php echo $v->class;?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td><?php echo $form->labelEx($model, 'book_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'book_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'book_name', $htmlOptions = array()); ?>     
                        </td>
        
                        <td><?php echo $form->labelEx($model, 'author'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'author', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'author', $htmlOptions = array()); ?>     
                        </td>
                        
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'section'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'section', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'section', $htmlOptions = array()); ?>     
                        </td>

                        <td><?php echo $form->labelEx($model, 'test_type'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'test_type', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'test_type', $htmlOptions = array()); ?>     
                        </td>
        
                        <td><?php echo $form->labelEx($model, 'question_type'); ?></td>
                        <td>
                            <select id = "question_type" name="type" data-id="<?php echo $id; ?>">
                                <option value="">请选择</option>
                                <?php foreach($type as $v){;?>
                                <option value="<?php echo $v->id;?>"<?php if($model->question_type == $v->type){?> selected<?php }?>><?php echo $v->type;?></option>
                                <?php }?>
                            </select>    
                        </td>
                    </tr>
                    <tr class="table-title">
                    	<td colspan="6">题目详情</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'question_id'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'question_id', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'question_id', $htmlOptions = array()); ?>     
                        </td>
                        <td><?php echo $form->labelEx($model, 'has_image'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'has_image', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'has_image', $htmlOptions = array()); ?>     
                        </td>
                        <td><?php echo $form->labelEx($model, 'question_img'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'question_img', array('class' => 'input-text fl')); ?>
                            <!-- face_game_bigpic -->
                            <?php $basepath=BasePath::model()->getPathFixed().'temp/';
                            $picprefix='';
                            //$model->news_pic='t1234.jpg';
                            //if($basepath){ $picprefix=$basepath; }?>
                         <div class="upload_img fl" id="upload_pic_NewsColumn_pic"> 
                          <?php if(!empty($model->question_img)) {?>
                             <a href="<?php echo $basepath.$model->question_img;?>" target="_blank">
                             <img src="<?php echo $basepath.$model->question_img;?>" width="100">
                             </a>
                             <?php }?>
                             </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_question_img','<?php echo $picprefix;?>','','','',0);</script>
                            <?php echo $form->error($model, 'question_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'question'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'question', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'question', $htmlOptions = array()); ?>
                        </td>
                        <td><?php if($model->question_type == "填空题") {echo $form->labelEx($model, 'input_area'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'input_area', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'input_area', $htmlOptions = array()); }?>     
                        </td>
                    </tr>
                    <tr class="table-title">
                    	<td colspan="6">选项</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'select1'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'select1', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'select1', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'select2'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'select2', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'select2', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'select3'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'select3', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'select3', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'select4'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'select4', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'select4', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'select5'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'select5', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'select5', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'ans'); ?></td>
                        <td colspan="5">
                            <?php echo $form->textField($model, 'ans', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ans', $htmlOptions = array()); ?>     
                        </td>
                    </tr>
                </table>
                </div>
              
            </div><!--box-detail-tab-item end   style="display:block;"-->
            
        </div><!--box-detail-bd end-->
        
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
       
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
//下拉菜单点击，加载数据
$("#question_type").change(function(){//左侧写入ID
    let typeNum = $(this).children('option:selected').val();
    let id = $(this).attr('data-id');
    console.log(id);
    console.log(typeNum);
    if(id!=-1)
        refresh(id, typeNum);//页面加载函数
    // location.reload();
});

function refresh(cur_id, type)
{
    window.location.href = 'index.php?r=question/update&id=' + cur_id + '&question_type=' + type;
}
</script>