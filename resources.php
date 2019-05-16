<?php
/**
 * Define resources attributes and relations
 */

return [
    'contacts' => [
        'attributes' => [
          'firstname',
          'surname'
        ],
        'hasMany' => [
          'emails',
          'phones'
        ]
    ],
    'emails' => [
        'attributes' => [
            'email'
        ],
        'belongsTo' => [
          'contacts'
        ]
    ],
    'phones' => [
      'attributes' => [
          'number'
      ],
      'belongsTo' => [
        'contacts'
      ]
  ]
];