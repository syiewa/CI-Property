<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$config = array(
    'places' => array(
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
    ),
    'details' => array(
        array(
            'field' => 'prices',
            'label' => 'Prices',
            'rules' => 'trim|required|xss_clean|numeric|strip_tags'
        ),
        array(
            'field' => 'year_built',
            'label' => 'Year Built',
            'rules' => 'trim|required|xss_clean|numeric|strip_tags'
        ),
        array(
            'field' => 'lot_dim',
            'label' => 'Lot Dimension',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'floor_dim',
            'label' => 'Floor Dimension',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'bedrooms',
            'label' => 'Bedrooms',
            'rules' => 'trim|required|xss_clean|numeric|strip_tags'
        ),
        array(
            'field' => 'bathrooms',
            'label' => 'Bathrooms',
            'rules' => 'trim|required|xss_clean|numeric|strip_tags'
        ),
        array(
            'field' => 'desc',
            'label' => 'Description',
            'rules' => 'trim|xss_clean'
        ),
    ),
    'maps' => array(
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'town',
            'label' => 'Town',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'province',
            'label' => 'Province',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'country',
            'label' => 'Country',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'coord',
            'label' => 'Coordinate',
            'rules' => 'trim|xss_clean'
        ),
    ),
    'owner' => array(
        array(
            'field' => 'name_owner',
            'label' => 'Name Owner',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'email_owner',
            'label' => 'Email Owner',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'adds_owner',
            'label' => 'Address Owner',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'telp_owner',
            'label' => 'Telephone Owner',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
        array(
            'field' => 'mob_owner',
            'label' => 'Mobile Owner',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
    ),
    'type' => array(
        array(
            'field' => 'title_type',
            'label' => 'Title Type',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
    ),
    'feature' => array(
        array(
            'field' => 'title_features',
            'label' => 'Title features',
            'rules' => 'trim|required|xss_clean|strip_tags'
        ),
    ),
    'search' => array(
        array(
            'field' => 'title_s',
            'label' => 'Title Search',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'minbed',
            'label' => 'Min Bedrooms',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'maxbed',
            'label' => 'Max Bedrooms',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'minbath',
            'label' => 'Min Bathrooms',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'maxbath',
            'label' => 'Max Bathrooms',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'minprice',
            'label' => 'Min Price',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'maxprice',
            'label' => 'Max Price',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'minfloor',
            'label' => 'Min Floor',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
        array(
            'field' => 'maxfloor',
            'label' => 'Max Floor',
            'rules' => 'trim|xss_clean|strip_tags'
        ),
    ),
);
?>
