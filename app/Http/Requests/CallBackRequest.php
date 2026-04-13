<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallBackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'string', 'min:11','max:25'],
            'agree' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения',
            'phone.required' => 'Телефон обязательно для заполнения',
            'phone.min' => 'Телефон должен быть не менее 11 символов',
            'agree.accepted' => 'Вы должны дать согласие на обработку персональных данных',
            'agree.required' => 'Вы должны дать согласие на обработку персональных данных',
        ];
    }
}
