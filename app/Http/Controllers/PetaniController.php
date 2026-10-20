<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use App\Models\Petani;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // Deklarasi variabel title yang akan tampil pada view
    //     $title = "Daftar Petani";

    //     // (object) digunakan untuk instansiasikan array menjadi object
    //     // agar data dapat ditampilkan dalam object ($item->nik)
    //     // jika tidak menggunakan (object), data ditampilkan menggunakan array ($item['nik'])
    //     $petani = [
    //         (object)[
    //             'id_penjual'    => 1,
    //             'nama'          => 'Petani 1',
    //             'nik'           => '123456',
    //             'alamat'        => 'Singapadu',
    //             'nama_kelompok' => 'Jaya Mula',
    //             'telp'          => '082772892',
    //             'foto'          => 'uploads/petanis/petani1.png'
    //         ],
    //         (object)[
    //             'id_penjual'    => 2,
    //             'nama'          => 'Petani 2',
    //             'nik'           => '32145',
    //             'alamat'        => 'Tegalalang',
    //             'nama_kelompok' => 'Tani Maju',
    //             'telp'          => '988292882',
    //             'foto'          => 'uploads/petanis/petani2.png'
    //         ]
    //     ];

    //     // Dapat juga disimpan dalam sebuah collection data
    //     // sehingga data petani dapat menggunakan beberapa fungsi collection Laravel
    //     $petani = collect($petani);

    //     // Mengirimkan seluruh variabel untuk ditampilkan pada view
    //     return view('admin.daftarpetani', compact('title', 'petani'));
    // }


    public function index(Request $request)
    {
        // Definisikan $title jika belum ada
        $title = "Daftar Petani";

        // Kali ini kita akan mencoba menampilkan seluruh data petani menggunakan helper Eloquent
        // fungsi penggunaan eloquent dapat diakses lebih detail pada dokumentasi Laravel 8

        // atau bisa juga menampilkan data menggunakan pagination
        $petanis = Petani::paginate(2);

        // untuk menampilkan object data dapat menggunakan fungsi berikut
        // dd($petanis);

        $kelompoks = KelompokTani::all();

        $petaniQuery = Petani::with('kelompoktani');

        if ($request->filled('search')) {
            $search = $request->search;

            $petaniQuery->where('nama', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%");
        }

        if ($request->filled('kelompok')) {
            $petaniQuery->where(
                'id_kelompok_tani',
                $request->kelompok
            );
        }

        $petanis = $petaniQuery->paginate(2);

        return view('admin.daftarpetani', compact(
            'title',
            'petanis',
            'kelompoks'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // menampilkan halaman input data
        // mengambil referensi kelompok tani
        $title = "Input Petani";
        $kelompoks = KelompokTani::all();

        // memanggil halaman input petani pada views/admin
        return view('admin.inputpetani', compact('title', 'kelompoks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // set pesan kesalahan
        $messages = [
            'required' => 'Kolom :attribute harus lengkap',
            'numeric'  => 'Kolom :attribute Harus Angka.',
            'file'     => 'Perhatikan format dan ukuran file'
        ];

        // untuk menyimpan data
        $validasi = $request->validate([
            'nik'              => 'required|numeric|digits:16',
            'nama'             => 'required',
            'alamat'           => '',
            'telp'             => 'required',
            'foto'             => 'required|mimes:png,jpg|max:1024',
            'id_kelompok_tani' => 'required',
            'status'           => ''
        ], $messages);

        try {
            // memberikan kombinasi time dan nama file asli untuk nama foto
            $fileName = time() . $request->file('foto')->getClientOriginalName();

            // menggunakan fungsi storeAs untuk upload dan mengambil path upload
            $path = $request->file('foto')->storeAs('uploads/petanis', $fileName, 'public');

            // menyimpan path upload file pada kolom foto
            $validasi['foto'] = $path;

            $response = Petani::create($validasi);
            return redirect('petani');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // menampilkan data edit
        $title = "Input Petani";
        $kelompoks = KelompokTani::all();
        $petani = Petani::find($id);

        if ($petani != NULL) {
            $title = "Edit Data " . $petani->nama;
            return view('admin.inputpetani', compact('title', 'kelompoks', 'petani'));
        } else {
            return view('admin.inputpetani', compact('title', 'kelompoks'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // untuk save update
        $validasi = $request->validate([
            'nik'              => 'required|numeric',
            'nama'             => 'required',
            'alamat'           => '',
            'telp'             => 'required',
            'foto'             => '',
            'id_kelompok_tani' => 'required',
            'status'           => ''
        ]);

        try {
            // mengambil kondisi hanya saat file foto diisi
            if ($request->file('foto')) {
                $fileName = time() . $request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('uploads/petanis', $fileName, 'public');
                $validasi['foto'] = $path;
            }

            $response = Petani::find($id);
            $response->update($validasi);

            return redirect('petani');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Cari data berdasarkan ID (Primary Key: id_penjual / id)
        $petani = Petani::where('id_penjual', $id)->firstOrFail();

        // // 2. (Opsional) Hapus file foto dari folder storage jika ada
        // if ($petani->foto && Storage::disk('public')->exists($petani->foto)) {
        //     Storage::disk('public')->delete($petani->foto);
        // }

        // 3. Hapus data dari database
        $petani->delete();

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('petani.index')->with('success', 'Data petani berhasil dihapus!');
    }
}
