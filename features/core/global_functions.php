<?php

function get_clg($object_id = false, $key = false, $label = false, $type = false){
	$fm = new \casasoft\casawplg\field_manager;
	$post = false;
	if ($object_id) {
		$post = get_post($object_id);
		if ($post) {
			$type = $post->post_type;
		} else {
			return '';
		}

	}

	if ($type == 'casawplg_inquiry') {
		return $fm->getInquiryField($post, $key, $label);
	}
	return '';
}

function get_clg_item($object_id = false, $key = false, $type = false){
    $fm = new \casasoft\casawplg\field_manager;
    $post = false;
    if ($object_id) {
        $post = get_post($object_id);
        if ($post) {
            $type = $post->post_type;
        } else {
            return '';
        }

    }

    if ($type == 'casawplg_inquiry') {
        return $fm->getInquiryItem($post, $key);
    }
    return '';
}

function get_clg_label($object_id, $key, $type = false){
	return get_clg($object_id, $key, true, $type);
}

function get_default_clg($type, $specials = true){
	$fm = new \casasoft\casawplg\field_manager;
	if ($type == 'inquiry') {
		return $fm->getInquiryItems(false, $specials);
	}
	return array();
}



