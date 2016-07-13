<?php

return [

    'username' => env('ERP_USERNAME', 'WSGW'),
    'password' => env('ERP_PASSWORD', 'PEOP2987WS'),
    'products_price_list' => env('ERP_PRODUCTS_PRICE_LIST', 'EMVNTV'),

    'wsdl' => [

        'products' => [
            'get_products' => env('ERP_WSDL_GET_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOS?wsdl'),
            'get_new_products' => env('ERP_WSDL_GET_NEW_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSNOVOS?wsdl'),
            'get_current_products' => env('ERP_WSDL_GET_CURRENT_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSATUAIS?wsdl'),
            'get_changed_products' => env('ERP_WSDL_GET_CHANGED_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSALTERADOS?wsdl'),
            'get_stock' => env('ERP_WSDL_GET_PRODUCTS_STOCK', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/CONSULTASALDOESTOQUE?wsdl')
        ],

        'customers' => [
            'get_customer' => env('ERP_WSDL_GET_CUSTOMER', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETCLIENTE?wsdl'),
            'create_customer' => env('ERP_WSDL_CREATE_CUSTOMER', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/CRIAPESSOA?wsdl'),
            'get_shipping_address' => env('ERP_WSDL_GET_SHIPPING_ADDRESS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETENDERENTREGACLIENTE?wsdl'),
            'update_shipping_address' => env('ERP_WSDL_UPDATE_SHIPPING_ADDRESS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/ATUALIZAENDERENTREGACLIENTE?wsdl'),
        ],

        'orders' => [
            'create_order' => env('ERP_WSDL_CREATE_ORDER', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/CRIAPEDIDO?wsdl'),
            'create_order_item' => env('ERP_WSDL_CREATE_ORDER_ITEM', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/CRIAPEDIDOITEM?wsdl'),
            'get_order_status' => env('ERP_WSDL_GET_ORDER_STATUS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETSTATUSPEDIDO?wsdl'),
        ]

    ]

];