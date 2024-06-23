<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Sarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // BAGIAN GALERI
    public function indexgaleri()
    {
        $galeri = Galeri::all();
        return response()->json($galeri);
    }
    public function indexdetailgaleri($id){
        $detailgaleri = Galeri::find($id);

        if($detailgaleri){
            return response()->json($detailgaleri);

        }else{
            return response()->json(null);
        }
    }

    public function postgaleri(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
            'kategori' => 'required',
        ]);

        $postgambar = new Galeri();
        $postgambar->judul = $request->judul;
        $postgambar->kategori = $request->kategori;

        if ($request->hasFile('gambar')) {
            $filename = $request->file('gambar')->getClientOriginalName(); // get the file name
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension(); // get the file extension
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
            $img_path = $request->file('gambar')->storeAs('public/post_img', $createnewFileName); // get the image path
            $postgambar->gambar = $createnewFileName; // pass file name with column
        }

        if ($postgambar->save()) {
            return response()->json(['status' => true, 'message' => "gambar uploaded successfully"], 200);
        } else {
            return response()->json(['status' => false, 'message' => "Error: gambar not uploaded successfully"], 500);
        }
    }

    public function updategaleri(Request $request, $id)
    {
        $updategaleri = Galeri::find($id);

        if (!$updategaleri) {
            return response()->json(['status' => false, 'message' => 'Galeri not found'], 404);
        }

        $this->validate($request, [
            'judul' => 'required',
            'kategori' => 'required',
        ]);

        $updategaleri->judul = $request->input('judul');
        $updategaleri->kategori = $request->input('kategori');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($updategaleri->gambar) {
                Storage::delete('public/post_img/' . $updategaleri->gambar);
            }
            
            $filename = $request->file('gambar')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('gambar')->storeAs('public/post_img', $createnewFileName);
            $updategaleri->gambar = $createnewFileName;
        }

        if ($updategaleri->save()) {
            return response()->json(['status' => true, 'message' => 'Galeri updated successfully', 'galeri' => $updategaleri], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update galeri'], 500);
        }
    }


    public function deletegaleri($id)
    {
        $deletegaleri = Galeri::find($id);
        if (!$deletegaleri) {
            return response()->json(['status' => false, 'message' => 'Galeri not found'], 404);
        }
        // Hapus gambar dari penyimpanan jika ada
        if ($deletegaleri->galeri) {
            Storage::delete('public/post_img/' . $deletegaleri->galeri);
        }
        if ($deletegaleri->delete()) {
            return response()->json(['status' => true, 'message' => 'Galeri deleted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete galeri'], 500);
        }
    }

    //BAGIAN SARPRAS
    public function indexsarpras()
    {
        $sarpras = Sarpras::all();
        return response()->json($sarpras);
    }

    public function indexdetailsarpras($id){
        $detailsarpras = Sarpras::find($id);

        if($detailsarpras){
            return response()->json($detailsarpras);

        }else{
            return response()->json(null);
        }
    }

    public function postsarpras(Request $request)
    {
        $this->validate($request, [
            'nama_sarpras' => 'required',
            'deskripsi'=> 'required',
            'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048',
        ]);

        $postsarpras = new Sarpras();
        $postsarpras->nama_sarpras = $request->nama_sarpras;
        $postsarpras->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $filename = $request->file('gambar')->getClientOriginalName(); // get the file name
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension(); // get the file extension
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
            $img_path = $request->file('gambar')->storeAs('public/post_img', $createnewFileName); // get the image path
            $postsarpras->gambar = $createnewFileName; // pass file name with column
        }

        if ($postsarpras->save()) {
            return response()->json(['status' => true, 'message' => "gambar uploaded successfully"], 200);
        } else {
            return response()->json(['status' => false, 'message' => "Error: gambar not uploaded successfully"], 500);
        }
    }

    public function updatesarpras(Request $request, $id)
    {
        $updatesarpras = Sarpras::find($id);
        // dd($updatesarpras);

        if (!$updatesarpras) {
            return response()->json([
                'status' => false, 
                'message' => 'sarpras not found'], 404);
        }
        $request->validate([
            'nama_sarpras' => 'required',
            'deskripsi'=> 'required',
            // 'gambar' => 'required|image|mimetypes:image/jpeg,image/jpg,image/png|max:2048'
        ]);
        // dd($request->input('judul'));
        $updatesarpras->nama_sarpras = $request->input('nama_sarpras');
        $updatesarpras->deskripsi = $request->input('deskripsi');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($updatesarpras->gambar) {
                Storage::delete('public/post_img/' . $updatesarpras->gambar);
            }
            
            $filename = $request->file('gambar')->getClientOriginalName();
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME);
            $getfileExtension = $request->file('gambar')->getClientOriginalExtension();
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension;
            $img_path = $request->file('gambar')->storeAs('public/post_img', $createnewFileName);
            $updatesarpras->gambar = $createnewFileName;
        }

        if ($updatesarpras->save()) {
            return response()->json(['status' => true, 'message' => 'sarpras updated successfully', 'sarpras' => $updatesarpras], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update sarpras'], 500);
        }
    }

    public function deletesarpras($id)
    {
        $deletesarpras = Sarpras::find($id);
        if (!$deletesarpras) {
            return response()->json(['status' => false, 'message' => 'sarpras not found'], 404);
        }
        // Hapus gambar dari penyimpanan jika ada
        if ($deletesarpras->sarpras) {
            Storage::delete('public/post_img/' . $deletesarpras->sarpras);
        }
        if ($deletesarpras->delete()) {
            return response()->json(['status' => true, 'message' => 'sarpras deleted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete sarpras'], 500);
        }
    }
}
