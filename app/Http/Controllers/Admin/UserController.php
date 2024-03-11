<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function managementUser(Request $request)
    {
        $users = DB::table('m_users as u')->join('m_roles as r', 'u.role_id', '=', 'r.id')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('r.role_name', 'u.id', 'u.name', 'u.name', 'u.email', 'u.phone', 'u.created_at')
            ->orderBy('id', 'desc')
            ->paginate(10);

        foreach ($users as $u) {
            $timestamp = $u->created_at;
            $dateTime = new DateTime($timestamp);
            $formattedDate = $dateTime->format('l, d F Y');
            $carbonDate = Carbon::createFromFormat('l, d F Y', $formattedDate, 'UTC');
            $indonesianDate = $carbonDate->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
            $u->created_at = $indonesianDate;
        }

        $view = [
            'users' => $users
        ];
        return view('pages.users.index', $view);
    }

    public function createUser()
    {
        return view('pages.users.create');
    }

    public function storeUser(Request $req)
    {
        $utcTime = now();
        $localTime = Carbon::parse($utcTime)->setTimezone('Asia/Jakarta');
        $formattedLocalTime = $localTime->format('Y-m-d H:i:s');
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:15|min:5',
            'email' => 'required|email|unique:m_users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])/',
            ],
            'phone' => 'required|numeric|min:1000000000|unique:m_users,phone'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maximal 15 karakter',
            'name.min' => 'Nama minimal 5 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa alamat email yang valid',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal harus terdiri dari 8 karater',
            'password.regex' => 'Password harus terdiri dari angka dan huruf',
            'phone.numeric' => 'No telp harus berisi nomor',
            'phone.min' => 'No telp minimal 10 karakter',
            'phone.unique' => 'No telp sudah ada'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = [
            'name' => $req->name,
            'role_id' => $req->role_id,
            'email' => $req->email,
            'phone' => $req->phone,
            'password' => Hash::make($req->password),
            'status' => '0',
            'created_at' => $formattedLocalTime
        ];

        $save = DB::table('m_users')->insert($data);
    }

    public function editUser(Request $req)
    {
        $id = $req->id;
        $role = DB::table('m_roles')->get();
        $userData = DB::table('m_users as u')
            ->join('m_roles as r', 'u.role_id', '=', 'r.id')
            ->select('r.role_name', 'u.id', 'u.name', 'u.role_id', 'u.name', 'u.email', 'u.phone', 'u.created_at')
            ->where('u.id', $id)->first();
        $view = [
            'userData' => $userData,
            'role' => $role
        ];
        return view('pages.users.edit', $view);
    }

    public function updateUser(Request $req)
    {
        $id = $req->id;
        $name = $req->name;
        $email = $req->email;
        $phone = $req->phone;
        $role = $req->role_id;
        $updatePass = '';
        $currentPass = DB::table('m_users')->where('id', $id)->first();
        if ($req->password != null) {
            $updatePass = Hash::make($req->password);
        } else {
            $updatePass = $currentPass->password;
        }
        $utcTime = now();
        $localTime = Carbon::parse($utcTime)->setTimezone('Asia/Jakarta');
        $formattedLocalTime = $localTime->format('Y-m-d H:i:s');
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $updatePass,
                'role_id' => $role,
                'updated_at' => $formattedLocalTime
            ];
            $update = DB::table('m_users')->where('id', $id)->update($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteUser(Request $req)
    {
        $id = $req->id;

        $delete = DB::table('m_users')->where('id', $id)->delete();
        if ($delete) {
            return 'Data terhapus';
        }
    }

    public function updateStatusUser()
    {

    }
}
