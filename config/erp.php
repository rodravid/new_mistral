<?php

return [

    'username' => env('ERP_USERNAME', 'WSGW'),
    'password' => env('ERP_PASSWORD', 'PEOP2987WS'),

    'wsdl' => [

        'products' => [
            'get_products' => env('ERP_WSDL_GET_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOS?wsdl'),
            'get_new_products' => env('ERP_WSDL_GET_NEW_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSNOVOS?wsdl'),
            'get_current_products' => env('ERP_WSDL_GET_CURRENT_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSATUAIS?wsdl'),
            'get_changed_products' => env('ERP_WSDL_GET_CHANGED_PRODUCTS', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/GETPRODUTOSALTERADOS?wsdl'),
            'get_stock' => env('ERP_WSDL_GET_PRODUCTS_STOCK', 'http://amz1.gestaoweb.com.br:18080/orawsv/WSGW/CONSULTASALDOESTOQUE?wsdl')
        ]

    ]

];