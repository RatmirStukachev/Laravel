<?php

namespace App\Http\Requests;

use App\Models\Delivery;
use App\Models\PaymentType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        $deliveryId = (int)$this->input('delivery_id');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:11','max:20'],
            'email' => ['nullable', 'email:filter', 'max:55'],
            'delivery_id' => ['required', Rule::exists(Delivery::class, 'id')],
            'delivery_price' => ['required', 'numeric', 'min:0'],
            'payment_type_id' => ['required', Rule::exists(PaymentType::class, 'id')],        
            'message' => ['nullable', 'string'],
            'agree' => ['required','accepted'],
        ];

        if (in_array($deliveryId, [Delivery::DELIVERY_TO_ADDRESS, Delivery::DELIVERY_TO_CITY])) {
            $rules['city'] = ['required', 'string', 'max:55'];
            $rules['street'] = ['required', 'string', 'max:55'];
            $rules['house'] = ['required', 'string', 'max:55'];
            $rules['block'] = ['nullable', 'string', 'max:55'];
            $rules['flat'] = ['required', 'string', 'max:55'];
            $rules['entrance'] = ['nullable', 'string', 'max:55'];
            $rules['floor'] = ['required', 'string', 'max:55'];
            $rules['message'] = ['nullable', 'string', 'max:555'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.max' => 'Поле "Имя" не должно превышать 255 символов.',
            'surname.max' => 'Поле "Фамилия" не должно превышать 255 символов.',
            'middle_name.max' => 'Поле "Отчество" не должно превышать 255 символов.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.min' => 'Поле "Телефон" должно быть не менее 11 символов.',
            'phone.max' => 'Поле "Телефон" не должно превышать 20 символов.',
            'email.email' => 'Поле "Email" должно быть валидным email адресом.',
            'agree.required' => 'Вы должны согласиться с условиями обработки персональных данных.',
            'agree.accepted' => 'Вы должны согласиться с условиями обработки персональных данных.',

            'delivery_id.required' => 'Поле "Способ доставки" обязательно для заполнения.',
            'delivery_id.exists' => 'Способ доставки не найден.',

            'payment_type_id.required' => 'Поле "Способ оплаты" обязательно для заполнения.',
            'payment_type_id.exists' => 'Способ оплаты не найден.',


            'city.required' => 'Поле "Город" обязательно для заполнения.',
            'city.string' => 'Поле "Город" должно быть строкой.',
            'city.max' => 'Поле "Город" не должно превышать 255 символов.',

            'street.required' => 'Поле "Улица" обязательно для заполнения.',
            'street.string' => 'Поле "Улица" должно быть строкой.',
            'street.max' => 'Поле "Улица" не должно превышать 255 символов.',

            'house.required' => 'Поле "Дом" обязательно для заполнения.',
            'house.string' => 'Поле "Дом" должно быть строкой.',
            'house.max' => 'Поле "Дом" не должно превышать 255 символов.',

            'block.string' => 'Поле "Корпус" должно быть строкой.',
            'block.max' => 'Поле "Корпус" не должно превышать 255 символов.',

            'flat.required' => 'Поле "Квартира" обязательно для заполнения.',
            'flat.string' => 'Поле "Квартира" должно быть строкой.',
            'flat.max' => 'Поле "Квартира" не должно превышать 255 символов.',

            'entrance.string' => 'Поле "Подъезд" должно быть строкой.',
            'entrance.max' => 'Поле "Подъезд" не должно превышать 255 символов.',

            'floor.required' => 'Поле "Этаж" обязательно для заполнения.',
            'floor.string' => 'Поле "Этаж" должно быть строкой.',
            'floor.max' => 'Поле "Этаж" не должно превышать 255 символов.',
        ];
    }
}
