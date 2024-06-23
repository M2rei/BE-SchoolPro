<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Akreditasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkreditasiController extends Controller
{
    public function indexakreditasi(){
        $akreditasi = Akreditasi::all();
        return response()->json($akreditasi);
    }
    public function indexdetailakreditasi($id){
        $detailakreditasi = Akreditasi::find($id);

        if($detailakreditasi){
            return response()->json($detailakreditasi);

        }else{
            return response()->json(null);
        }
    }

    public function postakreditasi(Request $request){
        $this->validate($request, [
            'profile_sekolah_id'=> 'required',
            'npsn'=> 'required',
            'status'=> 'required',
            'bentuk_pendidikan'=> 'required', 
            'status_kepemilikan'=> 'required',
            'sk_pendirian_sekolah'=> 'required',
            'tanggal_sk_pendirian'=> 'required',
            'sk_izin_operasional'=> 'required',
            'tanggal_sk_izin_operasional'=> 'required',
            'akreditasi'=> 'required',
            'file_berkas_akreditasi'=> 'required|file|mimes:pdf',
        ]);
    
        $file = $request->file('file_berkas_akreditasi');
        // Simpan file akreditasi
        $path = $file->storeAs('public/akreditasi', $file->getClientOriginalName());
        if (!$path) {
            return response()->json(['Message: ' => 'Failed to save file'], 500);
        }
    
        // Buat entri akreditasi dengan nama file
        $postakreditasi = Akreditasi::create([
            'profile_sekolah_id' => $request->input('profile_sekolah_id'),
            'npsn' => $request->input('npsn'),
            'status' => $request->input('status'),
            'bentuk_pendidikan' => $request->input('bentuk_pendidikan'),
            'status_kepemilikan' => $request->input('status_kepemilikan'),
            'sk_pendirian_sekolah' => $request->input('sk_pendirian_sekolah'),
            'tanggal_sk_pendirian' => $request->input('tanggal_sk_pendirian'),
            'sk_izin_operasional' => $request->input('sk_izin_operasional'),
            'tanggal_sk_izin_operasional' => $request->input('tanggal_sk_izin_operasional'),
            'akreditasi' => $request->input('akreditasi'),
            'file_berkas_akreditasi' => $file->getClientOriginalName(),
        ]);
    
        if ($postakreditasi) {
            return response()->json([
                'Message: ' => 'Success!',
                'akreditasi created: ' => $postakreditasi
            ], 200);
        } else {
            Storage::delete($path);
            return response()->json([
                'Message: ' => 'We could not create a new akreditasi.',
            ], 500);
        }
    }

    public function updateakreditasi(Request $request, $id){
        $updateakreditasi = Akreditasi::find($id);
        $this->validate($request, [
            'profile_sekolah_id'=> 'required',
            'npsn'=> 'required',
            'status'=> 'required',
            'bentuk_pendidikan'=> 'required', 
            'status_kepemilikan'=> 'required',
            'sk_pendirian_sekolah'=> 'required',
            'tanggal_sk_pendirian'=> 'required',
            'sk_izin_operasional'=> 'required',
            'tanggal_sk_izin_operasional'=> 'required',
            'akreditasi'=> 'required',
            'file_berkas_akreditasi'=> 'required|file|mimes:pdf',
        ]);
    
        $updateakreditasi->profile_sekolah_id = $request->input('profile_sekolah_id');
        $updateakreditasi->npsn = $request->input('npsn');
        $updateakreditasi->status = $request->input('status');
        $updateakreditasi->bentuk_pendidikan = $request->input('bentuk_pendidikan');
        $updateakreditasi->status_kepemilikan = $request->input('status_kepemilikan');
        $updateakreditasi->sk_pendirian_sekolah = $request->input('sk_pendirian_sekolah');
        $updateakreditasi->tanggal_sk_pendirian = $request->input('tanggal_sk_pendirian');
        $updateakreditasi->sk_izin_operasional = $request->input('sk_izin_operasional');
        $updateakreditasi->tanggal_sk_izin_operasional = $request->input('tanggal_sk_izin_operasional');
        $updateakreditasi->akreditasi = $request->input('akreditasi');
    
        if ($request->hasFile('file_berkas_akreditasi')) {
            // Hapus file akreditasi lama jika ada
            if ($updateakreditasi->file_berkas_akreditasi) {
                Storage::delete('public/akreditasi/' . $updateakreditasi->file_berkas_akreditasi);
            }
            // Simpan file akreditasi baru
            $file = $request->file('file_berkas_akreditasi');
            $path = $file->storeAs('public/akreditasi', $file->getClientOriginalName());
            $updateakreditasi->file_berkas_akreditasi = $file->getClientOriginalName();
        }
    
        if ($updateakreditasi->save()) {
            return response()->json(['status' => true, 'message' => 'akreditasi updated successfully', 'akreditasi' => $updateakreditasi], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update akreditasi'], 500);
        }
    }

    public function deleteakreditasi($id){
        $deleteakreditasi = Akreditasi::find($id);
    
        if (!$deleteakreditasi) {
            return response()->json(['status' => false, 'message' => 'akreditasi not found'], 404);
        }
    
        // Hapus file akreditasi jika ada
        if ($deleteakreditasi->file_berkas_akreditasi) {
            Storage::delete('public/akreditasi/' . $deleteakreditasi->file_berkas_akreditasi);
        }
    
        if ($deleteakreditasi->delete()) {
            return response()->json(['status' => true, 'message' => 'akreditasi deleted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete akreditasi'], 500);
        }
    }
}
