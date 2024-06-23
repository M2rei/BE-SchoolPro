<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Akreditasi;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;

class ProfileSekolahController extends Controller
{
    public function indexprofileschool()
    {
        $profile = ProfileSekolah::all();
        return response()->json($profile);
    }

    public function postprofile(Request $request)
    {
        $validatedData = $request->validate([
            'nama_sekolah' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required',
            'kode_pos' => 'required',
            'deskripsi_sejarah' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'motto' => 'required',
            'sambuatan_kepsek' => 'required',
            'tujuan_sekolah' => 'required',
            'logo_sekolah' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);
        $profilepost = new ProfileSekolah($validatedData);

        if ($request->hasFile('logo_sekolah')) {
            $filename = $request->file('logo_sekolah')->getClientOriginalName(); // get the file name
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
            $getfileExtension = $request->file('logo_sekolah')->getClientOriginalExtension(); // get the file extension
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
            $img_path = $request->file('logo_sekolah')->storeAs('public/logo_school', $createnewFileName); // get the image path
            $profilepost->logo_sekolah = $createnewFileName; // pass file name with column
        }


        if ($profilepost->save()) {
            return response()->json([
                'Message' => 'Success!',
                'profile_created' => $profilepost
            ], 200);
        } else {
            return response()->json([
                'Message' => 'We could not create a new profile.',
            ], 500);
        }
    }

    public function updateprofile1(Request $request, string $id)
    {
        $updateprofile1 = ProfileSekolah::find($id);
        if ($updateprofile1) {
            $validatedata = $request->validate([
                'nama_sekolah' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required',
                'email' => 'required',
                'kode_pos' => 'required',
                'deskripsi_sejarah' => 'required',
                'visi' => 'required',
                'misi' => 'required',
                'motto' => 'required',
                'sambuatan_kepsek' => 'required',
                'tujuan_sekolah' => 'required',
                'logo_sekolah' => 'required',

            ]);
            $updateprofile1->sambuatan_kepsek = $validatedata['sambuatan_kepsek'];
            if ($updateprofile1->save()) {

                return response()->json([
                    'Message: ' => 'updateprofile1 updated with success.',
                    'updateprofile1: ' => $updateprofile1
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the updateprofile1.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the updateprofile1.',
            ], 500);
        }
    }




    public function indexakreditasi()
    {

        $akreditasi = Akreditasi::all();
        return response()->json($akreditasi);
    }
}
