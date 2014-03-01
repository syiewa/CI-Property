<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getOptions($key) {
    $CI = & get_instance();
    $CI->load->model('m_options');
    $setting = $CI->m_options->get_by(array('name_option' => $key));
    return $setting->value;
}

function currency($number) {
    return number_format($number);
}

function _toaktif($url = null, $id = null, $str = 0) {
    $im = "";
    if ($str == "0") {
        $im = '<a id="activate' . $id . '" href = ' . site_url($url . '/' . $id . '/1') . ' class="btn btn-default btn-warning">No Primary</a>';
    } elseif ($str == "1") {
        $im = '<a id="activate' . $id . '" href = ' . site_url($url . '/' . $id . '/0') . ' class="btn btn-default btn-success">Primary</a>';
    }
    return $im;
}

function limit_to_numwords($string, $numwords) {
    $excerpt = explode(' ', $string, $numwords + 1);
    if (count($excerpt) >= $numwords) {
        array_pop($excerpt);
    }
    $excerpt = implode(' ', $excerpt);
    return $excerpt;
}

?>
