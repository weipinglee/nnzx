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
class ShopPhotos extends \nainai\Abstruct\ModelAbstract {
     
     const SHOPQA = 1;
     const SHOPIM = 2;

     public function getType($type){
          switch ($type) {
               case self::SHOPQA:
                    return '商户资质';
               case self::SHOPIM:
                    return '商户形象';
               default:
                    return '未知';
          }
     }

     public function getPhotosLists($company_id){
          $lists = array('qa' => array(), 'im' => array());

          if (intval($company_id) > 0) {
               $photos = $this->model->where(array('company_id' => $company_id))->select();
               foreach ($photos as &$list) {
                    $list['img_url'] = \Library\Thumb::get($list['img_url'], 180, 180);
                    if ($list['type'] == self::SHOPQA) {
                         $lists['qa'][] = $list;
                    }else{
                         $lists['im'][] = $list;
                    }
               }
          }
          return $lists;
     }

}