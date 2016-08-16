<?php

namespace Vinci\Domain\Search\Product\Indexing;

use Vinci\Domain\Search\Indexing\AbstractIndex;

class DefaultProductIndex extends AbstractIndex
{

    public function getName()
    {
        return 'vinci';
    }

    protected function getConfiguration()
    {
        return [
            'settings' => [
                'index' => [
                    'analysis' => [
                        'analyzer' => [
                            'analyzer_keyword' => [
                                'tokenizer' => 'standard',
                                'filter' => 'lowercase'
                            ]
                        ]
                    ]
                ]
            ],
            'mappings' => [
                'product' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer'
                        ],
                        'sku' => [
                            'type' => 'string'
                        ],
                        'title' => [
                            'type' => 'string',
                            'analyzer' => 'analyzer_keyword',
                            'fields' => [
                                'raw' => [
                                    'type' => 'string',
                                    'index' => 'not_analyzed'
                                ]
                            ]
                        ],
                        'description' => [
                            'type' => 'string',
                            'analyzer' => 'analyzer_keyword'
                        ],
                        'short_description' => [
                            'type' => 'string',
                            'analyzer' => 'analyzer_keyword'
                        ],
                        'price' => [
                            'type' => 'double'
                        ],
                        'available' => [
                            'type' => 'integer'
                        ],
                        'bottle_size' => [
                            'type' => 'string',
                            'analyzer' => 'analyzer_keyword',
                            'fields' => [
                                'raw' => [
                                    'type' => 'string',
                                    'index' => 'not_analyzed'
                                ]
                            ]
                        ],
                        'country' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer'
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                    'fields' => [
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                            ],
                        ],
                        'region' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer'
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                    'fields' => [
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ]
                            ],
                        ],
                        'producer' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer'
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                    'fields' => [
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ]
                            ],
                        ],
                        'product_type' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer'
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                    'fields' => [
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ]
                            ],
                        ],
                        'grapes' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer'
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                    'fields' => [
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                                'weight' => [
                                    'type' => 'double'
                                ]
                            ],
                        ],
                        'suggest' => [
                            'type' => 'completion',
                            'index_analyzer' => 'simple',
                            'search_analyzer' => 'simple',
                            'payloads' => true,
                        ]
                    ]
                ]
            ]
        ];
    }
}