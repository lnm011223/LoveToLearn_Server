<?php
 
//TSGBZ-BTLWJ-ZB5FB-FEHUH-VLBAV-TKFEJ
class  QuestionController extends BaseController {

	protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

	public function actionGetAll($book){
		$data=array();
		$question=Question::model()->findAll("book_name='".$book."'");	
		// $question=Question::model()->find()->where("classNum=".$index);
		$num=count($question)>5?5:count($question);
		shuffle($question);//随机排序
		for($i=0;$i<$num;$i++){
			$temp=array();
			if($question[$i]['question_type'] == "多选题")
			{
				$c_index = 'A';
				$ans_str = $question[$i]['ans'];
				for($j=0;$j<5;$j++)
				{
					$select_val = $question[$i]['select'.($j+1)];
					if($select_val=="")
						break;
					$cur_index = chr(ord($c_index)+$j);
					$temp[$j] = array($cur_index => $select_val);
					if(strstr($ans_str, $cur_index))
						$temp[$j] += array('isAns' => 1);
					else
						$temp[$j] += array('isAns' => 0);
				}

				// print_r($temp);				
				// shuffle($temp);
				$cur_ans = "";
				for($j=0;$j<count($temp);$j++)
				{
					if($temp[$j]['isAns'])
						$cur_ans = $cur_ans.chr(ord($c_index)+$j);
				}
				// print($ans_str);
				// print($cur_ans);

				// print_r($temp);
				$question[$i]["ans"] = $cur_ans;
			}
			$temp[0]=$question[$i]['select1'];
			$temp[1]=$question[$i]['select2'];
			$temp[2]=$question[$i]['select3'];
			$temp[3]=$question[$i]['select4'];
			$temp[4]=$question[$i]['select5'];
			$temp = array_diff($temp, [""]); //去除空白选项
			$data[$i]=$question[$i];
			// TODO 删除多余的select
			$data[$i]['select1']=$temp;
		}
		echo CJSON::encode($data);
	}

	public function actionGetRank($id){
		$data=array();

		$rank=Rank::model()->findAll("1=1 order by score desc limit 0,30");	

		$user=Rank::model()->find("user_id='".$id."'");

		$data['rank']=$rank;
		$data['user']=$user;
		$ret = array_search($user, $rank);
		// echo $ret;
		if($ret)
			$data['num'] = $ret + 1;
		else
			$data['num'] = -1;
		echo CJSON::encode($data);
	}

	public function actionUpdateRank($userId, $score, $name){
		$data = array();
		// 获取用户数据
		$user = Rank::model()->find("user_id='".$userId."'");
		if($user)
			$user["score"] += $score;
		else
		{
			$user = new Rank();
			$user["user_id"] = $userId;
			$user["score"] = $score;
			$user["user_name"] = $name;
			// 还需要前端传school、grade、class
		}

		$user->save();
	}

	public function actionGetBook(){
		$data=array();

		$data=Question::model()->findAll("1=1 GROUP BY book_name");	
 
		echo CJSON::encode($data);
	}

	public function actionSubmitRecord($userId,$score,$rightNum,$questionList){
		$data=array();
		$record=new AnwserRecord();
		$questionList=CJSON::decode($questionList);
		put_msg($questionList);
		$record['user_id']=$userId;
		$record['score']=$score;
		$record['right_num']=$rightNum;
		$record['question_num']=count($questionList);
		$record['date']=date('Y-m-d h:i:s', time());
		$data['status']=$record->save();

	 	foreach ($questionList as $v) {
			$detail=new  AnwserRecordDetail();
			$detail['anwser_record_id']=$record['id'];
			$detail['question_id']=$v['id'];
			$detail->save();
		}
		echo CJSON::encode($data);
	}

	public function actionGetRecord($userId){
		$data=array();
		$record=AnwserRecord::model()->findAll("user_id='".$userId."' order by date DESC");
		$data['record']=$record;
		echo CJSON::encode($data);
	}

	public function actionGetDetail($anwserRecordId){
		$data=array();
		$record=AnwserRecordDetail::model()->findAll('anwser_record_id='.$anwserRecordId);
		put_msg('79');
		$idArray=array();
		foreach ($record as $key => $v) {
			$idArray[$key]=$v['question_id'];
		}
		put_msg('84');
		$id= implode(",", $idArray);
		$id='('.$id.')';
		$data['question']=Question::model()->findAll('id in '.$id);
		echo CJSON::encode($data);
	}
	
	public function actionIndex() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionUpdate($id, $question_type = "") {
        $modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
        // echo CJSON::encode($model);
        if (!Yii::app()->request->isPostRequest) {
		   $data = array();
		   
		   if($question_type!="")
		   {
			   $model['question_type'] = QuestionType::model()->find("id=".$question_type)->type;
			}
		   $data['id'] = $id;
		   $data['model'] = $model;
		   $data['grade'] = QuestionGrade::model()->findAll(); 
		   $data['type'] = QuestionType::model()->findAll();
           $this->render('update', $data);
        } else {
           $this->saveData($model,$_POST[$modelName]);
        }
	}

	function saveData($model,$post) {
		$model->attributes =$post;
		if(isset($_POST['grade']))
		{
			$grade = $_POST['grade'];
			$model->classNum = $grade; 
			if($grade!="")
			{
				$as = QuestionGrade::model()->find("id= ".$grade);
				$model->class = $as->class;
			}
		}
		if(isset($_POST['type']))
		{
			$type = $_POST['type'];
			if($type!="")
			{
				$ts = QuestionType::model()->find("id=".$type);
				$model->question_type = $ts->type;
			}
		}
        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }
	
    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['id'] = -1;
			$data['model'] = $model;
			$data['grade'] = QuestionGrade::model()->findAll(); 
			$data['type'] = QuestionType::model()->findAll();
            $this->render('update', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

	public function actionDelete($id) {
        parent::_clear($id);
    }
	
}

	