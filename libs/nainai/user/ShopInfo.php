<?php
namespace nainai\user;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

/**
 * 用户对应的api
 * @author maoyong.zeng
 * @copyright 2016年05月30日
 */
class ShopInfo extends \nainai\Abstruct\ModelAbstract {

     public $pk = 'company_id';
     
     protected $Rules = array(
         array('products','require','必须填写主打产品'),
         array('tel', '/^[0-9\-]{6,15}$/','必须填写电话')
     );

     public function insertShopInfo(&$shopInfo, $qaData = array(), $imData = array()){
             $res = $this->getShopInfo($shopInfo['company_id'], 'company_id');
             if (!empty($res)) {
                    $company_id = $shopInfo['company_id'];
                    unset($shopInfo['company_id']);
                    $res = $this->updateShopInfo($shopInfo, $company_id);
             }else{
                    $res = $this->addShopInfo($shopInfo);
                    $company_id = $res['info'];
             }

             if (!empty($qaData) OR !empty($imData)) {
                         $photos = array();
                         $photosModel = new \nainai\user\ShopPhotos();
                        foreach ($qaData as $value) {
                            $photos[] = array('company_id' => $company_id, 'img_url' => \Library\tool::setImgApp($value), 'type' => $photosModel::SHOPQA);
                        }
                        foreach ($imData as $value) {
                             $photos[] = array('company_id' => $company_id, 'img_url' => \Library\tool::setImgApp($value), 'type' => $photosModel::SHOPIM);
                        }

                        $res = $photosModel->addsShopPhotos($photos);
             }
             return $res;
     }

}