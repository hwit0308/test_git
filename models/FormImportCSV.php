<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\GoodsMst;

/*
* Form Import CSV
*
* @since : 02/02/2016
* @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
*
*/

class FormImportCSV extends Model
{

    public $file;

    public function rules()
    {
        return [
            [['file'], 'required', 'message' => \Yii::t('app', 'required_select')],
            [['file'], 'file', 'extensions' => 'csv', 'maxSize'=> 8*1024*1024,
                'tooBig' => \Yii::t('app', 'file size upload'), 'checkExtensionByMimeType' => false ,
                'wrongExtension' => \Yii::t('app', 'Extension CSV')],
        ];
    }

    public function attributeLabels()
    {
        return[
            'file' => 'CSVファイル',
        ];
    }
    
    /*
     * Update or add 
     * 
     * Auth Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * Date 23/03/2016
     */
    
    public function saveData($data)
    {
        $goodsMst = GoodsMst::findOne($data[0]);
        // check exist
        if (!$goodsMst) { // case add new record
            $goodsMst = new GoodsMst();
        }
        $goodsMst->goods_jan = $data[0];
        $goodsMst->goods_name = $data[1];
        $goodsMst->goods_name2 = $data[2];
        $goodsMst->goods_model_id = $data[3];
        $goodsMst->goods_sim_type = $data[4];
        $goodsMst->goods_sim_class = $data[5];
        $goodsMst->goods_color = $data[6];
        $goodsMst->goods_size = $data[7];
        $goodsMst->goods_maker = $data[8];
        $goodsMst->goods_decr = $data[9];
        $goodsMst->goods_last_upd_id = Yii::$app->user->getIdentity()->staff_id;
        $goodsMst->last_upd_date = date('Y-m-d H:i:s');
        
        if (!$goodsMst->save()) {
            return false;
        }
        
        return true;
    }
}
