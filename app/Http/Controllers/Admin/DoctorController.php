<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Validators\DoctorValidator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function managementDoctor(Request $request)
    {
        $doctors = DB::table('m_doctors as d')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        foreach ($doctors as $u) {
            $timestamp = $u->created_at;
            $dateTime = new DateTime($timestamp);
            $formattedDate = $dateTime->format('l, d F Y');
            $carbonDate = Carbon::createFromFormat('l, d F Y', $formattedDate, 'UTC');
            $indonesianDate = $carbonDate->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
            $u->created_at = $indonesianDate;
        }

        $view = [
            'doctors' => $doctors
        ];
        return view('pages.doctors.index', $view);
    }

    public function createDoctor()
    {
        return view('pages.doctors.create');
    }

    public function storeDoctor(Request $req)
    {
        $utcTime = now();
        $localTime = Carbon::parse($utcTime)->setTimezone('Asia/Jakarta');
        $formattedLocalTime = $localTime->format('Y-m-d H:i:s');
        $validator = DoctorValidator::validateDoctor($req->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if ($req->doctor_photo == null) {
            $imageName = null;
        } else {
            $image = $req->file('doctor_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/doctor', $imageName);
        }

        $data = [
            'doctor_name' => $req->doctor_name,
            'doctor_email' => $req->doctor_email,
            'doctor_address' => $req->doctor_address,
            'doctor_phone' => $req->doctor_phone,
            'doctor_sip' => $req->doctor_sip,
            'doctor_specialist' => $req->doctor_specialist,
            'doctor_photo' => $imageName,
            'created_at' => $formattedLocalTime
        ];

        $save = DB::table('m_doctors')->insert($data);
        if ($save) {
            return 'Berhasil simpan Data';
        }
    }

    public function editDoctor(Request $req)
    {
        $id = $req->id;
        $doctorData = DB::table('m_doctors')
            ->where('id', $id)->first();
        $view = [
            'doctorData' => $doctorData,
        ];
        return view('pages.doctors.edit', $view);
    }

    public function updateDoctor(Request $req)
    {
        $id = $req->id;
        $utcTime = now();
        $localTime = Carbon::parse($utcTime)->setTimezone('Asia/Jakarta');
        $formattedLocalTime = $localTime->format('Y-m-d H:i:s');
        $currentImage = DB::table('m_doctors')->where('id', $id)->first();
        if ($req->doctor_photo != null) {
            $image = $req->file('doctor_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/doctor', $imageName);
        } else {
            $imageName = $currentImage->doctor_photo;
        }
        try {
            $data = [
                'doctor_name' => $req->doctor_name,
                'doctor_email' => $req->doctor_email,
                'doctor_address' => $req->doctor_address,
                'doctor_phone' => $req->doctor_phone,
                'doctor_sip' => $req->doctor_sip,
                'doctor_specialist' => $req->doctor_specialist,
                'doctor_photo' => $imageName,
                'updated_at' => $formattedLocalTime
            ];
            $update = DB::table('m_doctors')->where('id', $id)->update($data);
            if ($update) {
                return 'Berhasil update Data';
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteDoctor(Request $req)
    {
        $id = $req->id;
        $delete = DB::table('m_doctors')->where('id', $id)->delete();
        if ($delete) {
            return 'Data terhapus';
        }
    }
}
