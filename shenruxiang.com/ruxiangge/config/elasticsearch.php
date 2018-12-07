<?php
    return [
        'book_mappings' => [
            'index' => 'book',
            'body' => [
                'settings' => [
                    'number_of_shards'   => 4,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    'book' => [
                        'properties' => [
                            'book_name' => [
                                'type' => 'text',
                                'store' => 'true',
                                'index' => 'true',
                                'term_vector' => 'with_positions_offsets',
                                'analyzer' => 'ik_max_word',
                                'search_analyzer' => 'ik_max_word',
                            ],
                            'book_cover' => [
                                'type' => 'text'
                            ],
                            'author_name' => [
                                'type' => 'text'
                            ],
                            'cate_name' => [
                                'type' => 'text'
                            ],
                            'book_word_count' => [
                                'type' => 'text'
                            ],
                            'update_time' => [
                                'type' => 'text'
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ];
?>