<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('usuario');
        $idVal = is_object($id) ? $id->id : $id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email' . ($idVal ? ",$idVal" : ''),
            'password' => $idVal ? 'nullable|string|min:6' : 'required|string|min:6',
            'rol' => 'required|string|exists:roles,name',
        ];
    }
}
