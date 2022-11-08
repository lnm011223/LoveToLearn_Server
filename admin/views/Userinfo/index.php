<div class="box">
    <?php echo show_title($this);?>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>刪除</a>

            <a class="btn" href="<?php echo $this->createUrl('createByImp');?>"><i class="fa fa-plus"></i>导入学生信息</a>
        </div><!--box-header end-->

        <form name="search" action="<?php echo Yii::app()->request->url;?>" method="get">
            <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
            <label style="margin-right:10px;">
                <span>省：</span>
                <select name="province" id="province">
                    <option value="">请选择</option>
                    <?php foreach ($province as $v) { ?>
                        <option value="<?php echo $v->id; ?>" <?php if (Yii::app()->request->getParam('province') == $v->id) { ?> selected<?php } ?>><?php echo $v->name; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label style="margin-right:10px;">
                <span>市：</span>
                <select name="city" id='city'>
                    <option value="">请选择</option>
                    <?php if(isset($city)) foreach ($city as $v) { ?>
                        <option value="<?php echo $v->id; ?>" <?php if (Yii::app()->request->getParam('city') == $v->id) { ?> selected<?php } ?>><?php echo $v->name; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label style="margin-right:10px;">
                <span>镇区：</span>
                <select name="district" id='district'>
                    <option value="">请选择</option>
                    <?php if(isset($district)) foreach ($district as $v) { ?>
                        <option value="<?php echo $v->id; ?>" <?php if (Yii::app()->request->getParam('district') == $v->id) { ?> selected<?php } ?>><?php echo $v->name; ?></option>
                    <?php } ?>
                </select>
            </label>

            <label style="margin-right:20px;">
                <span>年级（纯数字）</span>
                <input style="width:20px;" class="input-text" type="text" name="grade" value="<?php echo Yii::app()->request->getParam('grade');?>">
            </label>

            <label style="margin-right:20px;">
                <span>班级（纯数字）</span>
                <input style="width:20px;" class="input-text" type="text" name="class" value="<?php echo Yii::app()->request->getParam('class');?>">
            </label>

            <label style="margin-right:10px;">
                <span>学校/姓名关键字查询：</span>
                <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
            </label>

            <label style="margin-right:10px;">
                <span>身份证号：</span>
                <input style="width:200px;" class="input-text" type="text" name="idnum_encode" value="<?php echo Yii::app()->request->getParam('idnum_encode');?>">
            </label>

            <button class="btn btn-blue" type="submit">查询</button>
            <a class="btn" href="<?php echo $this->createUrl('Userinfo/Excel',array());?>"><i class="fa fa-download"></i>导出总表</a>
        </form>
        <div style="margin-top: 5px" >
            <?php  if($_SESSION['F_ROLENAME']==='后台超级管理员'){  ?>
                <a class="btn btn-blue"  href="<?php echo $this->createUrl('UpdateTime');?>" onclick="return confirm('确定更新?此操作不可逆！！每年9月1日都会自动更新！！')" title="年级更新"><i class="fa fa-plus "> 年级更新(请勿点击)</i></a>
                <?php
                $sql = "select * from update_time where id=(select max(id) from update_time)";
                $time = UpdateTime::model()->findBySql($sql);
                ?>
                年级更新<strong>(系统会自动更新,此按钮为备用按钮)</strong>:每年手动更新年级信息，上次更新信息的时间(注意：更新不可逆b，操作需谨慎，12年级默认不更新)：<?php echo empty($time->time)?"从未更新":$time->time; ?>
                <br>
                <a style="margin-top: 5px" class="btn btn-blue"  href="<?php echo $this->createUrl('ReGrade');?>" onclick="return confirm('确定递减？')" title="年级递减"><i class="fa fa-minus "> 年级递减(请勿点击)</i></a>
                年级递减:用于错误更新的回撤（12年级默认不回撤）
            <?php } ?>
        </div>
    </div><!--box-search end-->

    <div class="box-table">
        <table class="list">
            <thead>
            <tr>
                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                <th style='text-align: center;'>编号</th>
                <th style='text-align: center;'>名称</th>
                <th style='text-align: center;'>性别</th>
                <th style='text-align: center;'>出生日期</th>
                <th style='text-align: center;'>在读学历</th>
                <th style='text-align: center;'>昵称</th>
                <th style='text-align: center;'>手机号</th>
                <th style='text-align: center;'>学校名称</th>
                <th style='text-align: center;'>年级</th>
                <th style='text-align: center;'>班级</th>
                <th style='text-align: center;'>地区</th>
                <th style='text-align: center;'>头像</th>
                <th style='text-align: center;'>注册时间</th>
                <th style='text-align: center;'>身份证号</th>
                <th style='text-align: center;'>监护人</th>
                <th style='text-align: center;'>过敏等信息备注</th>
                <th style='text-align: center;'>操作</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $index = 1;
            foreach($arclist as $v){
                ?>
                <tr>
                    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                    <td style='text-align: center;'><span class="num num-1"><?php echo $index ?></span></td>
                    <td style='text-align: center;'><?php echo $v->name; ?></td>
                    <td style='text-align: center;'><?php echo $v->sex;?></td>
                    <td style='text-align: center;'><?php echo $v->birthday;?></td>
                    <td style='text-align: center;'><?php echo $v->education; ?></td>
                    <td style='text-align: center;'><?php echo $v->nikename; ?></td>
                    <td style='text-align: center;'><?php echo $v->phone; ?></td>
                    <td style='text-align: center;'><?php echo $v->schoolname; ?></td>
                    <td style='text-align: center;'><?php echo $v->grade; ?></td>
                    <td style='text-align: center;'><?php echo $v->class; ?></td>
                    <td style='text-align: center;'><?php echo $v->country." ".$v->province." ".$v->city." ".$v->district; ?></td>
                    <td style='text-align: center;'><?php echo BaseLib::model()->show_pic($v->header,NULL,0);?></td>
                    <td style='text-align: center;'><?php echo $v->registerdate; ?></td>
                    <td style='text-align: center;'><?php echo strlen($v->idnum_display)===18?$v->idnum_display:'<span style="color: red">'.$v->idnum_display."(".strlen($v->idnum_display).')</span>'; ?></td>
                    <td style='text-align: center;'><?php echo $v->getParentInfo(); ?></td>
                    <td style='text-align: center;'><?php echo $v->aller; ?></td>
                    <td style='text-align: center;'>
                        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <?php $index++; } ?>
            </tbody>
        </table>
    </div><!--box-table end-->
    <div class="box-page c"><?php $this->page($pages);?></div>
</div><!--box-content end-->
</div><!--box end-->


<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $("#province").change(function() {
        $('#city').html("<option value=''>请选择</option>");
        getLocation("province",'#city');
        //document.search.submit();
    });
    $("#city").change(function() {
        $('#district').html("<option value=''>请选择</option>");
        getLocation("city",'#district');
        //document.search.submit();
    });

    function getLocation(sourece,target) {
        var myselect = document.getElementById(sourece);
        var index = myselect.selectedIndex;
        var code = myselect.options[index].value;
        getData(code,target);
    }

    function getData(code, element) {
        $.ajax({
            url: "<?php echo $this->createUrl('select/getLocation'); ?>",
            data: {
                code: code
            },
            type: "get",
            success: function(res) {
                var data = JSON.parse(res);
                var str = "<option value=''>请选择</option>";
                for (var i = 0; i < data.length; i++) {
                    str += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                // //把所有<option>放到区的下拉列表里
                $(element).html(str);
            }
        });
    }


</script>
