<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\KurikulumResource;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KurikulumController extends Controller
{
    public function indexkurikulum(){
        $kurikulum = Kurikulum::all();
        return response()->json($kurikulum);
    }

    public function postkurikulum(Request $request){
        $this->validate($request, [
            'jenis_kurikulum'=> 'required',
            'deskripsi'=> 'required',
            'file_kurikulum'=> 'required|file|mimes:pdf',
        ]);
    
        $file = $request->file('file_kurikulum');
        // Simpan file kurikulum
        $path = $file->storeAs('public/kurikulum', $file->getClientOriginalName());
        if (!$path) {
            return response()->json(['Message: ' => 'Failed to save file'], 500);
        }
    
        // Buat entri kurikulum dengan nama file
        $kurikulumpost = Kurikulum::create([
            'jenis_kurikulum' => $request->input('jenis_kurikulum'),
            'deskripsi' => $request->input('deskripsi'),
            'file_kurikulum' => $file->getClientOriginalName(),
        ]);
    
        if ($kurikulumpost) {
            return response()->json([
                'Message: ' => 'Success!',
                'Kurikulum created: ' => $kurikulumpost
            ], 200);
        } else {
            Storage::delete($path);
            return response()->json([
                'Message: ' => 'We could not create a new kurikulum.',
            ], 500);
        }
    }

    public function updatekurikulum(Request $request, $id){
        $updatekurikulum = Kurikulum::find($id);
        $this->validate($request, [
            'jenis_kurikulum' => 'required',
            'deskripsi' => 'required',
            'file_kurikulum' => 'nullable|file|mimes:pdf',
        ]);
    
        $updatekurikulum->jenis_kurikulum = $request->input('jenis_kurikulum');
        $updatekurikulum->deskripsi = $request->input('deskripsi');
    
        if ($request->hasFile('file_kurikulum')) {
            // Hapus file kurikulum lama jika ada
            if ($updatekurikulum->file_kurikulum) {
                Storage::delete('public/kurikulum/' . $updatekurikulum->file_kurikulum);
            }
            // Simpan file kurikulum baru
            $file = $request->file('file_kurikulum');
            $path = $file->storeAs('public/kurikulum', $file->getClientOriginalName());
            $updatekurikulum->file_kurikulum = $file->getClientOriginalName();
        }
    
        if ($updatekurikulum->save()) {
            return response()->json(['status' => true, 'message' => 'Kurikulum updated successfully', 'kurikulum' => $updatekurikulum], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update kurikulum'], 500);
        }
    }
    
    public function deletekurikulum($id){
        $deletekurikulum = Kurikulum::find($id);
    
        if (!$deletekurikulum) {
            return response()->json(['status' => false, 'message' => 'Kurikulum not found'], 404);
        }
    
        // Hapus file kurikulum jika ada
        if ($deletekurikulum->file_kurikulum) {
            Storage::delete('public/kurikulum/' . $deletekurikulum->file_kurikulum);
        }
    
        if ($deletekurikulum->delete()) {
            return response()->json(['status' => true, 'message' => 'Kurikulum deleted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete kurikulum'], 500);
        }
    }
    
    
}
