<?php
namespace nainai\offer;

use \Library\M;
use \Library\Query;
use \Library\Tool;

class ProductSetting extends \nainai\Abstruct\ModelAbstract{

	protected $Rules = array(
	        array('time','require','必须填写发布时间比例设置'),
	        array('credit','require','必须填写信誉值比例设置')
	    );

}