<?php

return [

    'username' => env('ERP_USERNAME', 'WSGW'),
    'password' => env('ERP_PASSWORD', 'PEOP2987WS'),
    'products_price_list' => env('ERP_PRODUCTS_PRICE_LIST', 'EMVNTV'),

    'wsdl' => [

        'products' => [
            'get_products' => env('ERP_WSDL_GET_PRODUCTS'),
            'get_new_products' => env('ERP_WSDL_GET_NEW_PRODUCTS'),
            'get_current_products' => env('ERP_WSDL_GET_CURRENT_PRODUCTS'),
            'get_changed_products' => env('ERP_WSDL_GET_CHANGED_PRODUCTS'),
            'get_stock' => env('ERP_WSDL_GET_PRODUCTS_STOCK')
        ],

        'customers' => [
            'get_customer' => env('ERP_WSDL_GET_CUSTOMER'),
            'create_customer' => env('ERP_WSDL_CREATE_CUSTOMER'),
            'get_shipping_address' => env('ERP_WSDL_GET_SHIPPING_ADDRESS'),
            'update_shipping_address' => env('ERP_WSDL_UPDATE_SHIPPING_ADDRESS'),
        ],

        'orders' => [
            'create_order' => env('ERP_WSDL_CREATE_ORDER'),
            'create_order_item' => env('ERP_WSDL_CREATE_ORDER_ITEM'),
            'get_order_status' => env('ERP_WSDL_GET_ORDER_STATUS'),
        ],

        'states' => [
            'get_states' => env('ERP_WSDL_GET_STATES')
        ],

        'cities' => [
            'get_cities' => env('ERP_WSDL_GET_CITIES')
        ]

    ]

];