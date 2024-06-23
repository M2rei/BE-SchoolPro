<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuruMapelResource;
use App\Http\Resources\MataPelajaranResource;
use App\Models\GuruMapel;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class GurumapelController extends Controller
{
    // BAGIAN GURUMAPEL
    public function indexgurumapel(){
        $gurumapel =  GuruMapel::all();
        return response()->json($gurumapel);
    }

    public function postgurumapel(Request $request){
        $this->validate($request, [
            'guru_karyawan_id'=> 'required',
            'mata_pelajaran_id'=> 'required'
        ]);
        $gurumapelpost = GuruMapel::create($request->all());
        if ($gurumapelpost) {
            return response()->json([
                'Message: ' => 'Succes!',
                'gurumapel created: ' => $gurumapelpost
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not create a new gurumapel.',
            ], 500);
        }
    }
    public function updategurumapel(Request $request, string $id){
        $gurumapelupdate = GuruMapel::find($id);
        if ($gurumapelupdate) {
            $validatedata = $request->validate([
                'guru_karyawan_id'=> 'required',
                'mata_pelajaran_id'=> 'required'
            ]);
            $gurumapelupdate->guru_karyawan_id = $validatedata['guru_karyawan_id'];
            $gurumapelupdate->mata_pelajaran_id = $validatedata['mata_pelajaran_id'];
            if ($gurumapelupdate->save()) {
                return response()->json([
                    'Message: ' => 'gurumapel updated with success.',
                    'gurumapel: ' => $gurumapelupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the gurumapel.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the gurumapel.',
            ], 500);
        }
    }

    public function deletegurumapel(string $id){
        $gurumapeldelete = GuruMapel::find($id);
        if ($gurumapeldelete) {
            $gurumapeldelete->delete();
            return response()->json([
                'Message: ' => 'gurumapel delete with success.',
                'gurumapel: ' => $gurumapeldelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the gurumapel.',
            ], 500);
        }
    }

    // BAGIAN MATA PELAJARAN
    public function indexmatapelajaran(){
        $matapelajaran = MataPelajaran::all();
        return response()->json($matapelajaran);
    }

    public function postmatapelajaran(Request $request){
        $this->validate($request, [
            'nama_matapelajaran'=> 'required'
        ]);
        $matapelajaranpost = MataPelajaran::create($request->all());
        if ($matapelajaranpost) {
            return response()->json([
                'Message: ' => 'Succes!',
                'matapelajaran created: ' => $matapelajaranpost
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not create a new matapelajaran.',
            ], 500);
        }
    }

    public function updatematapelajaran(Request $request, string $id){
        $matapelajaranupdate = MataPelajaran::find($id);
        if ($matapelajaranupdate) {
            $validatedata = $request->validate([
                'nama_matapelajaran'=> 'required'
            ]);
            $matapelajaranupdate->nama_matapelajaran = $validatedata['nama_matapelajaran'];
            if ($matapelajaranupdate->save()) {
                return response()->json([
                    'Message: ' => 'matapelajara updated with success.',
                    'matapelajara: ' => $matapelajaranupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the matapelajara.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the matapelajara.',
            ], 500);
        }
    }
    
    public function deletematapelajaran(string $id){
        $matapelajarandelete = MataPelajaran::find($id);
        if ($matapelajarandelete) {
            $matapelajarandelete->delete();
            return response()->json([
                'Message: ' => 'matapelajaran delete with success.',
                'matapelajaran: ' => $matapelajarandelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the matapelajaran.',
            ], 500);
        }
    }

}
