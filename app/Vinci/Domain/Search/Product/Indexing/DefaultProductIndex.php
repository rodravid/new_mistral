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
                        'filter' => [
                            'autocomplete_filter' => [
                                'type' => 'edge_ngram',
                                'min_gram' => 3,
                                'max_gram' => 4
                            ]
                        ],
                        'analyzer' => [
                            'analyzer_keyword' => [
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'asciifolding']
                            ],
                            'autocomplete' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'asciifolding', 'autocomplete_filter']
                            ],
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
                            //'analyzer' => 'analyzer_keyword',
                            'fields' => [
                                'raw' => [
                                    'type' => 'string',
                                    'index' => 'not_analyzed'
                                ],
                                'lowercase' => [
                                    'type' => 'string',
                                    'analyzer' => 'analyzer_keyword',
                                ],
                                'autocomplete' => [
                                    'type' => 'string',
                                    'analyzer' => 'autocomplete'
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
                        'relevance' => [
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
                                    //'analyzer' => 'brazilian',
                                    'fields' => [
                                        'brazilian' => [
                                            'type' => 'string',
                                            'analyzer' => 'brazilian'
                                        ],
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
                            'analyzer' => 'simple',
                            'search_analyzer' => 'simple',
                            'payloads' => true,
                        ]
                    ]
                ]
            ]
        ];
    }
}