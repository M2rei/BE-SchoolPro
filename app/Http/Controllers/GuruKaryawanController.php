<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuruKaryawanResource;
use App\Http\Resources\JabatanResource;
use App\Models\GuruKaryawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;

class GuruKaryawanController extends Controller
{
    // BAGIAN GURU
    public function indexGuru()
    {
        $guru = GuruKaryawan::with('jabatan')->get();

        return response()->json($guru);
    }

    public function indexdetailguru($id){
        $detailguru = GuruKaryawan::find($id);

        if($detailguru){
            return response()->json($detailguru);

        }else{
            return response()->json(null);
        }
    }
    public function postguru(Request $request)
    {
        $this->validate($request, [
            'jabatan_id' => 'required',
            'nama_guru' => 'required',
            'nip' => 'required',
            'nomor_telepon' => 'required',
            'jenis_guru' => 'required',
            'foto' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);

        $gurukaryawanpost = GuruKaryawan::create($request->all());

        if ($request->hasFile('foto')) {
            $filename = $request->file('foto')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('foto')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('foto')->storeAs('public/post_guru_karyawan', $createnewFileName);
            $gurukaryawanpost->foto = $createnewFileName;
            $gurukaryawanpost->save();
        }

        if ($gurukaryawanpost) {
            return response()->json([
                'message' => 'Success!',
                'gurukaryawan' => $gurukaryawanpost
            ], 200);
        } else {
            return response()->json([
                'message' => 'We could not create a new gurukaryawan.',
            ], 500);
        }
    }

    public function updateguru(Request $request, string $id)
    {
        $gurukaryawanupdate = GuruKaryawan::find($id);
        if ($gurukaryawanupdate) {
            $validatedata = $request->validate([
                'jabatan_id' => 'required',
                'nama_guru' => 'required',
                'nip' => 'required',
                'nomor_telepon' => 'required',
                'jenis_guru' => 'required',
                'foto' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
            ]);
            $gurukaryawanupdate->jabatan_id = $validatedata['jabatan_id'];
            $gurukaryawanupdate->nama_guru = $validatedata['nama_guru'];
            $gurukaryawanupdate->nip = $validatedata['nip'];
            $gurukaryawanupdate->nomor_telepon = $validatedata['nomor_telepon'];
            $gurukaryawanupdate->jenis_guru = $validatedata['jenis_guru'];

            if ($request->hasFile('foto')) {
                // Hapus gambar lama jika ada
                if ($gurukaryawanupdate->foto) {
                    Storage::delete('public/post_guru_karyawan/' . $gurukaryawanupdate->foto);
                }

                $filename = $request->file('foto')->getClientOriginalName();
                $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
                $getfileExtension = $request->file('foto')->getClientOriginalExtension();
                $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
                $img_path = $request->file('foto')->storeAs('public/post_guru_karyawan', $createnewFileName);
                $gurukaryawanupdate->foto = $createnewFileName;
            }

            if ($gurukaryawanupdate->save()) {
                return response()->json([
                    'Message: ' => 'gurukaryawan updated with success.',
                    'gurukaryawan: ' => $gurukaryawanupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the gurukaryawan.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the gurukaryawan.',
            ], 500);
        }
    }
    public function deleteguru(string $id)
    {
        $gurukaryawandelete = GuruKaryawan::find($id);
        if ($gurukaryawandelete->foto) {
            Storage::delete('public/post_guru_karyawan/' . $gurukaryawandelete->foto);
        }
        if ($gurukaryawandelete) {
            $gurukaryawandelete->delete();
            return response()->json([
                'Message: ' => 'gurukaryawan delete with success.',
                'gurukaryawan: ' => $gurukaryawandelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the gurukaryawan.',
            ], 500);
        }
    }



    // BAGIAN JABATAN GURU
    public function indexjabatan()
    {
        $jabatan = Jabatan::all();
        return response()->json($jabatan);
    }

    public function postjabatan(Request $request)
    {
        $this->validate($request, [
            'nama_jabatan' => 'required',
            'deskripsi' => 'required',
        ]);
        $jabatanpost = Jabatan::create($request->all());
        if ($jabatanpost) {
            return response()->json([
                'Message: ' => 'Succes!',
                'jabatan created: ' => $jabatanpost
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not create a new jabatan.',
            ], 500);
        }
    }

    public function upadatejabatan(Request $request, string $id)
    {
        $jabatanupdate = Jabatan::find($id);
        if ($jabatanupdate) {
            $validatedata = $request->validate([
                'nama_jabatan' => 'required',
                'deskripsi' => 'required',
            ]);
            $jabatanupdate->nama_jabatan = $validatedata['nama_jabatan'];
            $jabatanupdate->deskripsi = $validatedata['deskripsi'];
            if ($jabatanupdate->save()) {
                return response()->json([
                    'Message: ' => 'jabatan updated with success.',
                    'jabatan: ' => $jabatanupdate
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the jabatan.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the jabatan.',
            ], 500);
        }
    }

    public function deletejabatan(string $id)
    {
        $jabatandelete = Jabatan::find($id);
        if ($jabatandelete) {
            $jabatandelete->delete();
            return response()->json([
                'Message: ' => 'jabatan delete with success.',
                'jabatan: ' => $jabatandelete
            ], 200);
        } else {
            return response([
                'Message: ' => 'We could not delete the jabatan.',
            ], 500);
        }
    }
}
