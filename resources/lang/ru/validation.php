<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'              => 'Вы должны принять :attribute.',
    'active_url'            => 'Поле :attribute содержит недействительный URL.',
    'after'                 => 'В поле :attribute должна быть дата после :date.',
    'after_or_equal'        => 'В поле :attribute должна быть дата после или равной дате :date.',
    'alpha'                 => 'Поле :attribute может содержать только буквы.',
    'alpha_dash'            => 'Поле :attribute может содержать только буквы, цифры и дефис.',
    'alpha_num'             => 'Поле :attribute может содержать только буквы и цифры.',
    'array'                 => 'Поле :attribute должно быть массивом.',
    'before'                => 'В поле :attribute должна быть дата до :date.',
    'before_or_equal'       => 'В поле :attribute должна быть дата до или равной дате :date.',
    'between' => [
        'numeric'   => 'Поле :attribute должно быть между :min и :max.',
        'file'      => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
        'string'    => 'Количество символов в поле :attribute должно быть между :min и :max.',
        'array'     => 'Количество элементов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean'               => 'Поле :attribute должно иметь значение логического типа.',
    'confirmed'             => 'Поле :attribute не    совпадает с подтверждением.',
    'date'                  => 'Поле :attribute не является датой.',
    'date_equals'           => ':attribute должен быть датой, равной :date.',
    'date_format'           => 'Поле :attribute не соответствует формату :format.',
    'different'             => 'Поля :attribute и :other должны различаться.',
    'digits'                => 'Длина цифрового поля :attribute должна быть :digits.',
    'digits_between'        => 'Длина цифрового поля :attribute должна быть между :min и :max.',
    'dimensions'            => ':attribute имеет недопустимые размеры изображения.',
    'distinct'              => ':attribute имеет повторяющееся значение.',
    'email'                 => 'Поле :attribute должно быть действительным электронным адресом.',
    'ends_with'             => ':attribute должен заканчиваться одним из следующих :values.',
    'exists'                => 'Выбранное значение для :attribute некорректно.',
    'file'                  => ':attribute должен быть файлом',
    'filled'                => 'Поле :attribute обязательно для заполнения.',
    'gt' => [
        'numeric'   => ':attribute должен быть больше, чем :value.',
        'file'      => ':attribute должен быть больше, чем значение :value Килобайт(а).',
        'string'    => ':attribute должен содержать больше символов :value.',
        'array'     => ':attribute должен содержать более :value элементов.',
    ],
    'gte' => [
        'numeric'   => ':attribute должен быть больше или равен :value.',
        'file'      => ':attribute должно быть больше или равно :value Килобайт(а).',
        'string'    => 'Символы :attribute должен быть больше или равен :value.',
        'array'     => ':attribute должен иметь элементы :value или больше.',
    ],
    'image'                 => 'Поле :attribute должно быть изображением.',
    'in'                    => 'Выбранное значение для :attribute ошибочно.',
    'in_array'              => ':attribute не существует в :other.',
    'integer'               => 'Поле :attribute должно быть целым числом.',
    'ip'                    => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4'                  => ':attribute должен быть действительным адресом IPv4.',
    'ipv6'                  => ':attribute должен быть действительным адресом IPv6.',
    'json'                  => 'Поле :attribute должно быть JSON строкой.',
    'lt' => [
        'numeric'   => ':attribute должен быть меньше :value.',
        'file'      => ':attribute должен быть меньше :value Килобайт(а).',
        'string'    => ':attribute должен содержать меньше символов :value.',
        'array'     => ':attribute должен содержать меньше :value элементов.',
    ],
    'lte' => [
        'numeric'   => ':attribute должен быть меньше или равен :value.',
        'file'      => ':attribute должен быть меньше или равен :value Килобайт(а).',
        'string'    => ':attribute должен быть меньше или равен символам :value.',
        'array'     => ':attribute не может содержать более :value элементов.',
    ],
    'max' => [
        'numeric'   => 'Поле :attribute не может быть более :max.',
        'file'      => 'Размер файла в поле :attribute не может быть более :max Килобайт(а).',
        'string'    => 'Количество символов в поле :attribute не может превышать :max.',
        'array'     => 'Количество элементов в поле :attribute не может превышать :max.',
    ],
    'mimes'                 => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'mimetypes'             => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'numeric'   => 'Поле :attribute должно быть не менее :min.',
        'file'      => 'Размер файла в поле :attribute должен быть не менее :min Килобайт(а).',
        'string'    => 'Количество символов в поле :attribute должно быть не менее :min.',
        'array'     => 'Количество элементов в поле :attribute должно быть не менее :min.',
    ],
    'multiple_of'           => ':attribute должен быть кратным :value',
    'not_in'                => 'Выбранное значение для :attribute ошибочно.',
    'not_regex'             => 'Не верный фотмат :attribute',
    'numeric'               => 'Поле :attribute должно быть числом.',
    'password'              => 'Пароль неверен.',
    'present'               => ':attribute должно присутствовать.',
    'regex'                 => 'Поле :attribute имеет ошибочный формат.',
    'required'              => 'Поле :attribute обязательно для заполнения.',
    'required_if'           => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
    'required_unless'       => 'Поле :attribute обязательно для заполнения, когда :other не равно :values.',
    'required_with'         => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_with_all'     => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_without'      => 'Поле :attribute обязательно для заполнения, когда :values не указано.',
    'required_without_all'  => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
    'same'                  => 'Значение :attribute должно совпадать с :other.',
    'size'                  => [
        'numeric'   => 'Поле :attribute должно быть равным :size.',
        'file'      => 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).',
        'string'    => 'Количество символов в поле :attribute должно быть равным :size.',
        'array'     => 'Количество элементов в поле :attribute должно быть равным :size.',
    ],
    'starts_with'           => ':attribute должен начинаться с одного из следующих значений: :values.',
    'string'                => 'Поле :attribute должно быть строкой.',
    'timezone'              => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique'                => 'Такое значение поля :attribute уже существует.',
    'uploaded'              => ':attribute не удалось загрузить.',
    'url'                   => 'Поле :attribute имеет ошибочный формат.',
    'uuid'                  => ':attribute должен быть действительным универсальным уникальным идентификатором.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
