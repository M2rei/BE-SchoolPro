<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Akreditasi;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    
    public function updateprofileschool(Request $request, string $id)
    {
        $updateprofileschool = ProfileSekolah::find($id);
        if ($updateprofileschool) {
            $validatedata = $request->validate([
                'nama_sekolah' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required',
                'email' => 'required',
                'kode_pos' => 'required',
                'logo_sekolah' => 'required',

            ]);
            $updateprofileschool->nama_sekolah = $validatedata['nama_sekolah'];
            $updateprofileschool->alamat = $validatedata['alamat'];
            $updateprofileschool->nomor_telepon = $validatedata['nomor_telepon'];
            $updateprofileschool->email = $validatedata['email'];
            $updateprofileschool->kode_pos = $validatedata['kode_pos'];
            if ($request->hasFile('logo_sekolah')) {
                if ($updateprofileschool->logo_sekolah) {
                    Storage::delete('public/updateprofileschool/' . $updateprofileschool->logo_sekolah);
                }
                
                $filename = $request->file('logo_sekolah')->getClientOriginalName();
                $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); 
                $getfileExtension = $request->file('logo_sekolah')->getClientOriginalExtension(); 
                $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; 
                $img_path = $request->file('logo_sekolah')->storeAs('public/updateprofileschool', $createnewFileName); 
                $updateprofileschool->logo_sekolah = $createnewFileName;
            }

            if ($updateprofileschool->save()) {

                return response()->json([
                    'Message: ' => 'updateprofileschool updated with success.',
                    'updateprofileschool: ' => $updateprofileschool
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the updateprofileschool.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the updateprofileschool.',
            ], 500);
        }
    }

    public function updatevisimisi(Request $request, string $id)
    {
        $updatevisimisi = ProfileSekolah::find($id);
        if ($updatevisimisi) {
            $validatedata = $request->validate([
                'visi' => 'required',
                'misi' => 'required',

            ]);
            $updatevisimisi->visi = $validatedata['visi'];
            $updatevisimisi->misi = $validatedata['misi'];
            if ($updatevisimisi->save()) {

                return response()->json([
                    'Message: ' => 'updatevisimisi updated with success.',
                    'updatevisimisi: ' => $updatevisimisi
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the updatevisimisi.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the updatevisimisi.',
            ], 500);
        }
    }

    public function updatesambutan(Request $request, string $id)
    {
        $updatesambutan = ProfileSekolah::find($id);
        if ($updatesambutan) {
            $validatedata = $request->validate([
                'sambuatan_kepsek' => 'required',

            ]);
            $updatesambutan->sambuatan_kepsek = $validatedata['sambuatan_kepsek'];
            if ($updatesambutan->save()) {

                return response()->json([
                    'Message: ' => 'updatesambutan updated with success.',
                    'updatesambutan: ' => $updatesambutan
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the updatesambutan.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the updatesambutan.',
            ], 500);
        }
    }
    public function updatesejarah(Request $request, string $id)
    {
        $updatesejarah = ProfileSekolah::find($id);
        if ($updatesejarah) {
            $validatedata = $request->validate([
                'deskripsi_sejarah' => 'required',
                'motto' => 'required',
                'tujuan_sekolah' => 'required',
            ]);
            $updatesejarah->deskripsi_sejarah = $validatedata['deskripsi_sejarah'];
            $updatesejarah->motto = $validatedata['motto'];
            $updatesejarah->tujuan_sekolah = $validatedata['tujuan_sekolah'];
            if ($updatesejarah->save()) {

                return response()->json([
                    'Message: ' => 'updatesejarah updated with success.',
                    'updatesejarah: ' => $updatesejarah
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the updatesejarah.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the updatesejarah.',
            ], 500);
        }
    }
}
