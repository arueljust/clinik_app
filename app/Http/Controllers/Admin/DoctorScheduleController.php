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
            ->orderBy('d.doctor_id', 'desc')
            ->paginate(10);

        foreach ($doctorsSchedule as $u) {
            $timestamp = $u->created_at;
            $dateTime = new DateTime($timestamp);
            $formattedDate = $dateTime->format('l, d F Y');
            $carbonDate = Carbon::createFromFormat('l, d F Y', $formattedDate, 'UTC');
            $indonesianDate = $carbonDate->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
            $u->created_at = $indonesianDate;
        }

        $view = [
            'doctorsSchedule' => $doctorsSchedule
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
            return response()->json(['message' => 'ok']);
        }
        return response()->json(['message' => 'failed'], 500);
    }
}
