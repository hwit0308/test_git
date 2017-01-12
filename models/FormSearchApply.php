<?php

namespace backend\models;

use Yii;
use common\models\BaseForm;
use yii\data\ActiveDataProvider;

/**
 *
 * @author
 */
class FormSearchApply extends BaseForm
{
    
    public $apply_id;
    public $goods_name;
    public $user_name;
    public $apply_orderid;
    public $apply_sales;
    public $date_1;
    public $date_2;
    public $status;
    public $img_status;


    public static $LABEL_CSV = [
        0 => '出力済み',
        1 => '未出力',
        2 => '全て'
    ];
    
    public function fields()
    {
        return [
            'apply_id', 'goods_name', 'user_name' , 'date_1' , 'date_2' , 'status' , 'img_status', 'apply_orderid',
            'apply_sales'
        ];
    }
    
    public function rules()
    {
        return [
            [['apply_id', 'goods_name', 'user_name' , 'date_1' , 'date_2' , 'status' , 'img_status',
                'apply_orderid', 'apply_sales'], 'safe']
        ];
    }
    
    public function __construct()
    {
        $this->status =  '';
        $this->img_status =  10;
    }
    
    /*
     * Get list apply
     * param @array
     * return @array
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 02/02/2016
     */
    
    public function getListApply()
    {
        $query = new \yii\db\Query();
        $query->select(['apply_tbl.*, goods_mst.goods_name, plan_mst.plan_name,'
            . ' CONCAT(apply_surname,"",apply_givenname) AS full_name'])
                ->from('apply_tbl');
        $query->join('LEFT JOIN', 'goods_mst', 'goods_mst.goods_jan = apply_tbl.apply_jan');
        $query->join('LEFT JOIN', 'plan_mst', 'plan_mst.plan_code = apply_tbl.apply_planid');
        $query->andFilterWhere(['apply_id' => $this->apply_id]);
        $query->andFilterWhere(['like', 'goods_mst.goods_name', $this->goods_name]);
        $query->andFilterWhere(['apply_tbl.apply_orderid' => $this->apply_orderid]);
        $query->andFilterWhere(['apply_tbl.apply_sales' => $this->apply_sales]);
        $query->andFilterWhere(['like', 'concat(apply_tbl.apply_surname, apply_tbl.apply_givenname)',$this->user_name]);
        $query->andFilterWhere(['>=', 'DATE_FORMAT(apply_tbl.apply_date,"%Y/%m/%d")', $this->date_1]);
        $query->andFilterWhere(['<=', 'DATE_FORMAT(apply_tbl.apply_date,"%Y/%m/%d")', $this->date_2]);
        $query->andFilterWhere(['=', 'apply_tbl.apply_sts', $this->status]);
        if ((!empty($this->img_status) || $this->img_status == 0) && $this->img_status != 10) {
            $query->andFilterWhere(['=', 'apply_tbl.apply_img_status', $this->img_status]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
                'route' => 'apply',
            ],
            'sort' => [
                'defaultOrder' => [
                    'apply_id' => SORT_DESC
                ]
            ]
        ]);
        $dataProvider->sort->attributes['apply_id'] = [
            'desc' => ['apply_tbl.apply_id' => SORT_DESC],
            'asc' => ['apply_tbl.apply_id' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_orderid'] = [
            'desc' => ['apply_tbl.apply_orderid' => SORT_DESC],
            'asc' => ['apply_tbl.apply_orderid' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_sales'] = [
            'desc' => ['apply_tbl.apply_sales' => SORT_DESC],
            'asc' => ['apply_tbl.apply_sales' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['goods_name'] = [
            'desc' => ['goods_mst.goods_name' => SORT_DESC],
            'asc' => ['goods_mst.goods_name' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['full_name'] = [
            'desc' => ['full_name' => SORT_DESC],
            'asc' => ['full_name' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_sts'] = [
            'desc' => ['apply_tbl.apply_sts' => SORT_DESC],
            'asc' => ['apply_tbl.apply_sts' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_date'] = [
            'desc' => ['apply_tbl.apply_date' => SORT_DESC],
            'asc' => ['apply_tbl.apply_date' => SORT_ASC],
            
        ];
        return $dataProvider;
    }
}
