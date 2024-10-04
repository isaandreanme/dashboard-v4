<?php

return [

    'audits_sort' => [
        'column' => 'created_at',
        'direction' => 'desc',
    ],

    'is_lazy' => true,

    /**
     *  Extending Columns
     * --------------------------------------------------------------------------
     *  In case you need to add a column to the AuditsRelationManager that does
     *  not already exist in the table, you can add it here, and it will be
     *  prepended to the table builder.
     */
    'audits_extend' => [
        'url' => [
            'class' => \Filament\Tables\Columns\TextColumn::class,
            'methods' => [
                'sortable',
                'searchable' => true,
                'default' => 'N/A'
            ]
        ],
    ],

    'custom_audits_view' => false,

    'custom_view_parameters' => [
    ],

    'mapping' => [
        'user_id' => [
            'model' => App\Models\User::class,
            'field' => 'name',
            'label' => 'User',
        ],
        'status_id' => [
            'model' => App\Models\Status::class,
            'field' => 'nama',
            'label' => 'Status',
        ],
        'tujuan_id' => [
            'model' => App\Models\Tujuan::class,
            'field' => 'nama',
            'label' => 'Tujuan',
        ],
        'kantor_id' => [
            'model' => App\Models\Kantor::class,
            'field' => 'nama',
            'label' => 'Tujuan',
        ],
        'sponsor_id' => [
            'model' => App\Models\Sponsor::class,
            'field' => 'nama',
            'label' => 'Tujuan',
        ],
        'pengalaman_id' => [
            'model' => App\Models\Pengalaman::class,
            'field' => 'nama',
            'label' => 'Tujuan',
        ],
    ],

];
