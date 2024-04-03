<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DoctorScheduleController extends Controller
{
    public function managementDoctorSchedule(Request $request)
    {
        $doctorsSchedule = DB::table('doctor_schedules as d')
            ->when($request->input('doctor_id'), function ($query, $doctor_id) {
                return $query->where('doctor_id', 'like', '%' . $doctor_id . '%');
            })
            ->join('m_doctors as md', 'md.id', '=', 'd.doctor_id')
            ->select('d.id', 'md.doctor_name', 'd.created_at', 'd.doctor_id', 'd.day', 'd.time', 'd.note', 'd.status')
            ->orderBy('d.doctor_id', 'desc')
            ->paginate(10);

        foreach ($doctorsSchedule as $u) {
            $timestamp = $u->created_at;
            $dateTime = new DateTime($timestamp);
            $formattedDate = $dateTime->format('l, d F Y');
            $carbonDate = Carbon::createFromFormat('l, d F Y', $formattedDate, 'UTC');
            $indonesianDate = $carbonDate->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
            $decodeDay = json_decode($u->day);
            $decodeTime = json_decode($u->time);
            $u->created_at = $indonesianDate;
            $u->time = $decodeTime;
            $u->day = $decodeDay;
        }
        $view = [
            'doctorsSchedule' => $doctorsSchedule,
        ];
        return view('pages.doctors_schedule.index', $view);
    }

    public function createDoctorSchedule()
    {
        $doctor = DB::table('m_doctors')->get();

        $view = [
            'doctor' => $doctor
        ];
        return view('pages.doctors_schedule.create', $view);
    }

    public function storeDoctorSchedule(Request $req)
    {
        $doctorId = $req->doctor_id;
        $day = $req->input('day');
        $time = $req->input('additional_input');
        $status = $req->status;
        $note = $req->note;

        $data = [
            'doctor_id' => $doctorId,
            'day' => json_encode($day),
            'time' => json_encode($time),
            'status' => $status,
            'note' => $note,
            'created_at' => now()
        ];
        $save = DB::table('doctor_schedules')->insert($data);
        if ($save) {
            return redirect()->route('managementDoctorSchedule')->with('success', 'Data berhasil Disimpan');
        }
        return redirect()->route('managementDoctorSchedule')->with('error', 'Data gagal Disimpan');
    }

    public function editDoctorSchedule(Request $req)
    {
        $id = $req->id;
        $doctorData = DB::table('m_doctors')->get();
        $doctorSchedule = DB::table('doctor_schedules')->where('id', $id)->first();
        $decodeDay = json_decode($doctorSchedule->day);
        $view = [
            'doctorData' => $doctorData,
            'doctorSchedule' => $doctorSchedule,
            'decodeDay' => $decodeDay,
        ];
        return view('pages.doctors_schedule.edit', $view);
    }

    public function deleteDoctorSchedule(Request $req)
    {
        $id = $req->id;
        $delete = DB::table('doctor_schedules')->where('id', $id)->delete();
        if ($delete) {
            return 'Data terhapus';
        }
    }
}
