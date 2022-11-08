<?php $form = $this->beginWidget('CActiveForm', get_form_list());
?>
<div class="box">
    <?php echo show_title($this,'',$model->userId); ?>

    <div class="content">
        <div class="user_main">

            <div class="flex-center-2 ui-margin-10">
                <?php if ($model->headimgurl){?>
            <div class="headimg"> <img src="<?php echo ($model->headimgurl)?>"></div>
            <?php }?>
            </div>
            <div class="flex-center-2 ui-margin-10"><?php echo $model->TCNAME?></div>

            <div class="info-grey flex-center-2 ui-margin-10"><?php echo $model->blogIntrol?></div>

        </div>
    </div>
    <div class="content">
        <div class="user_info">
            <?php
            function getVar($var){
                return $var ? $var :'未填写';
            }
            ?>
            <div class="info-item">
            邮箱：
            <div class="info-grey"><?php echo getVar($model->userEmail)?></div>
            </div>
            <div class="info-item">
            生日：
            <div class="info-grey"><?php echo getVar($model->birthday)?></div>
            </div>

            <div class="info-item">
            QQ：
            <div class="info-grey"><?php echo getVar($model->userQQ)?></div>
            </div>

            <div class="info-item">
            微信：
            <div class="info-grey"><?php echo getVar($model->wechat_num)?></div>

        </div>
    </div>

    <?php $this->endWidget();
    ?>
</div>

