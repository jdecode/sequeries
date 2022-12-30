@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!!
        $attributes->merge(
            [
                'class' => '
                    bg-gray-100 dark:bg-gray-800
                    rounded-md shadow-sm
                    border-gray-500 focus:border-dev-500
                    focus:ring-dev-500 focus:ring-opacity-50
                '
            ]
        )
    !!}
    />
