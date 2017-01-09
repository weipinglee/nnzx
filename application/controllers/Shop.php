<?php

use \tool\http;
use \Library\url;
use \Library\safe;
use \Library\tool;
use \nainai\order\Order;
use \Library\checkRight;


use \nainai\offer\product;

use \Library\JSON;

class ShopController extends PublicController {

     public function shopInfoAction(){
          $this->user_id = 48;
               $shopModel = new \nainai\user\ShopInfo();
               $shopData = $shopModel->getShopInfo($this->user_id);
               $shopData['logo_url'] = \Library\Thumb::get($shopData['logo_url'], 180, 180);
               $shopData['map_url'] = \Library\Thumb::get($shopData['map_url'], 180, 180);
               $companyModel = new \nainai\user\CompanyInfo();
               $companyInfo = $companyModel->getCompanyInfo($this->user_id);
               $photoModel = new \nainai\user\ShopPhotos();
               $photosList = $photoModel->getPhotosLists($this->user_id);

               $this->getView()->assign('shopData',$shopData);
               $this->getView()->assign('companyInfo',$companyInfo);
               $this->getView()->assign('photosList',$photosList);
     }

}