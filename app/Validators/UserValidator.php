<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    public static function validateUser($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:15|min:5',
            'email' => 'required|email|unique:m_users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])/',
            ],
            'phone' => 'required|numeric|min:1000000000|unique:m_users,phone',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maximal 15 karakter',
            'name.min' => 'Nama minimal 5 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email wajib berupa alamat email yang valid',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal wajib terdiri dari 8 karater',
            'password.regex' => 'Password wajib terdiri dari angka dan huruf',
            'phone.numeric' => 'No telp wajib berisi nomor',
            'phone.min' => 'No telp minimal 10 karakter',
            'phone.unique' => 'No telp sudah digunakan',
        ]);

        return $validator;
    }
}
