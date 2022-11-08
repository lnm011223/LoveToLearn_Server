<div class="box">
    <div class="box-title c">
        <?php echo show_title($this,"导入学生资料")?>
        <div class="box-detail">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <div style="display:block;" class="box-detail-tab-item">
                    <table class="mt15">
                    <tr>
                        <td><?php echo "导入模板下载"; ?></td>
                        <td>
                            <?php $mobanUrl = '/sanli/uploads/moban.xlsx'?>
                            <!-- 本地需调整这里，加上/sanli，服务器不需要调整 -->
                            <a href="<?php echo $mobanUrl ?>">模板下载</a>
                        </td>
                    </tr>
                    <tr>
                        <td>学校(必填项)</td>
                        <td>
                            <?php echo $form->hiddenField($model, 'schoolid', array('class' => 'input-text')); ?>
                            <div id="school"><?php echo $form->hiddenField($model, 'schoolname', array('class' => 'input-text')); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo "文件上传"; ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'excelPath', array('class' => 'input-text fl')); ?>
                            <div>只能上传 xlsx xls 格式文件（限制2M）</div>
                            <!-- 改缩略图这里要改 -->
                            <!-- face_game_bigpic -->
                            <?php /*$basepath=BasePath::model()->getPath();*/
                            $picprefix='';
                            //$model->news_pic='t1234.jpg';
                            //if($basepath){ $picprefix=$basepath; }?>
                            <div class="upload_img fl" id="upload_pic_cstuifo_excelPath"> </div>

                            <script>we.uploadpic('<?php echo get_class($model);?>_excelPath','<?php echo $picprefix;?>','','','',0);</script>
                            <?php echo $form->error($model, 'excelPath', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>使用说明</td>
                        <td>
                            该模板所有列均需填写，否则导入会产生错误，部分列设置了数据验证，若出错请检查填写格式和内容，地区请按照地区验证器表格格式填写。
                        </td>
                    </tr>

                </table>
            </div>
            <div class="box-detail-submit">
                <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">导入</button>
                <button class="btn" type="button" onclick="we.back();">取消</button>
            </div>


            <?php $this->endWidget();?>
        </div><!--box-detail end-->
    </div><!--box end-->
    <script>
        xmSelect.render({
            el: '#school',
            theme: {
                color: '#368ee0',
            },
            autoRow: true,
            direction: 'down',
            language: 'zn',
            filterable: true,
            radio: true,
            clickClose: true,
            empty:"没有数据",
            tips: '请搜索您要导入的学校，可先输入1-2个字，没有数据请联系管理员',
            searchTips: '请搜索',
            model: {
                label: {
                    type: 'text',
                    text: {
                        //左边拼接的字符
                        left: '',
                        //右边拼接的字符
                        right: '',
                        //中间的分隔符
                        separator: ', ',
                    },
                }
            },
            remoteSearch: true,
            remoteMethod: function(val, cb, show){
                //这里如果val为空, 则不触发搜索
                if(!val){
                    return cb([]);
                }
                $.ajax({
                    type: 'get',
                    url: '<?php echo $this->createUrl("ClubList/schoollist");?>',
                    data: {
                        keyword:val
                    },
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        var obj=[];
                        for (var i = 0; i < res.data.length; i++) {
                            obj.push({
                                name: res.data[i].club_name ,
                                value: res.data[i].id
                            });
                        }
                        cb(obj);
                    },
                    error: function (err) {
                        return cb([]);
                    }
                });
            },
            on: function (data) {
                var selectArr = data.arr;
                var seachArr = [];
                var seachname = [];
                for (var j = 0; j < selectArr.length; j++) {
                    seachArr.push(selectArr[j].value)
                    seachname .push(selectArr[j].name)
                }
                $("#Userinfo_schoolid").val(seachArr.toString());
                $("#Userinfo_schoolname").val(seachname.toString());
            }
        })

    </script>
   