<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Carbon\Carbon;
use Cloudinary;

class BukuController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        // $bukus= Buku::all();
        $bukus= Buku::latest()->get();
        
        return view('Buku.index',compact('bukus')); 

    }
    public function cetak(){
        $bukus= Buku::latest()->get();
        return view('Buku.cetak',compact('bukus')); 

    }
    public function create(){
        return view('Buku.create');
    }
    public function store(Request $request){
  
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->judulBuku;
            $uploadedFile = $request->file('gambar')->storeOnCloudinaryAs('frameworkpro',$fileName);

            $gambar = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();

            // dd($request->all());

            Buku::create([
                'judulBuku' =>  $request->judulBuku,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'gambar' => $gambar,
                'public_id' => $public_id,
            ]);
    

            

            
        // ]);
        return redirect() ->route('buku.index');
    }
    public function destroy($id){
        $buku = Buku::findOrFail($id);
        // dd($buku);
        Cloudinary::destroy($buku->public_id);
        $buku -> delete();
        return redirect() ->route('buku.index');

        
    }
    public function edit($id){
        $buku = Buku::findOrFail($id);
        return view('Buku.edit',compact('buku')); 

    }
    public function update(Request $request,$id){
        $buku = Buku::findOrFail($id);

        if($request->gambar){
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->judulBuku;
            Cloudinary::destroy($buku->public_id);

            $uploadedFile = $request->file('gambar')->storeOnCloudinaryAs('frameworkpro',$fileName);

            $gambar = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();
        }

        $buku -> update([
            'judulBuku' => $request -> judulBuku,
            'penulis' => $request -> penulis,
            'penerbit' =>$request -> penerbit,
            'gambar' =>$request -> gambar ? $gambar :$buku->gambar,
            'public_id' => $request -> gambar ? $public_id : $buku->public_id


        ]);
        // $ubah = Buku::findOrFail($id);
        // $awal = $ubah->gambar;

        // $buku = [
        //     'judulBuku' => $request['judulBuku'],
        //     'penulis' => $request['penulis'],
        //     'penerbit' => $request['penerbit'],
        //     'gambar' => $awal
        // ];
        // $request->gambar->move(public_path().'/img', $awal);
        // $ubah->update($buku);
        return redirect() ->route('buku.index');

    }
}
