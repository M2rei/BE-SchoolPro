<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //BAGIAN TABLE SISWA
    public function indexsiswa()
    {
        $siswa = Siswa::all();
        return response()->json($siswa);
    }

    public function postsiswa(Request $request)
    {
        $this->validate($request, [
            'jurusan_id' =>'required',
            'nama_depan' =>'required',
            'nama_belakang' =>'required',
            'kelas' =>'required',
        ]);
        $siswapost = Siswa::create($request->all());
        if ($siswapost) {
            return response()->json([
                'Message: ' => 'Succes!',
                'siswa created: ' => $siswapost
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not create a new siswa.',
            ], 500);
        }
    }

    public function updatesiswa(Request $request, string $id){
        $siswaupdate = Siswa::find($id);
        if ($siswaupdate) {
            $validatedata = $request->validate([
                'jurusan_id' =>'required',
                'nama_depan' =>'required',
                'nama_belakang' =>'required',
                'kelas' =>'required',
            ]);
            $siswaupdate->jurusan_id = $validatedata['jurusan_id'];
            $siswaupdate->nama_depan = $validatedata['nama_depan'];
            $siswaupdate->nama_belakang = $validatedata['nama_belakang'];
            $siswaupdate->kelas = $validatedata['kelas'];
            if ($siswaupdate->save()) {
                return response()->json([
                    'Message: ' => 'siswa updated with success.',
                    'siswa: ' => $siswaupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the siswa.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the siswa.',
            ], 500);
        }
    }

    public function deletesiswa(string $id){
        $siswadelete = Siswa::find($id);
        if ($siswadelete) {
            $siswadelete->delete();
            return response()->json([
                'Message: ' => 'siswa delete with success.',
                'siswa: ' => $siswadelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the siswa.',
            ], 500);
        }
    }



    // BAGIAN TABLE JURUSAN 
    public function indexjurusan()
    {
        $jurusan = Jurusan::all();
        return response()->json($jurusan);
    }

    public function postjurusan(Request $request)
    {
        $this->validate($request, [
            'nama_jurusan' => 'required',
            'deskripsi' => 'required',
        ]);
        $jurusanpost = Jurusan::create($request->all());
        if ($jurusanpost) {
            return response()->json([
                'Message: ' => 'Succes!',
                'Jurusan created: ' => $jurusanpost
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not create a new jurusan.',
            ], 500);
        }
    }

    public function updatejurusan(Request $request, string $id)
    {
        $jurusanupdate = Jurusan::find($id);
        if ($jurusanupdate) {
            $validatedata = $request->validate([
                'nama_jurusan' => 'required',
                'deskripsi' => 'required',
            ]);
            $jurusanupdate->nama_jurusan = $validatedata['nama_jurusan'];
            $jurusanupdate->deskripsi = $validatedata['deskripsi'];
            if ($jurusanupdate->save()) {
                return response()->json([
                    'Message: ' => 'Jurusan updated with success.',
                    'Jurusan: ' => $jurusanupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the Jurusan.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the Jurusan.',
            ], 500);
        }
    }
    public function deletejurusan(string $id)
    {
        $jurusandelete = Jurusan::find($id);
        if ($jurusandelete) {
            $jurusandelete->delete();
            return response()->json([
                'Message: ' => 'Jurusan delete with success.',
                'Jurusan: ' => $jurusandelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the Jurusan.',
            ], 500);
        }
    }
}
