
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>题目列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加题目</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="题目标题" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                    <th style='text-align: center;width: 50px'>序号</th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('class');?></th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('book_name');?></th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('section');?></th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('test_type');?></th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('question_type');?></th>
                    <th style='text-align: center;width: 50px'><?php echo $model->getAttributeLabel('question_id');?></th>
                    <th style='text-align: center;width: 90px'><?php echo $model->getAttributeLabel('question');?></th>
                    <th style='text-align: center;width: 50px'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                   
                    foreach($arclist as $v){ 
                    ?>
                    <tr>
                        <td style='text-align:center;'><?php echo $v->id; ?></td>
                        <td style='text-align:center;'><?php echo $v->class; ?></td>
                        <td style='text-align:center;'><?php echo $v->book_name; ?></td>
                        <td style='text-align:center;'><?php echo $v->section; ?></td>
                        <td style='text-align:center;'><?php echo $v->test_type; ?></td>
                        <td style='text-align:center;'><?php echo $v->question_type; ?></td>
                        <td style='text-align:center;'><?php echo $v->question_id; ?></td>
                        <td style='text-align:center;'><?php echo $v->question; ?></td>

                        <td style='text-align: center; width: 60px'>
                        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>

var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

</script>
