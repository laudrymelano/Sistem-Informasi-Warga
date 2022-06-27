<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RtController extends Controller
{
    public function dashboardRT()
    {
        return view('rt.v_dashboard');
    }

    public function suratMasuk()
    {

        $rt = \Str::substr(Auth::user()->name, 2);

        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where([
                ['warga.rt', $rt],
                ['surat.id_status_surat', '1']
            ])
            ->count();

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where([
                ['warga.rt', $rt],
                ['surat.id_status_surat', '1']
            ])
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga')
            ->get();

        // dd($datas);

        return view('rt.v_surat_masuk', ['datas' => $datas, 'jml' => $jml]);
    }

    public function suratDisetujui()
    {

        $rt = \Str::substr(Auth::user()->name, 2);

        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where('warga.rt', $rt)->where(function ($query) {
                $query->where('surat.id_status_surat', '2')
                    ->orWhere('surat.id_status_surat', '3');
            })
            ->count();

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where('warga.rt', $rt)->where(function ($query) {
                $query->where('surat.id_status_surat', '2')
                    ->orWhere('surat.id_status_surat', '3');
            })
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.id_status_surat')
            ->get();

        // dd($datas);

        return view('rt.v_surat_disetujui', ['datas' => $datas, 'jml' => $jml]);
    }

    public function suratDitolak()
    {

        $rt = \Str::substr(Auth::user()->name, 2);

        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where([
                ['warga.rt', $rt],
                ['surat.id_status_surat', '4']
            ])
            ->count();

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where([
                ['warga.rt', $rt],
                ['surat.id_status_surat', '4']
            ])
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.catatan')
            ->get();

        $sSurat = Surat::join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where([
                ['warga.rt', $rt],
                ['surat.id_status_surat', '4']
            ])
            ->select('catatan')
            ->first();

        // dd($sSurat);

        return view('rt.v_surat_ditolak', ['datas' => $datas, 'jml' => $jml, 'sSurat' => $sSurat]);
    }

    public function acceptSurat($id)
    {
        Surat::where('id', $id)
            ->update(['id_status_surat' => '2']);
        return redirect('rt/surat/disetujui')->with('success', "Surat Berhasil disetujui");
    }

    public function rejectSurat($id)
    {
        Surat::where('id', $id)
            ->update(['id_status_surat' => '4']);
        return redirect('rt/surat/ditolak')->with('warning', "Surat Berhasil ditolak, harap memberi catatan");
    }

    public function noteSurat(Request $request, $id)
    {
        $request->validate([
            'note' => 'required'
        ]);

        Surat::find($id)
            ->update(['catatan' => $request->note]);
        return redirect('rt/surat/ditolak')->with('success', "Catatan sudah ditambahkan");
    }

    public function viewSuratRt($id)
    {
        $warga = Warga::join('user_warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat', 'user_warga.id', '=', 'surat.id_user_warga')
            ->where('surat.id', $id)->first();

        return view('v_surat_pengantar', ['warga' => $warga]);
    }

    public function cariSurat(Request $request)
    {
        $rt = \Str::substr(Auth::user()->name, 2);

        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where('warga.rt', $rt)->where(function ($query) {
                $query->where('surat.id_status_surat', '2')
                    ->orWhere('surat.id_status_surat', '3');
            })
            ->count();

        $fdate = $request->input('fdate');
        $tdate = $request->input('tdate');

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where('warga.rt', $rt)->where(function ($query) {
                $query->where('surat.id_status_surat', '2')
                    ->orWhere('surat.id_status_surat', '3');
            })
            ->where('surat.updated_at', '>=', $fdate . ' 00:00:00')
            ->where('surat.updated_at', '<=', $tdate . ' 23:59:59')
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.id_status_surat')
            ->get();

        // dd($datas);
        return view('rt.v_surat_disetujui', ['datas' => $datas, 'jml' => $jml]);
    }
}
