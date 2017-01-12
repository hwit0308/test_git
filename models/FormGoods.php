<?php

namespace backend\models;

use Yii;
use common\models\GoodsMst;
use common\models\GoodsOpt;
use common\models\OptMst;
use common\models\GoodsPlan;
use common\models\PlanMst;
use common\models\BaseForm;
use common\models\ApplyTbl;
use yii\helpers\ArrayHelper;

/**
 *
 * @author
 */
class FormGoods extends BaseForm
{
    
    public $goods_jan;
    public $goods_name;
    public $goods_name2;
    public $goods_model_id;
    public $goods_sim_type;
    public $goods_sim_class;
    public $goods_color;
    public $goods_size;
    public $goods_maker;
    public $goods_decr;
    public $goods_last_upd_id;
    public $last_upd_date;
    public $plan_code;
    public $opt_packcode;
    public $opt_code;
    public $goods_jan_hidden;
    public $plan_name;
    public $opt_name;
    public $plan_code_left;
    public $plan_code_right;
    public $plan_code_button;
    public $opt_code_special;
    public $list_plan;
    public $list_option;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    
    public function fields()
    {
        return [
            'goods_jan', 'goods_name', 'goods_name2' , 'goods_model_id' , 'goods_sim_type' , 'goods_sim_class' ,
            'goods_color', 'goods_size', 'goods_maker', 'goods_decr', 'plan_code', 'opt_packcode', 'opt_code',
            'plan_name', 'opt_name', 'goods_last_upd_id', 'last_upd_date', 'plan_code_left', 'plan_code_right',
            'plan_code_button', 'opt_code_special', 'list_plan', 'list_option'
        ];
    }
    
    public function rules()
    {
        return [
            [['goods_jan', 'goods_name', 'goods_name2' , 'goods_model_id' , 'goods_sim_type' , 'goods_sim_class' ,
            'goods_color', 'goods_size', 'goods_maker', 'goods_decr', 'plan_code', 'opt_packcode', 'opt_code',
            'plan_name', 'opt_name', 'goods_last_upd_id', 'last_upd_date', 'plan_code_left', 'plan_code_right',
            'plan_code_button', 'opt_code_special'], 'safe'],
            [['goods_jan', 'goods_name'], 'required', 'message' => \Yii::t('app', 'required')],
            [['goods_jan'], 'validateGoodJan'],
            [['goods_model_id'], 'validateGoodModelId'],
            [['plan_code'], 'validatePlanCode'],
            [['opt_packcode'], 'validatePackCode'],
            [['opt_code', 'opt_code_special'], 'validateCode'],
            ['goods_sim_type', 'in', 'range' => array_keys(ApplyTbl::$LABEL_SIM_SIZE),
                'message' => \Yii::t('app', 'validation value goods sim'), 'allowArray' => true],
            ['goods_sim_class', 'in', 'range' => array_keys(ApplyTbl::$LABEL_SIM_TYPE),
                'message' => \Yii::t('app', 'validation value goods sim'), 'allowArray' => true],
            [['goods_jan'], 'string', 'max' => 13, 'tooLong' => \Yii::t('app', 'tring great than.', ['number' => 13])],
            [['goods_name', 'goods_name2'], 'string', 'max' => 256, 'tooLong' => \Yii::t('app', 'tring great than.', ['number' => 256])],
            [['goods_model_id'], 'string', 'max' => 100, 'tooLong' => \Yii::t('app', 'tring great than.', ['number' => 100])],
            [['goods_color', 'goods_size', 'goods_maker'], 'string', 'max' => 80, 'tooLong' => \Yii::t('app', 'tring great than.', ['number' => 80])],
            [['goods_jan'], 'validateGoodsJanAdd', 'on' => self::SCENARIO_ADD],
            [['goods_jan'], 'validateGoodsJanEdit', 'on' => self::SCENARIO_EDIT]
        ];
    }
    
    public function extraFields()
    {
        return ['goods_jan', 'goods_name', 'goods_name2' , 'goods_model_id' , 'goods_sim_type' , 'goods_sim_class' ,
            'goods_color', 'goods_size', 'goods_maker', 'goods_decr', 'plan_code', 'opt_packcode', 'opt_code',
            'plan_name', 'opt_name', 'goods_last_upd_id', 'last_upd_date', 'plan_code_left', 'plan_code_right',
            'plan_code_button', 'opt_code_special', 'list_plan', 'list_option'];
        
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_jan' => 'JANコード',
            'goods_name' => '商品名',
            'goods_name2' => '商品名２',
            'goods_model_id' => '機種ID',
            'goods_color' => 'カラー',
            'goods_size' => 'サイズ',
            'goods_maker' => 'メーカー名',
            'goods_sim_type' => 'SIMタイプ',
            'goods_sim_class' => 'SIM契約種別'
        ];
    }
    
    /*
     * Validate goods jan
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     */
    public function validateGoodJan($attribute)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $this->$attribute)) {
            $this->addError($attribute, \Yii::t('app', 'format jan', ['attribute' =>
                $this->attributeLabels()[$attribute]]));
        }
    }
    
    /*
     * Validate unique with add new record
     * 
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @date 22/03/2016
     */
    public function validateGoodsJanAdd($attribute)
    {
        $goodsMst = GoodsMst::findOne(['goods_jan' => $this->goods_jan]);
        if (!empty($goodsMst)) {
            $this->addError($attribute, \Yii::t('app', 'unique', ['attribute' =>
                $this->attributeLabels()[$attribute]]));
        }
    }
    
    /*
     * Validate unique with edit record
     * 
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @date 22/03/2016
     */
    public function validateGoodsJanEdit($attribute)
    {
        $goodsMst = GoodsMst::find()->where(['=', 'goods_jan', $this->goods_jan])
                ->andWhere(['!=', 'goods_jan', $this->goods_jan_hidden])->one();
        if (!empty($goodsMst)) {
            $this->addError($attribute, \Yii::t('app', 'unique', ['attribute' =>
                $this->attributeLabels()[$attribute]]));
        }
    }
    /*
     * Validate goods jan
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     */
    public function validateGoodModelId($attribute)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $this->$attribute) && !empty($this->$attribute)) {
            $this->addError($attribute, \Yii::t('app', 'format jan', ['attribute' =>
                $this->attributeLabels()[$attribute]]));
        }
    }
    
    /*
     * Validate opt pack_code
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @date 29/03/2016
     */
    
    public function validatePackCode($attribute)
    {
        if (!empty($this->$attribute)) {
            $optPack = OptMst::find()->where(['=', 'opt_packcode', $this->$attribute])
                    ->andWhere(['!=', 'opt_packcode', '000'])->one();
            
            if (!$optPack) {
                $this->$attribute = '';
                $this->addError($attribute, \Yii::t('app', 'validation value pack code'));
            }
        }
    }
    
    /*
     * Validate opt_code
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @date 29/03/2016
     */
    
    public function validateCode($attribute)
    {
        if (!empty($this->$attribute)) {
            $flag = true;
            foreach ($this->$attribute as $key => $value) {
                $optCode = OptMst::find()->where(['=', 'opt_packcode', '000'])
                    ->andWhere(['=', 'opt_code', $value])->one();
                if (empty($optCode)) {
                    $flag = false;
                    break;
                }
            }
            if (!$flag) {
                $this->addError($attribute, \Yii::t('app', 'validation value code'));
            }
        }
    }
    
    /*
     * Validate goods jan
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @date 29/03/2016
     */
    
    public function validatePlanCode($attribute)
    {
        if (!empty($this->$attribute)) {
            $flag = true;
            foreach ($this->$attribute as $key => $value) {
                $planId = PlanMst::findOne(['plan_code' => $value]);
                if (empty($planId)) {
                    $flag = false;
                    break;
                }
            }
            if (!$flag) {
                $this->addError($attribute, \Yii::t('app', 'validation value planid'));
            }
        }
    }
    
    /*
     * Get Detail goods
     * 
     * Auth Nguyen Van Hien <hiennv6244@gmail.com>
     * @Date 23/03/2016
     */
    public function getDetail($goodsJan)
    {
        $data = new FormGoods();
        $goodsOpt = new GoodsOpt();
        $goodsMst = new GoodsMst();
        $goodsPlan = new GoodsPlan();
        $optName = [];
        $goodsItem = $goodsMst->findOne(['goods_jan' => $goodsJan]);
        if (empty($goodsItem)) {
            return;
        }
        $data->setAttributes($goodsItem->toArray());
        $optPack = $goodsOpt->getListOpt($goodsJan);
        $planName = $goodsPlan->getPlanName($goodsJan);
        if (!empty($optPack)) {
            foreach ($optPack as $key => $value) {
                $listOptName = $goodsOpt->getOptName($value['opt_packcode'], $value['opt_code']);
                if (!empty($listOptName)) {
                    foreach ($listOptName as $key => $value) {
                        $optName[] = $value['opt_name'];
                    }
                }
            }
        }
        $data->opt_name = $optName;
        $data->plan_name = $planName;
        return $data;
    }
    
    /*
     * Render data from database
     * 
     * @Author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @Date : 22/03/2016
     */
    
    public function renderDataFromDb($goodsJan)
    {
        $data = new FormGoods();
        $opt = [];
        $optSpecial = [];
        if ($goodsJan) {
            $optMst = new OptMst();
            $goodsMst = goodsMst::findOne(['goods_jan' => $goodsJan]);
            if (empty($goodsMst)) {
                return;
            }
            $pland = GoodsPlan::find()->where(['goods_jan' => $goodsJan])->all();
            $listGoodsPlan = [];
            if ($pland) {
                foreach ($pland as $key => $value) {
                    $listGoodsPlan[] = $value->plan_code;
                }
            }
            $listOptMst = $optMst->getListOption($goodsJan);
            $listOption = $optMst->renderListOption($listOptMst);
            $data->setAttributes($goodsMst->toArray());
            $data->goods_jan_hidden = $goodsMst['goods_jan'];
            $listPlanLeft = [];
            $listPlanRight = [];
            $listPlanButton = [];
            if (count($listGoodsPlan) > 0) {
                foreach ($listGoodsPlan as $key => $value) {
                    if (in_array($value, PlanMst::$planCodeLeft)) {
                        $listPlanLeft[] =  $value;
                    } elseif (in_array($value, PlanMst::$planCodeRight)) {
                        $listPlanRight[] =  $value;
                    } else {
                        $listPlanButton[] =  $value;
                    }
                }
            }
            $data->plan_code = $listGoodsPlan;
            $data->plan_code_left = $listPlanLeft;
            $data->plan_code_right = $listPlanRight;
            $data->plan_code_button = $listPlanButton;
            //var_dump($listOption);die;
            foreach ($listOption as $key => $value) {
                if ($key !== '000' && $key !== 'special') {
                    $data->opt_packcode = $listOption[$key]['opt_packcode'];
                } else {
                    if ($key == '000' && count($listOption['000']['option_childrent']) > 0) {
                        foreach ($listOption['000']['option_childrent'] as $key1 => $value1) {
                            $opt[] = $key1;
                        }
                    }
                    if ($key == 'special' && count($listOption['special']['option_childrent']) > 0) {
                        foreach ($listOption['special']['option_childrent'] as $key2 => $value2) {
                            $optSpecial[] = $key2;
                        }
                    }
                }
            }
            $data->opt_code = $opt;
            $data->opt_code_special = $optSpecial;
        }
        return $data;
    }
    /*
     * Save data table goods_mst, goods_opt, goods_plan
     * 
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @Date : 22/03/2016
     */
    public function saveData($goodsJan)
    {
        //update or add data table goods_mst
        $goodsMst = new GoodsMst();
        $goodsOpt = new GoodsOpt();
        $goodsPlan = new GoodsPlan();
        $listPlanOld = GoodsPlan::find()->select('plan_code')->where(['goods_jan' => $goodsJan])->orderBy(['goods_plan_order' =>SORT_ASC])->column();
        $maxPlan = GoodsPlan::find()->where(['goods_jan' => $goodsJan])->max('goods_plan_order');
        $planRemove = array_diff($listPlanOld, $this->plan_code);
        $planAdd = array_values(array_diff($this->plan_code, $listPlanOld));
        if (isset($goodsJan) && $goodsJan != $this->goods_jan) {
            $planRemove = $listPlanOld;
            $planAdd = $this->plan_code;
        }
        $transaction = \yii::$app->getDb()->beginTransaction();
        try {
            //delete data table goods_opt and goods_plan whith old goods_jan
            if ($goodsJan) {
                //update table goods_mst
                $goodsMst = GoodsMst::findOne(['goods_jan' => $goodsJan]);
            }
            $goodsMst->setAttributes($this->toArray());
            $goodsMst->goods_last_upd_id = Yii::$app->user->getIdentity()->staff_id;
            $goodsMst->last_upd_date = date('Y-m-d H:i:s');
            $goodsMst->save();
            
            //update or add data table goods_opt
            $listOptPack = [];
            $packcodeOld = GoodsOpt::find()->where(['goods_opt_jan' => $goodsJan])->andWhere(['<>', 'goods_opt_packcode', '000'])->one();
            $listOpt = ($this->opt_code) ? $this->opt_code : [];
            $listOptSpecial = ($this->opt_code_special) ? $this->opt_code_special : [];
            if ($this->opt_packcode) {
                $listOptPack = OptMst::find()->select('opt_mst.*')->where(['opt_packcode' => $this->opt_packcode])->all();
            }
            if (!isset($goodsJan) || (!$packcodeOld && $this->opt_packcode) ||
                    ($packcodeOld && $packcodeOld->goods_opt_packcode != $this->opt_packcode) ||
                    (isset($goodsJan) && $goodsJan != $this->goods_jan)) {
                //case change opt_packcode or create new product
                //will deletes the old option
                //and will update and streamline the entire option
                $goodsOpt->deleteAll(['goods_opt_jan' => $goodsJan]);
                $listOptAdd = ($listOptPack) ? ArrayHelper::map($listOptPack, 'opt_code', 'opt_packcode') : [];
                $listOpt = array_merge($listOpt, $listOptSpecial);
                $listOptNew = [];
                if (count($listOpt) > 0) {
                    foreach ($listOpt as $key => $value) {
                        $listOptNew[$value] = '000';
                    }
                }
                $i = 0;
                //new array to update the key value option opt_code, opt_packcode
                $listOptAdd = array_merge($listOptAdd, $listOptNew);
                if (count($listOptAdd) > 0) {
                    foreach ($listOptAdd as $key => $value) {
                            $i ++;
                            $goodsOptSave = new GoodsOpt();
                            $goodsOptSave->goods_opt_jan = $this->goods_jan;
                            $goodsOptSave->goods_opt_packcode = $value;
                            $goodsOptSave->goods_opt_code = $key;
                            $goodsOptSave->goods_opt_order = $i;
                            $goodsOptSave->goods_opt_last_upd_user = Yii::$app->user->getIdentity()->staff_id;
                            $goodsOptSave->goods_opt_last_upd_date = date('Y-m-d H:i:s');
                            $goodsOptSave->save();
                    }
                }
            } else {
                //case edit product and unchanged opt_packcode
                //create array option add and option remove
                $maxOption = GoodsOpt::find()->where(['goods_opt_jan' => $goodsJan])->max('goods_opt_order');
                if ($this->opt_packcode) {// case opt_packcode != 000
                    //check the change in the value table opt_mst goods_opt table
                    $pack = $this->opt_packcode;
                    $listMst = OptMst::find()->select('opt_code')->where(['opt_packcode' => $this->opt_packcode])->column();
                    $listOptOld = GoodsOpt::find()->select('goods_opt_code')->where(['goods_opt_packcode' => $this->opt_packcode, 'goods_opt_jan' => $goodsJan])->column();
                    $listOptAdd = array_diff($listMst, $listOptOld);
                    $listOptRemove = array_diff($listOptOld, $listMst);
                } else {
                    $pack = '000';
                    $listOptOld = GoodsOpt::getListOption($goodsJan);
                    $listOptAdd = array_diff($listOpt, $listOptOld);
                    $listOptRemove = array_diff($listOptOld, $listOpt);
                }
                
                //create array option add and option remove of option special
                $listOptOldSpecial = GoodsOpt::getListOption($goodsJan, false);
                $listOptAddSpecial = array_diff($listOptSpecial, $listOptOldSpecial);
                $listOptRemoveSpecial = array_diff($listOptOldSpecial, $listOptSpecial);
                //remove option and option special
                if (count($listOptRemove) > 0) {
                    foreach ($listOptRemove as $key => $value) {
                        $goodsOpt->deleteAll(['goods_opt_jan' => $goodsJan, 'goods_opt_packcode' => $pack, 'goods_opt_code' => $value]);
                    }
                }
                 if (count($listOptRemoveSpecial) > 0) {
                    foreach ($listOptRemoveSpecial as $key => $value) {
                        $goodsOpt->deleteAll(['goods_opt_jan' => $goodsJan, 'goods_opt_packcode' => '000', 'goods_opt_code' => $value]);
                    }
                } 
                //add option
                $i = 0;
                if (count($listOptAdd) > 0) {
                    foreach ($listOptAdd as $key => $value) {
                        $i ++;
                        $goodsOptSave = new GoodsOpt();
                        $goodsOptSave->goods_opt_jan = $this->goods_jan;
                        $goodsOptSave->goods_opt_packcode = $pack;
                        $goodsOptSave->goods_opt_code = $value;
                        $goodsOptSave->goods_opt_order = $maxOption + $i;
                        $goodsOptSave->goods_opt_last_upd_user = Yii::$app->user->getIdentity()->staff_id;
                        $goodsOptSave->goods_opt_last_upd_date = date('Y-m-d H:i:s');
                        $goodsOptSave->save();
                    }
                }
                if (count($listOptAddSpecial) > 0) {
                    foreach ($listOptAddSpecial as $key => $value) {
                        $i ++;
                        $goodsOptSave = new GoodsOpt();
                        $goodsOptSave->goods_opt_jan = $this->goods_jan;
                        $goodsOptSave->goods_opt_packcode = '000';
                        $goodsOptSave->goods_opt_code = $value;
                        $goodsOptSave->goods_opt_order = $maxOption + $i;
                        $goodsOptSave->goods_opt_last_upd_user = Yii::$app->user->getIdentity()->staff_id;
                        $goodsOptSave->goods_opt_last_upd_date = date('Y-m-d H:i:s');
                        $goodsOptSave->save();
                    }
                }
            }
            //update or add data table goods_plan
            if (count($planAdd) > 0) {
                foreach ($planAdd as $key => $value) {
                    $goodsPlanSave = new GoodsPlan();
                    $goodsPlanSave->goods_jan = $this->goods_jan;
                    $goodsPlanSave->plan_code = $value;
                    $goodsPlanSave->goods_plan_order = $key + $maxPlan + 1;
                    $goodsPlanSave->good_plan_last_upd_user = Yii::$app->user->getIdentity()->staff_id;
                    $goodsPlanSave->good_plan_last_upd_date = date('Y-m-d H:i:s');
                    $goodsPlanSave->save();
                }
            }
            if (count($planRemove) > 0) {
                foreach ($planRemove as $key => $value) {
                    $goodsPlan->deleteAll(['goods_jan' => $goodsJan, 'plan_code' => $value]);
                }
            }
            $transaction->commit();
        } catch (Exception $ex) {
            $transaction->rollBack();
            Yii::error($ex->getMessage());
        }
        
        return true;
    }
    
    /*
     * Delete product
     * 
     * @author Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
     * @Date : 13/06/2016
     */
    
    public function deleteProduct($goodsJan)
    {
        $transaction = \yii::$app->getDb()->beginTransaction();
        try {
            $goodsMst = new GoodsMst();
            $goodsOpt = new GoodsOpt();
            $goodsPlan = new GoodsPlan();
            $goodsMst->deleteAll(['goods_jan' => $goodsJan]);
            $goodsOpt->deleteAll(['goods_opt_jan' => $goodsJan]);
            $goodsPlan->deleteAll(['goods_jan' => $goodsJan]);
            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            Yii::error($ex->getMessage());
            return false;
        }
    }
    /**
    * Action validate drop
    *
    * @date : 21/07/2016
    * @author : Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
    *
    */
    
    public function validateDrop()
    {
        $plan = (isset($this->list_plan)) ? $this->list_plan : '';
        $flag = true;
        $goodsOpt = new GoodsOpt();
        $goodsPlan = new GoodsPlan();
        //sum the option does not exist in pots up value
        $countOpt = ($this->list_option) ? $goodsOpt->countOption($this->list_option, $this->goods_jan) : 0;
        //sum the plan does not exist in pots up value
        $countPlan = ($plan) ? $goodsPlan->countPlan($plan, $this->goods_jan) : 0;
        //get total option new
        $optionNew = GoodsOpt::find()->where(['goods_opt_jan' => $this->goods_jan])->count();
        //get total plan new
        $planNew = GoodsPlan::find()->where(['goods_jan' => $this->goods_jan])->count();
        $countPlanOld = ($plan) ? count(explode(',', $plan)) : 0;
        $countOptOld = ($this->list_option) ?  count(explode('),', $this->list_option)) : 0;
        // Other cases have the option value post
        // Other cases have the plan value post
        // case of option value changes
        //case of plan value changes
        if ($countPlanOld != $planNew || $countOptOld != $optionNew || $countOpt != 0 || $countPlan != 0) {
            $flag = false;
            return $flag;
        }
        return $flag;
    }
    
    /**
    * Action save drop
    *
    * @date : 21/07/2016
    * @author : Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
    *
    */
    public function saveDrop()
    {
        $plan = (isset($this->list_plan)) ? $this->list_plan : '';
        $transaction = \yii::$app->getDb()->beginTransaction();
        try {
            //conver plan string to array
            //input '0704000006','0704000111' ---> output ['0704000006', '0704000111']
            $listPlan = ($plan) ?  explode(',', $plan) : [];
            //conver option string to array
            //input '('001','001'),('001','004')' ---> output ['(001;001)', '(001;004)']
            $option = str_replace("','", ";", $this->list_option);
            $option = str_replace("'", "", $option);
            $listOption = ($option) ? explode(',', $option) : [];
            //update plan_order
            if (count($listPlan) > 0) {
                foreach ($listPlan as $key => $value) {
                    $value = str_replace("'", "", $value);
                    $goodsPlan = new GoodsPlan();
                    $goodsPlan->updateAll(['goods_plan_order' => ($key + 1)],
                            ['goods_jan' => $this->goods_jan, 'plan_code' => $value]);
                }
            }
            //update opt_order
            if (count($listOption) > 0) {
                foreach ($listOption as $key => $value) {
                    $value = str_replace(["(", ")"], "", $value);
                    $value = explode(";", $value);
                    $goodsOpt = new GoodsOpt();
                    $goodsOpt->updateAll(['goods_opt_order' => ($key + 1)],
                            ['goods_opt_jan' => $this->goods_jan, 'goods_opt_packcode' => $value[0],
                                'goods_opt_code' => $value[1]]);
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $ex) {
            $transaction->rollBack();
            Yii::error($ex->getMessage());
            return false;
        }
    }
}
