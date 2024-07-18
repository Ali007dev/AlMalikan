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

    'hourly_request_wrong_time' => "الفترة الزمنية المحددة تتجاوز الحد الأقصى لـ 8 ساعات.",
    'accepted'                  => 'يجب قبول حقل :attribute',
    'accepted_if'               => 'حقل :attribute مقبول في حال كان :other يساوي :value.',
    'active_url'                => 'حقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after'                     => 'يجب على حقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'            => 'حقل :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha'                     => 'يجب أن لا يحتوي حقل :attribute سوى على حروف',
    'alpha_dash'                => 'يجب أن لا يحتوي حقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num'                 => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array'                     => 'يجب أن يكون حقل :attribute مصفوفة',
    'before'                    => 'يجب على حقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'           => 'حقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between'                   => [
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
    ],
    'boolean'                   => 'يجب أن تكون قيمة حقل :attribute إما true أو false ',
    'confirmed'                 => 'حقل التأكيد غير مُطابق لحقل :attribute',
    'current_password'          => 'كلمة المرور غير صحيحة',
    'date'                      => 'حقل :attribute ليس تاريخًا صحيحًا',
    'date_equals'               => 'لا يساوي حقل :attribute مع :date.',
    'date_format'               => 'لا يتوافق حقل :attribute مع الشكل :format.',
    'declined'                  => 'يجب رفض حقل :attribute',
    'declined_if'               => 'حقل :attribute مرفوض في حال كان :other يساوي :value.',
    'different'                 => 'يجب أن يكون حقلان :attribute و :other مُختلفان',
    'digits'                    => 'يجب أن يحتوي حقل :attribute على :digits رقمًا/أرقام',
    'digits_between'            => 'يجب أن يحتوي حقل :attribute بين :min و :max رقمًا/أرقام',
    'dimensions'                => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'                  => 'للحقل :attribute قيمة مُكرّرة.',
    'doesnt_end_with'           => 'حقل :attribute يجب ألا ينتهي بواحدة من القيم التالية: :values.',
    'doesnt_start_with'         => 'حقل :attribute يجب ألا يبدأ بواحدة من القيم التالية: :values.',
    'email'                     => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'ends_with'                 => 'الـ :attribute يجب ان ينتهي بأحد القيم التالية :value.',
    'enum'                      => 'حقل :attribute غير صحيح',
    'exists'                    => 'حقل :attribute غير صحيح',
    'file'                      => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled'                    => 'حقل :attribute إجباري',
    'gt'                        => [
        'array'   => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file'    => 'الـ :attribute يجب ان يكون اكبر من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من :value.',
        'string'  => 'الـ :attribute يجب ان يكون اكبر من :value حروفٍ/حرفًا.',
    ],
    'gte'                       => [
        'array'   => 'الـ :attribute يجب ان يحتوي علي :value عناصر/عنصر او اكثر.',
        'file'    => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value.',
        'string'  => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value حروفٍ/حرفًا.',
    ],
    'image'                     => 'يجب أن يكون حقل :attribute صورةً',
    'in'                        => 'قيمة حقل :attribute غير صحيحة',
    'in_array'                  => 'حقل :attribute غير موجود في :other.',
    'integer'                   => 'يجب أن يكون حقل :attribute عددًا صحيحًا',
    'ip'                        => 'يجب أن يكون حقل :attribute عنوان IP ذا بُنية صحيحة',
    'ipv4'                      => 'يجب أن يكون حقل :attribute عنوان IPv4 ذا بنية صحيحة.',
    'ipv6'                      => 'يجب أن يكون حقل :attribute عنوان IPv6 ذا بنية صحيحة.',
    'json'                      => 'يجب أن يكون حقل :attribute نصا من نوع JSON.',
    'lowercase'                 => 'حقل :attribute يجب ان يتكون من حروف صغيرة',
    'lt'                        => [
        'array'   => 'الـ :attribute يجب ان يحتوي علي اقل من :value عناصر/عنصر.',
        'file'    => 'الـ :attribute يجب ان يكون اقل من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من :value.',
        'string'  => 'الـ :attribute يجب ان يكون اقل من :value حروفٍ/حرفًا.',
    ],
    'lte'                       => [
        'array'   => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file'    => 'الـ :attribute يجب ان يكون اقل من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value.',
        'string'  => 'الـ :attribute يجب ان يكون اقل من او يساوي :value حروفٍ/حرفًا.',
    ],
    'mac_address'               => 'يجب أن يكون حقل :attribute عنوان MAC ذا بنية صحيحة.',
    'max'                       => [
        'array'   => 'يجب أن لا يحتوي حقل :attribute على أكثر من :max عناصر/عنصر.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أصغر لـ :max.',
        'string'  => 'يجب أن لا يتجاوز طول نص :attribute :max حروفٍ/حرفًا',
    ],
    'max_digits'                => 'حقل :attribute يجب ألا يحتوي أكثر من :max أرقام.',
    'mimes'                     => 'يجب أن يكون حقل ملفًا من نوع : :values.',
    'mimetypes'                 => 'يجب أن يكون حقل ملفًا من نوع : :values.',
    'min'                       => [
        'array'   => 'يجب أن يحتوي حقل :attribute على الأقل على :min عناصر',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أكبر لـ :min.',
        'string'  => 'يجب أن يكون طول نص :attribute على الأقل :min محارف',
    ],
    'min_digits'                => 'حقل :attribute يجب أن يحتوي :min أرقام على الأقل.',
    'multiple_of'               => 'حقل :attribute يجب أن يكون من مضاعفات :value.',
    'not_in'                    => 'حقل :attribute لاغٍ',
    'not_regex'                 => 'حقل :attribute نوعه لاغٍ',
    'numeric'                   => 'يجب على حقل :attribute أن يكون رقمًا',
    'password'                  => [
        'letters'       => 'يجب ان يشمل حقل :attribute على حرف واحد على الاقل.',
        'mixed'         => 'يجب ان يشمل حقل :attribute على حرف واحد بصيغة كبيرة على الاقل وحرف اخر بصيغة صغيرة.',
        'numbers'       => 'يجب ان يشمل حقل :attribute على رقم واحد على الاقل.',
        'symbols'       => 'يجب ان يشمل حقل :attribute على رمز واحد على الاقل.',
        'uncompromised' => 'حقل :attribute تبدو غير آمنة. الرجاء اختيار قيمة اخرى.',
    ],
    'present'                   => 'يجب تقديم حقل :attribute',
    'prohibited'                => 'حقل :attribute محظور',
    'prohibited_if'             => 'حقل :attribute محظور في حال كان :other يساوي :value.',
    'prohibited_unless'         => 'حقل :attribute محظور في حال ما لم يكون :other يساوي :value.',
    'prohibits'                 => 'حقل :attribute يحظر :other من اي يكون موجود',
    'regex'                     => 'صيغة حقل :attribute .غير صحيحة',
    'required'                  => 'يجب إدخال :attribute',
    'required_array_keys'       => 'حقل :attribute يجب ان يحتوي علي مدخلات للقيم التالية :values.',
    'required_if'               => 'حقل :attribute مطلوب في حال كان :other يساوي :value.',
    'required_if_accepted'      => 'The :attribute field is required when :other is accepted.',
    'required_unless'           => 'حقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'             => 'حقل :attribute مطلوب في حال توفّر حقل :values.',
    'required_with_all'         => 'حقل :attribute إذا توفّر :values.',
    'required_without'          => 'حقل :attribute إذا لم يتوفّر :values.',
    'required_without_all'      => 'حقل :attribute إذا لم يتوفّر :values.',
    'same'                      => 'يجب أن يتطابق حقل :attribute مع :other',
    'size'                      => [
        'array'   => 'يجب أن يحتوي حقل :attribute على :size عناصر بالظبط',
        'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية لـ :size',
        'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
    ],
    'starts_with'               => 'حقل :attribute يجب ان يبدأ بأحد القيم التالية: :values.',
    'string'                    => 'يجب أن يكون حقل :attribute نصآ.',
    'timezone'                  => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique'                    => 'قيمة حقل :attribute مُستخدمة من قبل',
    'uploaded'                  => 'فشل في تحميل الـ :attribute',
    'uppercase'                 => 'The :attribute must be uppercase.',
    'url'                       => 'صيغة الرابط :attribute غير صحيحة',
    'uuid'                      => 'حقل :attribute يجب ان ايكون رقم UUID صحيح.',
    'phone_attributes_required' => 'يجب إدخال كافة حقول الجوال',
    'can_not_delete'            => 'لا يمكنك حذف هذا العنصر لأنه لا يوجد غيره',


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

    'attributes' => [
        'first_name'              => 'الاسم الأول',
        'last_name'               => 'اسم العائلة',
        'middle_name'             => 'اسم الأب',
        'serial_employee_number'  => 'الرقم التسلسلي للموظف',
        'gender'                  => 'الجنس',
        'mobile_numbers'          => 'ارقام الجوالات',
        'mobile_numbers.*'        => 'الجوال',
        'nationality_id'          => 'الجنسية',
        'religion_id'             => 'الدين',
        'blood_type_id'           => 'زمرة الدم',
        'marital_status_id'       => 'الحالة الاجتماعية',
        'military_status_id'      => 'الحالة العسكرية',
        'email'                   => 'البريد الالكتروني',
        'health_insurance_number' => 'رقم التأمين الصحي',

        'phone_numbers'                                     => 'رقم الهاتف الثابت',
        'address.*'                                         => 'العنوان',
        'address'                                           => 'العناوين',
        'address.area'                                      => 'اسم المنطقة',
        'address.street'                                    => 'الشارع',
        'address.description'                               => 'الوصف',
        'address.phone_number'                              => 'رقم الهاتف الثابت',
        'id_card'                                           => 'البطاقة الشخصية',
        'id_card.mother_name'                               => 'اسم الأم',
        'id_card.birth_place'                               => 'مكان الولادة',
        'id_card.birth_date'                                => 'تاريخ الولادة',
        'id_card.national_number'                           => 'الرقم الوطني',
        'id_card.card_number'                               => 'رقم البطاقة الشخصية',
        'id_card.grant_source'                              => 'الامانة',
        'id_card.registration'                              => 'القيد',
        'id_card.special_marks'                             => 'العلامات المميزة',
        'id_card.grant_date'                                => 'تاريخ المنح',
        'id_card.files'                                     => 'صور الهوية',
        'id_card.files.*'                                   => 'صورة الهوية',
        'id_card.files.*.file'                              => 'ملف الهوية',
        'passport.passport_number'                          => 'رقم جواز السفر',
        'passport.grant_date'                               => 'تاريخ منح جواز السفر',
        'passport.grant_place'                              => 'مكان منح جواز السفر',
        'passport.files'                                    => 'صور جواز السفر',
        'passport.files.*'                                  => 'صورة جواز السفر',
        'passport.files.*.file'                             => 'ملف جواز السفر',
        'family_members.*.is_emergency'                     => 'هل هو عضو طوارئ ؟',
        'family_members.*.first_name'                       => 'اسم القريب',
        'family_members.*.birth_date'                       => 'تاريخ الولادة',
        'family_members.*.relation_id'                      => 'صلة القرابة',
        'family_members.*.martial_status_id'                => 'الحالة الاجتماعية للقريب',
        'family_members.*.nationality_id'                   => 'جنسية القريب',
        'family_members.*.is_dead'                          => ' هل العضو متوفى,',
        'family_members.*.mobile_number'                    => ' رقم القريب',
        'jobs.*.position_id'                                => ' المسمى الوظيفي',
        'jobs.*.start_date'                                 => 'بداية الوظيفة',
        'jobs.*.end_date'                                   => ' نهاية الوظيفة',
        'jobs.*.company'                                    => 'اسم الشركة',
        'jobs.*.certificate.name'                           => 'اسم الشهادة',
        'jobs.*.certificate.institution'                    => 'اسم المؤسسة الشهادة',
        'jobs.*.certificate.file'                           => 'صورة الشهادة',
        'other_members.*.first_name'                        => 'اسم الشخص الآخر',
        'other_members.*.last_name'                         => 'الكنية الشخص الآخر',
        'other_members.*.relation_id'                       => 'صلة معرفة الشخص الآخر',
        'other_members.*.mobile_number'                     => 'رقم الشخص الآخر',
        'skills.*.skill_id'                                 => 'الخبرة',
        'skills.*.rate'                                     => 'معدل الخبرة',
        'jobs.*.certificate.skills.*'                       => 'شهادة الخبرة',
        'educations.*.education_path.institution_source_id' => 'المؤسسة التعليمية',
        'educations.*.education_path.specialization_id'     => 'الاختصاصات',
        'educations.*.rate'                                 => 'معدل التعليم',
        'educations.*.year'                                 => 'سند الدراسة',
        'educations.*.from_date'                            => 'بداية المسار التعليمي',
        'educations.*.to_date'                              => 'نهاية المسار التعليمي',
        'educations.*.files.*.file'                         => 'صورة الشهادة العلمية',
        'educations.*.files.*.type'                         => 'نوع الشهادة',
        'name'                                              => 'الاسم',
        'education_type_id'                                 => 'فئة التعليم',
        'source_id'                                         => 'مصدر الشهادة',
        'institution_id'                                    => 'المؤسسة التعليمية',
        'specialization_id'                                 => 'الاختصاصات',
        'education_path_id'                                 => 'المسار التعليمي',
        'employee_id'                                       => 'الموظف',
        'rate'                                              => 'المعدل',
        'from_date'                                         => 'تاريخ البداية',
        'to_date'                                           => 'تاريخ النهاية',
        'addresses.*.town'                                  => 'اسم البلدة',
        'addresses.*.phone_number'                          => 'الهاتف الثابت',
        'addresses.*.description'                           => 'الوصف',
        'addresses.*.area'                                  => 'اسم المنطقة',
        'addresses.*.is_always'                             => 'عنوان دائم',
        //
        'employee_position.contract.number'                 => 'رقم القعد',
        'passport_number'                                   => 'الرقم التسلسلي لجواز السفر',
        'grant_date'                                        => 'تاريخ المنح',
        'grant_place'                                       => 'مكان الاستلام',
        //
        'city_id'                                           => 'اسم المدينة',
        //
        'contract.number'                                   => 'رقم العقد',
        'contract.from_date'                                => 'تاريخ بداية العقد',
        'contract.to_date'                                  => 'تاريخ نهاية العقد',

        'age'                   => 'العمر',
        'day'                   => 'اليوم',
        'month'                 => 'الشهر',
        'year'                  => 'السنة',
        'hour'                  => 'ساعة',
        'minute'                => 'دقيقة',
        'second'                => 'ثانية',
        'description'           => 'الوصف',
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'birth_date'            => 'تاريخ الميلاد',
        'identity_number'       => 'رقم الهوية',
        'position'              => 'المنصب الوظيفي',
        'conditions.*.max'      => 'القيمة العليا للشرط',
        'conditions.*.min'      => 'القيمة العليا للشرط',
        'conditions.*.percent'  => 'نسبة الخصم',
        'password'              => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',

        'file'            => "ملف",
        'birth_place'     => 'مكان الولادة',
        'national_number' => 'الرقم الوطني',
        'mother_name'     => 'اسم الأم',
        'card_number'     => 'رقم الهوية',
        'grant_source'    => 'مكان المنح',
        'registration'    => 'القيد',
        'special_marks'   => 'العلامات مميزة',

        'addresses.*.city_id' => 'حقل المدينة',

        'family_members'             => 'أفراد الأسرة',
        'family_members.*.last_name' => 'اسم العائلة',

        'other_members' => 'الأشخاص أخرون',

        'position_type_id'       => 'نوع المنصب',
        'department_position_id' => 'المنصب في القسم',

        'labor_law_id'  => 'قانون العمل',
        'work_shift_id' => 'فترة الدوام',


        'jobs.*.from_date'            => 'تاريخ البداية',
        'jobs.*.to_date'              => 'تاريخ الانتهاء',
        'jobs.*.salary'               => 'راتب الوظيفة',
        'jobs.*.previous_position_id' => 'المنصب السابق',

        'number' => 'الرقم',
        'type'   => 'النوع',

        'salary.total_value'     => 'القيمة الإجمالية',
        'salary.mandatory_value' => 'القيمة الإلزامية',
        'salary.from_date'       => 'تاريخ بداية الراتب',
        'salary.to_date'         => 'تاريخ نهاية الراتب',

        'addresses'                                => 'العناوين',
        'mobile_numbers.0'                         => 'رقم واحد على الأقل',
        'employee_position.department_position_id' => 'المنصب في القسم',
        'employee_position.labor_law_id'           => 'قانون العمل',
        'employee_position.work_shift_id'          => 'فترة الدوام',
        'employee_position.from_date'              => 'تاريخ بدء منصب العمل',
        'employee_position.contract.type'          => 'نوع العقد',
        'employee_position.contract.to_date'       => 'تاريخ الانتهاء الخاص بالعقد',

        'employee_position.contract.salary.mandatory_value' => 'القيمة الالزامية للراتب',
        'employee_position.contract.salary.total_value'     => 'القيمة الاجمالية للراتب',
        'employee_position.contract.salary.from_date'       => 'تاريخ البدءالخاص بالراتب',

        'employee_skills.*.skill_id' => 'المهارة',
        'employee_skills.*.rate'     => 'التقييم',

        'department_id'  => 'القسم',
        'position_id'    => 'المنصب',
        'station_id'     => 'المحطة',
        'directorate_id' => 'مديرية',

        'value'         => 'القيمة',
        'tax'           => 'الضريبة',
        'is_percent'    => 'هل نسبة مئوية؟',
        'is_percentage' => 'هل نسبة مئوية؟',
        'reason'        => 'السبب',
        'section'       => 'القسم',

        'hours' => 'عدد الساعات',
        'heavy' => 'التثقيل',


    ],

];
