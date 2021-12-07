<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @version 1
 * api response for v1
 */
Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function() {
    Route::post('login', 'AuthController@login');
    Route::get('login/oauth', 'AuthController@oauth');
    Route::get('login/sso', 'AuthController@sso');
    Route::get('login/callback', 'AuthController@callback');
    Route::get('settings/auth', 'SettingController@getSetAuth');
    Route::get('settings-public-sekolah', 'SettingController@getSettingPublicSekolah');
    Route::get('info-app', 'SettingController@infoApp');

    Route::get('absensi-ujian/{id}', 'ReportingController@absensi_ujian')->name('absensi.download.excel');
    Route::get('berita-acara/{id}', 'ReportingController@berita_acara')->name('beritaacara.download.excel');
    Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa/excel', 'ResultController@capaianSiswaExcel')->name('capaian.download.excel');
    Route::get('ujians/{jadwal}/result/excel', 'ResultController@examExcel')->name('hasilujian.download.excel');
    Route::get('ujians/esay/{banksoal}/koreksi-offline/excel', 'PenilaianController@jawabanPesertaEsayExcel')->name('koreksi.offline.download.excel');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user-authenticated', 'UserController@getUserLogin');
        Route::get('user-lists', 'UserController@userLists');
        Route::post('user/change-password', 'UserController@changePassword');
        Route::post('users/upload', 'UserController@import');
        Route::post('users/delete-multiple', 'UserController@destroyMultiple');
        Route::apiResource('users', 'UserController');

        Route::get('agamas', 'AgamaController@index');

        Route::get('jurusans/all', 'JurusanController@allData');
        Route::post('jurusans/delete-multiple', 'JurusanController@destroyMultiple');
        Route::apiResource('jurusans', 'JurusanController');

        Route::get('pesertas/login', 'PesertaController@getPesertaLogin');
        Route::delete('pesertas/{peserta}/login', 'PesertaController@resetPesertaLogin');
        Route::get('pesertas/multi-reset-login','PesertaController@multiResetPeserta');
        Route::post('pesertas/upload', 'PesertaController@import');
        Route::post('pesertas/delete-multiple', 'PesertaController@destroyMultiple');
        Route::apiResource('pesertas', 'PesertaController');

        Route::get('matpels/all', 'MatpelController@allData');
        Route::post('matpels/upload', 'MatpelController@import');
        Route::post('matpels/delete-multiple', 'MatpelController@destroyMultiple');
        Route::apiResource('matpels', 'MatpelController');

        Route::get('banksoals/{banksoal}/analys', 'BanksoalController@getAnalys');
        Route::get('banksoals/all', 'BanksoalController@allData');
        Route::get('banksoals/{banksoal}/duplikat', 'BanksoalController@duplikat');
        Route::post('banksoals/{banksoal}/lock', 'BanksoalController@lock');
        Route::post('banksoals/{banksoal}/unlock', 'BanksoalController@unlock');
        Route::apiResource('banksoals', 'BanksoalController');

        Route::post('soals/import-word/{banksoal}', 'SoalController@wordImport');
        Route::get('soals/{soal}', 'SoalController@show');
        Route::post('soals', 'SoalController@store');
        Route::post('soals/paste', 'SoalController@storePaste');
        Route::post('soals/{soal}/edit', 'SoalController@update');
        Route::get('soals/delete/multiple', 'SoalController@multipleDestroy');
        Route::delete('soals/{soal}', 'SoalController@destroy');
        Route::get('soals/banksoal/{banksoal}', 'SoalController@getSoalByBanksoal');
        Route::post('soals/banksoal/{banksoal}/upload', 'SoalController@import');
        Route::get('soals/banksoal/{banksoal}/all','SoalController@getSoalByBanksoalAll');
        Route::get('soals/banksoal/{banksoal}/analys', 'SoalController@getSoalByBanksoalAnalys');

        Route::post('directory/filemedia', 'DirectoryController@storeFilemedia');
        Route::post('file/upload', 'DirectoryController@uploadFile');
        Route::post('upload/file-audio', 'DirectoryController@uploadAudio');
        Route::delete('directory/filemedia/{filemedia}', 'DirectoryController@deleteFilemedia');
        Route::get('directory/filemedia/multiple-delete', 'DirectoryController@deleteMultipleFilemedia');
        Route::get('directory/banksoal/{filemedia}', 'DirectoryController@getDirectoryBanksoal');
        Route::apiResource('directory', 'DirectoryController');

        Route::post('ujians/{jadwal}/sesi-change', 'UjianAktifController@changeSesi');
        Route::get('ujians/sesi', 'UjianAktifController@sesi');
        Route::post('ujians/token-release', 'UjianAktifController@releaseToken');
        Route::get('ujians/token-get', 'UjianAktifController@getToken');
        Route::get('ujians/{jadwal}/peserta', 'UjianAktifController@getPesertas');
        Route::get('ujians/{jadwal}/peserta/{peserta}/reset', 'UjianAktifController@resetUjianPeserta');
        Route::get('ujians/{jadwal}/multi-reset', 'UjianAktifController@multiResetUjianPeserta');
        Route::get('ujians/{jadwal}/peserta/{peserta}/close', 'UjianAktifController@closePeserta');
        Route::get('ujians/{jadwal}/multi-close', 'UjianAktifController@multiClosePeserta');
        Route::post('ujians/peserta/add-more-time', 'UjianAktifController@addMoreTime');

        Route::get('ujians/esay/exists', 'PenilaianController@getExistEsay');
        Route::post('ujians/esay/input', 'PenilaianController@storeNilaiEsay');
        Route::get('ujians/esay/{banksoal}/koreksi', 'PenilaianController@getExistEsayByBanksoal');
        Route::get('ujians/esay/{banksoal}/koreksi-offline/link', 'PenilaianController@getJawabanPesertaEsayExcelLink');
        Route::post('ujians/esay/koreksi-offline/upload', 'PenilaianController@storeNilaiEsayExcel');

        Route::get('ujians/argument/exists', 'PenilaianController@getBanksoalExistArgument');
        Route::post('ujians/argument/input', 'PenilaianController@storeNilaiArgument');
        Route::get('ujians/argument/{banksoal}/koreksi', 'PenilaianController@getExistArgumentByBanksoal');

        Route::get('ujians/{jadwal}/result', 'ResultController@exam');

        Route::get('ujians/{jadwal}/result/link', 'ResultController@examExcelLink');

        Route::get('ujians/{jadwal}/result/banksoal', 'UjianController@getBanksoalByJadwal');
        Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa', 'ResultController@capaianSiswa');

        Route::get('ujians/{jadwal}/banksoal/{banksoal}/capaian-siswa/link', 'ResultController@capaianSiswaExcelLink');

        Route::get('ujians/all', 'UjianController@allData');
        Route::get('ujians/active-status', 'UjianController@getActive');
        Route::post('ujians/set-status', 'UjianController@setStatus');
        Route::get('ujians/hasil/{hasil}', 'ResultController@hasilUjianDetail');
        Route::apiResource('ujians', 'UjianController');

        Route::get('events/all', 'EventController@allData');
        Route::get('events/ujian/{jadwal_id}/summary-simple', 'EventController@summarize');
        Route::get('events/ujian/{jadwal_id}/peserta-not-start', 'EventController@pesertaNotWork');
        Route::get('events/{id}/ujian', 'EventController@eventDetailData');
        Route::apiResource('events', 'EventController');
        Route::get('berita-acara/{id}/link', 'ReportingController@berita_acara_link');
        Route::get('absensi-ujian/{id}/link', 'ReportingController@absensi_ujian_link');

        Route::get('sesi', 'SesiScheduleController@studentBySesi');
        Route::post('sesi', 'SesiScheduleController@pushToSesi');
        Route::post('sesi/import', 'SesiScheduleController@importToSesi');
        Route::post('sesi/copy', 'SesiScheduleController@copyFromDefault');
        Route::delete('sesi', 'SesiScheduleController@removeFromSesi');

        Route::get('settings/sekolah', 'SettingController@getSettingSekolah');
        Route::post('settings/sekolah', 'SettingController@storeSettingSekolah');
        Route::post('settings/sekolah/logo', 'SettingController@changeLogoSekolah');
        Route::get('settings', 'SettingController@getSetting');
        Route::post('settings', 'SettingController@setSetting');

        Route::apiResource('groups', 'GroupController');
        Route::post('group_members/multiple', 'GroupMemberController@multiStore');
        Route::post('group_members/import', 'GroupMemberController@multiStoreImport');
        Route::delete('group_members/multiple', 'GroupMemberController@multiDestroy');
        Route::get('group_members', 'GroupMemberController@index');
        Route::post('group_members', 'GroupMemberController@store');
        Route::delete('group_members/{id}', 'GroupMemberController@destroy');
    });
});
