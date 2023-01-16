<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthProfileRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_user' => [ 'required',Rule::in(['client', 'contractor']) ],
            'firstName' => 'required|max:191',
            'lastName' => 'required|max:191',
            'profession' => 'required|max:191',
            'balance' => 'required|numeric',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',

        ];
    }

    public function messages()
    {
       return[
        'type_user.in' => ' O usuário selecionado é inválido , insira client ou contractor',
        'email.unique' => 'O email ja foi cadastrado',
        'password.required' => 'A senha é obrigatório',
        'password.confirmed' => 'As senhas não são iguais',
        'password.min' => 'Senha muito curta, mínimo 8 caracteres',
        'password_confirmation.required' => 'Confirmação da senha é obrigatório',
       ] ;
    }
}
