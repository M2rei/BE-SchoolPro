<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AkademikResource;
use App\Models\Akademik;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AkademikController extends Controller
{
    public function indexakademik()
    {
        $akademiks = Akademik::with('kurikulum')->get();
        return response()->json($akademiks);
    }

    public function postakademik(Request $request)
    {
        $this->validate($request, [
            'kurikulum_id' => 'nullable',
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            // 'tanggal_mulai' => 'nullable',
            // 'tanggal_selesai' => 'nullable',
            'deskripsi' => 'required',
            'file_berkas' => 'required|file|mimes:pdf',
            'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);

        $file = $request->file('file_berkas');
        // Simpan file kurikulum
        $path = $file->storeAs('public/akademik', $file->getClientOriginalName());
        if (!$path) {
            return response()->json(['Message: ' => 'Failed to save file'], 500);
        }

        if ($request->hasFile('gambar')) {
            $filename = $request->file('gambar')->getClientOriginalName(); 
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); 
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; 
            $gambar_path  = $request->file('gambar')->storeAs('public/imgakademik', $createnewFileName); 
        }

        $postakademik = Akademik::create([
            'kurikulum_id' => 1,
            'tahun_ajaran' => $request->input('tahun_ajaran'),
            'semester' => $request->input('semester'),
            'tanggal_mulai' => '2020-04-11',
            'tanggal_selesai' => '2020-04-12',
            'deskripsi' => $request->input('deskripsi'),
            'file_berkas' => $file->getClientOriginalName(),
            'gambar' => $createnewFileName,
            // ubah dikit
        ]);

        if ($postakademik) {
            return response()->json([
                'Message: ' => 'Success!',
                'akademik created: ' => $postakademik
            ], 200);
        } else {
            Storage::delete($path);
            return response()->json([
                'Message: ' => 'We could not create a new akademik.',
            ], 500);
        }
    }

    public function updateakademik(Request $request, string $id)
    {
        $updateakademik = Akademik::find($id);
        $this->validate($request, [
            'kurikulum_id' => 'required',
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'deskripsi' => 'required',
            'file_berkas' => 'nullable|file|mimes:pdf',
            'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);


        $updateakademik->kurikulum_id = $request->input('kurikulum_id');
        $updateakademik->tahun_ajaran = $request->input('tahun_ajaran');
        $updateakademik->semester = $request->input('semester');
        $updateakademik->tanggal_mulai = $request->input('tanggal_mulai');
        $updateakademik->tanggal_selesai = $request->input('tanggal_selesai');
        $updateakademik->deskripsi = $request->input('deskripsi');

        if ($request->hasFile('file_berkas')) {
            // Hapus file kurikulum lama jika ada
            if ($updateakademik->file_berkas) {
                Storage::delete('public/akademik/' . $updateakademik->file_berkas);
            }
            // Simpan file kurikulum baru
            $file = $request->file('file_berkas');
            $path = $file->storeAs('public/akademik', $file->getClientOriginalName());
            $updateakademik->file_berkas = $file->getClientOriginalName();
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($updateakademik->gambar) {
                Storage::delete('public/imgakademik/' . $updateakademik->gambar);
            }
            
            $filename = $request->file('gambar')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('gambar')->storeAs('public/imgakademik', $createnewFileName);
            $updateakademik->gambar = $createnewFileName;
        }

        if ($updateakademik->save()) {
            return response()->json(['status' => true, 'message' => 'akademik updated successfully', 'akademik' => $updateakademik], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update akademik'], 500);
        }
    }

    public function deleteakademik(string $id)
    {
        $deleteakademik = Akademik::find($id);

        if (!$deleteakademik) {
            return response()->json(['status' => false, 'message' => 'Kurikulum not found'], 404);
        }

        // Hapus file kurikulum jika ada
        if ($deleteakademik->file_kurikulum) {
            Storage::delete('public/akademik/' . $deleteakademik->file_kurikulum);
        }
        if ($deleteakademik->gambar) {
            Storage::delete('public/imgakademik/' . $deleteakademik->gambar);
        }

        if ($deleteakademik->delete()) {
            return response()->json(['status' => true, 'message' => 'akademik deleted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete akademik'], 500);
        }
    }
}
