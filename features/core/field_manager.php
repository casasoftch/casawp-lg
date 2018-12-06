<?php
namespace casasoft\casawplg;

class field_manager extends Feature {

	public function __construct() {
	}

	public function getInquiryDefaults(){
		return array(
			'first_name' => '',
			'last_name' => '',
			'email' => '',
			'mobile' => '',
			'message' => '',
			'gender' => 'female',
		);
	}

	public function getInquiryItems($inquiry = false, $specials = true){
		$prefix = '_casawplg_inquiry_';
		$metas = array();
		if ($inquiry) {
			foreach (get_post_meta($inquiry->ID) as $le_key => $le_value) {
				if (strpos($le_key, $prefix) === 0) {
					$metas[str_replace($prefix, '', $le_key)] = $le_value[0];
				}
			}
		}
		$metas = array_merge($this->getInquiryDefaults(), $metas);

		$datas = array(
			'first_name' => array(
				'label' => __('First name', 'casawplg'),
				'value' => $metas['first_name']
			),
			'last_name' => array(
				'label' => __('Last name', 'casawplg'),
				'value' => $metas['last_name']
			),
			'mobile' => array(
				'label' => __('Mobile', 'casawplg'),
				'value' => $metas['mobile']
			),
			'email' => array(
				'label' => __('Email', 'casawplg'),
				'value' => $metas['email']
			),
			'message' => array(
				'label' => __('Message', 'casawplg'),
				'value' => $metas['message']
			),
			'gender' => array(
				'label' => __('Gender', 'casawplg'),
				'value' => $metas['gender']
			),
		);

		return $datas;

	}

	public function getInquiryItem($inquiry, $key){
		$datas = $this->getInquiryItems($inquiry);

		if (isset($datas[$key])) {
			return $datas[$key];
		}
		return false;
	}

	public function getInquiryField($inquiry = false, $key, $label = false){
		$item = $this->getInquiryItem($inquiry, $key);
		if ($item) {
			if ($label) {
				return $item['label'];
			} else {
				return $item['value'];	
			}
		}
		return '';
	}

	public function getUnitDefaults(){
		return array(


		);
	}

}