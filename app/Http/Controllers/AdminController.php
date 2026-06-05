<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\KategoriKeperluan;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // 1. Stat cards
        $tamuHariIni = Tamu::whereDate('created_at', Carbon::today())->count();
        $tamuBulanIni = Tamu::whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->count();
        $totalTamu = Tamu::count();

        // 2. Chart.js: Visits by Date (Last 7 Days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = Tamu::whereDate('created_at', $date)->count();
        }

        // 3. Category statistics (visits by category)
        $kategoriStats = KategoriKeperluan::withCount('tamus')
            ->orderBy('tamus_count', 'desc')
            ->get();

        // 4. Form URL for QR Code
        $formUrl = route('tamu.form');

        return view('admin.dashboard', compact(
            'tamuHariIni',
            'tamuBulanIni',
            'totalTamu',
            'chartLabels',
            'chartData',
            'kategoriStats',
            'formUrl'
        ));
    }

    /**
     * Display the list of guests.
     */
    public function index(Request $request)
    {
        $query = Tamu::with('kategori');

        // Search by name
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('nama', 'like', "%{$search}%");
        }

        // Filter by specific date
        if ($request->filled('tanggal')) {
            $tanggal = $request->input('tanggal');
            $query->whereDate('created_at', $tanggal);
        }

        $tamus = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.data_tamu', compact('tamus'));
    }

    /**
     * Delete a guest record.
     */
    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        return redirect()->route('admin.tamu')->with('success', 'Data tamu berhasil dihapus.');
    }

    /**
     * Display the reports page.
     */
    public function laporan(Request $request)
    {
        $query = Tamu::with('kategori');

        $startDate = $request->input('tgl_mulai');
        $endDate = $request->input('tgl_selesai');

        if ($startDate && $endDate) {
            // Include end of the day for the end date
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } elseif ($startDate) {
            $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif ($endDate) {
            $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $totalKunjungan = $query->count();
        $tamus = $query->orderBy('created_at', 'desc')->get();

        return view('admin.laporan', compact('tamus', 'totalKunjungan', 'startDate', 'endDate'));
    }

    /**
     * Export guest records to Excel.
     */
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('tgl_mulai');
        $endDate = $request->input('tgl_selesai');

        $fileName = 'laporan_tamu_meteor';
        if ($startDate && $endDate) {
            $fileName .= '_' . $startDate . '_to_' . $endDate;
        } elseif ($startDate) {
            $fileName .= '_from_' . $startDate;
        } elseif ($endDate) {
            $fileName .= '_until_' . $endDate;
        }
        $fileName .= '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TamuExport($startDate, $endDate),
            $fileName
        );
    }

    /**
     * Show the profile edit form.
     */
    public function showProfil()
    {
        $admin = Auth::user();
        return view('admin.profil', compact('admin'));
    }

    /**
     * Update admin profile details.
     */
    public function updateProfil(Request $request)
    {
        $admin = Admin::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $admin->update($request->only('name', 'username', 'email'));

        return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request)
    {
        $admin = Admin::findOrFail(Auth::id());

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        return redirect()->route('admin.profil')->with('success', 'Password berhasil diubah.');
    }
}
