<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    public function indexInformasi()
    {
        $informasi = Informasi::with('user', 'gurukaryawan')->get();
        return response()->json($informasi);
    }

    public function indexdetailinformasi($id)
    {
        $detailinformasi = Informasi::find($id);

        if ($detailinformasi) {
            return response()->json($detailinformasi);
        } else {
            return response()->json(null);
        }
    }

    public function postinformasi(Request $request)
    {
        $this->validate($request, [
            'users_id' => 'required',
            'guru_karyawan_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
            'kategori' => 'required',
            'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);
        $informasipost = Informasi::create($request->all());

        if ($request->hasFile('gambar')) {
            $filename = $request->file('gambar')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('gambar')->storeAs('public/informasi', $createnewFileName);
            $informasipost->gambar = $createnewFileName;
            $informasipost->save();
        }
        if ($informasipost) {
            return response()->json([
                'Mesaage: ' => 'Succes!',
                'Informasi create: ' => $informasipost
            ], 200);
        } else {
            return response([
                'Message: ' => ' we could not create a new siswa.'
            ], 500);
        }
    }
    public function updateinformasi(Request $request, string $id)
    {
        $updateinformasi = Informasi::find($id);
        if ($updateinformasi) {
            $validatedata = $request->validate([
                'users_id' => 'required',
                'guru_karyawan_id' => 'required',
                'judul' => 'required',
                'isi' => 'required',
                'kategori' => 'required',
                'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
            ]);
            $updateinformasi->users_id = $validatedata['users_id'];
            $updateinformasi->guru_karyawan_id = $validatedata['guru_karyawan_id'];
            $updateinformasi->judul = $validatedata['judul'];
            $updateinformasi->isi = $validatedata['isi'];
            $updateinformasi->kategori = $validatedata['kategori'];

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($updateinformasi->gambar) {
                    Storage::delete('public/informasi/' . $updateinformasi->gambar);
                }

                $filename = $request->file('gambar')->getClientOriginalName();
                $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
                $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
                $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
                $img_path = $request->file('gambar')->storeAs('public/informasi', $createnewFileName);
                $updateinformasi->gambar = $createnewFileName;
            }
            if ($updateinformasi->save()) {
                return response()->json([
                    'Message: ' => 'Informasi updated with success.',
                    'Informasi: ' => $updateinformasi
                ], 200);
            } else {
                return response([
                    'Message: ' => 'We could not update the Informasi.',
                ], 500);
            }
        } else {
            return response([
                'Message: ' => 'We could not find the Informasi.',
            ], 500);
        }
    }
    public function deleteinformasi(string $id)
    {
        $deleteinformasi = Informasi::find($id);
        // Delete image if exists
        if ($deleteinformasi->gambar) {
            Storage::delete('public/informasi/' . $deleteinformasi->gambar);
        }

        if ($deleteinformasi->delete()) {
            return response()->json([
                'message' => 'Informasi deleted successfully.',
                'informasi' => $deleteinformasi
            ], 200);
        } else {
            return response([
                'message' => 'Failed to delete informasi.'
            ], 500);
        }
    }
}
