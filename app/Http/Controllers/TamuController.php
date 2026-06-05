<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeperluan;
use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    /**
     * Show the guest book entry form.
     */
    public function showForm()
    {
        $kategori = KategoriKeperluan::orderBy('id', 'asc')->get();
        return view('tamu.form', compact('kategori'));
    }

    /**
     * Store a newly created guest record.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|regex:/^[0-9]+$/|min:9|max:15',
            'alamat' => 'required|string',
            'kategori_id' => 'required|exists:kategori_keperluans,id',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap terlalu panjang (maksimal 255 karakter).',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'nomor_hp.min' => 'Nomor HP minimal 9 digit.',
            'nomor_hp.max' => 'Nomor HP maksimal 15 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kategori_id.required' => 'Keperluan kunjungan wajib dipilih.',
            'kategori_id.exists' => 'Keperluan kunjungan yang dipilih tidak valid.',
        ]);

        $tamu = Tamu::create($validatedData);

        return redirect()->route('tamu.sukses')->with([
            'nama_tamu' => $tamu->nama,
            'success_visit' => true
        ]);
    }

    /**
     * Show the success welcome page.
     */
    public function sukses()
    {
        $namaTamu = session('nama_tamu');

        if (!$namaTamu && !session('success_visit')) {
            return redirect()->route('tamu.form');
        }

        return view('tamu.sukses', compact('namaTamu'));
    }
}
