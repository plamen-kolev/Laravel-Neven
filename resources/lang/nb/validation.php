<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted'             => ':attribute må aksepteres. nb',
    'active_url'           => ':attribute er ikke en gyldig URL. nb',
    'after'                => ':attribute må være en dato etter :date. nb',
    'alpha'                => ':attribute må kun bestå av bokstaver. nb',
    'alpha_dash'           => ':attribute må kun bestå av bokstaver, tall og bindestreker. nb',
    'alpha_num'            => ':attribute må kun bestå av bokstaver og tall. nb',
    'array'                => ':attribute må være en matrise. nb',
    'before'               => ':attribute må være en dato før :date. nb',
    'between'              => [
        'numeric' => ':attribute skal være mellom :min - :max. nb',
        'file'    => ':attribute skal være mellom :min - :max kilobytes. nb',
        'string'  => ':attribute skal være mellom :min - :max tegn. nb',
        'array'   => ':attribute må ha mellom :min - :max elementer. nb',
    ],
    'boolean'              => 'The :attribute field must be true or false nb',
    'confirmed'            => ':attribute er ikke likt bekreftelsesfeltet. nb',
    'date'                 => ':attribute er ikke en gyldig dato. nb',
    'date_format'          => ':attribute matcher ikke formatet :format. nb',
    'different'            => ':attribute og :other skal være forskellige. nb',
    'digits'               => ':attribute skal ha :digits siffer. nb',
    'digits_between'       => ':attribute skal være mellom :min og :max siffer. nb',
    'distinct'             => 'The :attribute field has a duplicate value. nb',
    'email'                => ':attribute format er ugyldig. nb',
    'exists'               => 'Det valgte :attribute er ugyldig. nb',
    'filled'               => ':attribute må fylles ut. nb',
    'image'                => ':attribute skal være et bilde. nb',
    'in'                   => 'Det valgte :attribute er ugyldig. nb',
    'integer'              => ':attribute skal være et heltall. nb',
    'ip'                   => ':attribute skal være en gyldig IP adresse. nb',
    'json'                 => ':attribute må være på JSON-format. nb',
    'max'                  => [
        'numeric' => ':attribute skal være mindre enn :max. nb',
        'file'    => ':attribute skal være mindre enn :max kilobytes. nb',
        'string'  => ':attribute skal være kortere enn :max tegn. nb',
        'array'   => ':attribute skal ikke ha fler enn :max elementer. nb',
    ],
    'mimes'                => ':attribute skal være en fil av typen: :values. nb',
    'min'                  => [
        'numeric' => ':attribute skal være større enn :min. nb',
        'file'    => ':attribute skal være større enn :min kilobytes. nb',
        'string'  => ':attribute skal være lengre enn :min tegn. nb',
        'array'   => ':attribute må være minst :min elementer. nb',
    ],
    'not_in'               => 'Den valgte :attribute er ugyldig. nb',
    'numeric'              => ':attribute skal være et tall. nb',
    'present'              => 'The :attribute field must be present. nb',
    'regex'                => 'Formatet på :attribute er ugyldig. nb',
    'required'             => ':attribute må fylles ut. nb',
    'required_if'          => ':attribute må fylles ut når :other er :value. nb',
    'required_unless'      => ':attribute er påkrevd med mindre :other finnes blant verdiene :values. nb',
    'required_with'        => ':attribute må fylles ut når :values er utfylt. nb',
    'required_with_all'    => ':attribute er påkrevd når :values er oppgitt. nb',
    'required_without'     => ':attribute må fylles ut når :values ikke er utfylt. nb',
    'required_without_all' => ':attribute er påkrevd når ingen av :values er oppgitt. nb',
    'same'                 => ':attribute og :other må være like. nb',
    'size'                 => [
        'numeric' => ':attribute må være :size. nb',
        'file'    => ':attribute må være :size kilobytes. nb',
        'string'  => ':attribute må være :size tegn lang. nb',
        'array'   => ':attribute må inneholde :size elementer. nb',
    ],
    'string'               => ':attribute må være en tekststreng. nb',
    'timezone'             => ':attribute må være en gyldig tidssone. nb',
    'unique'               => ':attribute er allerede i bruk. nb',
    'url'                  => 'Formatet på :attribute er ugyldig. nb',
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
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message nb',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes'           => [
        //
    ],
];