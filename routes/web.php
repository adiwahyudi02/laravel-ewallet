<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\Walet;
use App\Siswa;
use App\Tahun;


// coba multi auth

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', function(){
    return view('admin');
})->name('adminpage');
Route::get('admin-login','Auth\AdminLoginController@showLoginForm');
Route::post('admin-login', ['as' => 'admin-login', 'uses' => 'Auth\AdminLoginController@login']);
// Route::get('admin-register','Auth\AdminLoginController@showRegisterPage');
// Route::post('admin-register', 'Auth\AdminLoginController@register')->name('admin.register');





Route::get('/login','AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware'=> ['auth', 'checkRole:admin']], function(){
Route::get('/dashboard','DashboardController@index');
Route::get('/riwayat','RiwayatController@index');
Route::get('/datasiswa', 'SiswaController@index');
Route::post('/datasiswa/create','SiswaController@create');
Route::post('/datasiswa','SiswaController@store')->name('user.store');
Route::get('/datasiswa/{id}/delete', 'SiswaController@delete');
Route::get('/datasiswa/{id}/profil', 'SiswaController@profil');
Route::get('/export', 'SiswaController@fileExport')->name('file.export');
});
Route::group(['middleware'=> ['auth', 'checkRole:siswa']], function(){
    
    Route::get('/loginUser', function(){
        return view('user.loginUser');
    });
    Route::get('/dashboardUser', function(){
        return view('user.dashboardUser');
    });
    Route::get('/pembayaran', function(){
        return view('user.pembayaran');
    });

    Route::get('/profilUser', function(){
        return view('user.profilUser');
    });
});

Route::get('/createUser', function() {
    $user = User::create([
        'nama' => 'Rahma Alia Putri',
        'nis' => '101803655',
        'role' => 'siswa',
        'password' => bcrypt('password')
        
    ]);

    $user->wallet()->create([
        'saldo' => 1000000
    ]);

    $user->siswa()->create([
        'nis' => '101803655',
        'nama' => 'Rahma Alia Putri',
        'jenis_kelamin' => 'Perempuan',
        'password' => bcrypt('password'),
        'jurusan' => 'RPL',
        'tingkat' => '19',
        'kelas' => 'a'
    ]);
    return 'success';

    
});

Route::get('/createWallet', function() {
    $user = User::find(4);

    $walet = new Walet([
        'saldo' => 100000
    ]);

    $user->wallet()->save($walet);

    return $user;
});

Route::get('/dashboardUser', function() {
    return view('user.dashboardUser');
});
Route::get('/pembayaran', function() {
    return view('user.pembayaran');
});
Route::get('/profilUser', function() {
    return view('user.profilUser');
});

Route::get('/createTahun_user', function() {
    $user = User::create([
        'nama' => 'Rahma Alia Putri',
        'nis' => '101803655',
        'role' => 'siswa',
        'password' => bcrypt('password')
        
    ]);

    $user->wallet()->create([
        'saldo' => 1000000
    ]);

    // $user->siswa()->create([
    //     'nis' => '101803655',
    //     'nama' => 'Rahma Alia Putri',
    //     'jenis_kelamin' => 'Perempuan',
    //     'password' => bcrypt('password'),
    //     'jurusan' => 'RPL',
    //     'tingkat' => '19',
    //     'kelas' => 'a'
    // ]);

    $tahun = Tahun::find(1);

    $tahun->siswaTahun()->create([
        // 'user_id' => $user->id,
        // 'nis' => '101803655',
        // 'nama' => 'Rahma Alia Putri',
        // 'jenis_kelamin' => 'Perempuan',
        // 'password' => bcrypt('password'),
        // 'jurusan' => 'RPL',
        // 'tingkat' => '19',
        // 'kelas' => 'a'
        'user_id' => $user->id,
        'nis' => '101803655',
        'nama' => 'Barjo',
        'jenis_kelamin' => 'Perempuan',
        'password' => bcrypt('password'),
        'jurusan' => 'RPL',
        'tingkat' => '19',
        'kelas' => 'a'
    ]);

    return 'success';
});


