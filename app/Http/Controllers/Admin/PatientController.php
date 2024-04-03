<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function managementPatient(Request $request)
    {
        $patient = DB::table('m_patients as p')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        foreach ($patient as $p) {
            $timestamp = $p->created_at;
            $dateTime = new DateTime($timestamp);
            $formattedDate = $dateTime->format('l, d F Y');
            $carbonDate = Carbon::createFromFormat('l, d F Y', $formattedDate, 'UTC');
            $indonesianDate = $carbonDate->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
            $p->created_at = $indonesianDate;
        }

        $view = [
            'patient' => $patient
        ];
        return view('pages.patients.index', $view);
    }
}
