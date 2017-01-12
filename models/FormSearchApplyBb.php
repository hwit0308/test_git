<?php

namespace backend\models;

use Yii;
use common\models\BaseForm;
use yii\data\ActiveDataProvider;
use common\models\AeonbbApplyTbl;
use common\models\OptMst;
use common\models\ShareplanOption;

/**
 *
 * @author
 */
class FormSearchApplyBb extends BaseForm
{
    
    public $apply_id;
    public $apply_tel;
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
            'apply_id', 'apply_tel', 'user_name' , 'date_1' , 'date_2' , 'status' , 'img_status', 'apply_orderid',
            'apply_sales'
        ];
    }
    
    public function rules()
    {
        return [
            [['apply_id', 'apply_tel', 'user_name' , 'date_1' , 'date_2' , 'status' , 'img_status',
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
        $query->select('aeonbb_apply_tbl.*, goods_mst.goods_name, plan_mst.plan_name')
                ->from('aeonbb_apply_tbl');
        $query->join('LEFT JOIN', 'goods_mst', 'goods_mst.goods_jan = aeonbb_apply_tbl.apply_jan');
        $query->join('LEFT JOIN', 'plan_mst', 'plan_mst.plan_code = aeonbb_apply_tbl.apply_planid');
        $query->andWhere(['not', ['aeonbb_apply_tbl.apply_idx_before' => null]]);
        $query->andFilterWhere(['apply_id' => $this->apply_id]);
        $query->andFilterWhere(['like', 'aeonbb_apply_tbl.apply_tel', $this->apply_tel]);
        $query->andFilterWhere(['>=', 'DATE_FORMAT(aeonbb_apply_tbl.apply_date,"%Y/%m/%d")', $this->date_1]);
        $query->andFilterWhere(['<=', 'DATE_FORMAT(aeonbb_apply_tbl.apply_date,"%Y/%m/%d")', $this->date_2]);
        $query->andFilterWhere(['=', 'aeonbb_apply_tbl.apply_sts', $this->status]);
        if ((!empty($this->img_status) || $this->img_status == 0) && $this->img_status != 10) {
            $query->andFilterWhere(['=', 'aeonbb_apply_tbl.apply_img_status', $this->img_status]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
                'route' => 'applyBb',
            ],
            'sort' => [
                'defaultOrder' => [
                    'apply_id' => SORT_DESC
                ]
            ]
        ]);
        $dataProvider->sort->attributes['apply_id'] = [
            'desc' => ['aeonbb_apply_tbl.apply_id' => SORT_DESC],
            'asc' => ['aeonbb_apply_tbl.apply_id' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_tel'] = [
            'desc' => ['aeonbb_apply_tbl.apply_tel' => SORT_DESC],
            'asc' => ['aeonbb_apply_tbl.apply_tel' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_sts'] = [
            'desc' => ['aeonbb_apply_tbl.apply_sts' => SORT_DESC],
            'asc' => ['aeonbb_apply_tbl.apply_sts' => SORT_ASC],
            
        ];
        $dataProvider->sort->attributes['apply_date'] = [
            'desc' => ['aeonbb_apply_tbl.apply_date' => SORT_DESC],
            'asc' => ['aeonbb_apply_tbl.apply_date' => SORT_ASC],
            
        ];
        return $dataProvider;
    }
    
    /*
     * Render list Option
     * 
     * @Auth : Nguyễn Văn Hiến <hiennv6244@cowell-asia.com.vn>
     * @Date : 15/11/2016
     * 
     */
    
    public static function renderListOption($applyId)
    {
        $applyOpt = AeonbbApplyTbl::findOne(['apply_id' => $applyId]);
        $optMst = new OptMst();
        $optText = '';
        if ($applyOpt) {
            $simOpt = $optMst->renderSimOpt($applyOpt->apply_sim_opt, $applyOpt->apply_jan);
            $optText .= FormSearchApplyBb::renderTextOption($simOpt);
            
            // render plan share
            $optionShare = ShareplanOption::findAll(['apply_id' => $applyId]);
            if (count($optionShare) > 0) {
                foreach ($optionShare as $key => $value) {
                    $simOpt = $optMst->renderSimOpt($value->sim_opt, $applyOpt->apply_jan);
                    $optText .= '<br/>';
                    $optText .= $value->sim_tel . ':<br/>' . FormSearchApplyBb::renderTextOption($simOpt);
                }
            }
        }
        return $optText;
    }
    
    /*
     * Render text Option
     * 
     * @Auth : Nguyễn Văn Hiến <hiennv6244@cowell-asia.com.vn>
     * @Date : 15/11/2016
     * 
     */
    
    public static function renderTextOption($simOpt)
    {
        $optText = '';
        if (count($simOpt) > 0) {
            $indent = '';
            foreach ($simOpt as $key => $value) {
                if ($value['flag'] == 1) {
                    $optText .= ($value['title']) ? $value['title']."<br/>" : '';
                    $indent = "&nbsp&nbsp&nbsp";
                }
                if (!empty($value['children'])) {
                    if ($key === '000' || $key === 'special') {
                        if ($key === 'special') {
                            $optText .= "<br/>";
                        }
                        foreach ($value['children'] as $child) {
                            $optText .= $indent . $child['opt_name'] ."<br/>";
                        }
                    } else {
                        foreach ($value['children'] as $child) {
                            $optText .= $indent . $child['opt_name'] ."<br/>";
                        }
                    }
                }
            }
        }
        return $optText;
    }
}
