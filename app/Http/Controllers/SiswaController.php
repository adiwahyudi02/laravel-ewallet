<?php

namespace App\Http\Controllers;

use App\Siswa;
use App\User;
use App\Walet;
use App\Tahun;
use Illuminate\Http\Request;
use Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_siswa = Siswa::all();
        return view('siswa.coba',['data_siswa' => $data_siswa]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

         // dd($request->all());

        //insert table user
        // $user = new User;
        // $user->role = 'siswa';
        // $user->nama = $request->nama;
        // $user->nis = $request->nis;
        // $user->password =bcrypt('password');
        // $user->remember_token = str_random(60);
        // $user->save();

       // insert wallet
        

        // $user->wallet()->save($walet);


        //insert ke table siswa
        // $request->request->add(['user_id'=> $user->id]);
        // $siswa = Siswa::create($request->all());
        return redirect('/datasiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'nama' => 'required|min:5',
        //     'nis' => 'required|min:9|unique:users',
        //     'jenis_kelamin' => 'required',
        //     'jurusan' => 'required',
        //     'tingkat' => 'required',
        //     'kelas' => 'required'
        // ]);

        // $user = User::create([
        //     'nis' => $request->nis,
        //     'role' => 'siswa',
        //     'nama' => $request->nama,
        //     'password' => bcrypt('password'),
        //     'remember_token' => str_random(60)        
        // ]);

        // $user->siswa()->create([
        //     // 'nis' => $request->nis,
        //     // 'nama' => $request->nama,
        //     // 'jenis_kelamin' => $request->jenis_kelamin,
        //     // 'password' => bcrypt('password'),
        //     // 'jurusan' => $request->name,
        //     // 'tingkat' => $request->tingkat,
        //     // 'kelas' => $request->kelas
            
        // ]);
        
        // $user->wallet()->create([
        //     'saldo' => '100000'
        // ]);

        // return redirect('/datasiswa');

        $user = User::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'role' => 'siswa',
            'password' => bcrypt('password'),
            'remember_token' => str_random(60)
            
        ]);
    
        $user->wallet()->create([
            'saldo' => 1000000
        ]);

        $user->siswa()->create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => bcrypt('password'),
            'jurusan' => $request->jurusan,
            'tingkat' => $request->tingkat,
            'kelas' => $request->kelas
        ]);
        return redirect('/datasiswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil($id)
    {
        $siswa = Siswa::find($id);
        return view('siswa.profil', ['siswa'=>$siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
         $siswa = \App\Siswa::find($id);
         $siswa->delete($siswa);
         return redirect('/datasiswa');
    }

    public function fileExport()
    {
        $siswa = Siswa::select('nama', 'nis', 'jenis_kelamin','jurusan', 'tingkat', 'kelas')->get();
        return Excel::create('data_siswa', function($excel) use ($siswa){
            $excel->sheet('mysheet', function($sheet) use ($siswa) {
                $sheet->fromArray($siswa);
            });
        })->download('xls');
    }
}
