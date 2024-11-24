<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 2,
        ]);

        $tanggal = now()->format('dmY');
        $latestPasien = Pasien::latest()->first();
        $latestNumber = $latestPasien ? (int) substr($latestPasien->nomor_rekam_medis, -3) : 0;
        $nomorUrut = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);

        $nomorRekamMedis = 'REKAMMEDIS' . $tanggal . $nomorUrut;

        Pasien::create([
            'user_id' => $user->id,
            'nomor_rekam_medis' => $nomorRekamMedis,
            'alamat' => $data['alamat'],
            'tempat_tanggal_lahir' => $data['tempat_tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'status_perkawinan' => $data['status_perkawinan'],
            'kontak_keluarga_terdekat' => $data['kontak_keluarga_terdekat'],
            'pekerjaan' => $data['pekerjaan'],
            'pendidikan' => $data['pendidikan'],
        ]);

        return $user;
    }
}
