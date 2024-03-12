<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class DoctorValidator
{
    public static function validateDoctor($data)
    {
        $validator = Validator::make($data, [
            'doctor_name' => 'required|max:15|min:5',
            'doctor_email' => 'required|email|unique:m_doctors,doctor_email',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required|numeric|min:1000000000|unique:m_doctors,doctor_phone',
            'doctor_address' => 'required',
            'doctor_sip' => 'required',
            'doctor_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'doctor_name.required' => 'Nama wajib diisi',
            'doctor_name.max' => 'Nama maximal 15 karakter',
            'doctor_name.min' => 'Nama minimal 5 karakter',
            'doctor_email.required' => 'Email wajib diisi',
            'doctor_email.email' => 'Email wajib berupa alamat email yang valid',
            'doctor_email.unique' => 'Email sudah digunakan oleh pengguna lain',
            'doctor_specialist.required' => 'Spesialis dokter wajib diisi',
            'doctor_address.required' => 'Alamat dokter wajib diisi',
            'doctor_sip.required' => 'SIP wajib diisi',
            'doctor_phone.numeric' => 'No telp wajib berisi nomor',
            'doctor_phone.min' => 'No telp minimal 10 karakter',
            'doctor_phone.unique' => 'No telp sudah digunakan',
            'doctor_phone.required' => 'No telp wajib diisi',
            'doctor_photo.image' => 'File wajib berupa gambar',
            'doctor_photo.mimes' => 'Format file wajib berupa jpeg ,jpg ,png',
            'doctor_photo.max' => 'Ukuran Gambar maximal 2 mb',
        ]);

        return $validator;
    }
}
