<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Validator;

class SiswaController extends Controller
{
    protected $request;
    public function __construct(Request $req){
        $this->request = $req;
    }

    public function index()
    {
        $siswa_list = Siswa::orderBy('nama_siswa','asc')
                            -> paginate(3);
        $jumlah_siswa = Siswa::count();
	    return view('siswa.index',compact('siswa_list','jumlah_siswa'));
    }

    public function create()
    {
        $halaman = 'siswa';
        return view('siswa.create',compact('halaman'));
    }

    public function show($id){ 
        $halaman    = 'siswa';
        $siswa      = Siswa::findOrFail($id);
        return view('siswa.show',compact('halaman','siswa'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nisn' => 'required|string|size:4|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        if($validator->fails()){
            return redirect('siswa/create')
            ->withInput()
            ->withError($validator);
        }
        // $siswa = new Siswa;
        // $siswa->nisn            = $request->nisn;
        // $siswa->nama_siswa      = $request->nama_siswa;
        // $siswa->tanggal_lahir   = $request->tanggal_lahir;
        // $siswa->jenis_kelamin   = $request->jenis_kelamin;
        // $siswa->save();
        Siswa::create($input);
        return redirect('siswa');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit',compact('siswa'));
    }

    public function update($id, Request $request){
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());
        return redirect('siswa');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect('siswa');
    }

    public function dateMutator()
    {
        $siswa = Siswa::findOrFail(1);
        return "Umur {$siswa->nama_siswa} adalah 
        {$siswa->tanggal_lahir->age} tahun.";
    }
}
