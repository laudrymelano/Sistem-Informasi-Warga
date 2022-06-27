<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Surat;
use App\Models\SuratAttachment;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class WargaController extends Controller
{
    public function beranda()
    {
        if (Auth::guard('user_warga')->user() != null) {
            $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();

            $berita_utama = Berita::orderBy('id', 'desc')->limit(1)->get();
            $data_berita = Berita::orderBy('id', 'desc')->offset(1)->limit(6)->get();
            return view('warga.v_home', ['nama' => $nama, 'data_berita' => $data_berita, 'berita_utama' => $berita_utama]);
        }
    }

    public function beritaShow()
    {
        $berita_utama = Berita::orderBy('id', 'desc')->limit(1)->get();
        $data_berita = Berita::orderBy('id', 'desc')->offset(1)->limit(6)->get();

        return view('warga.v_home', ['data_berita' => $data_berita, 'berita_utama' => $berita_utama]);
    }

    public function detailBerita($id)
    {
        $detail_berita = Berita::where('id', $id)->get();

        return view('warga.v_berita_detail', ['detail_berita' => $detail_berita]);
    }

    public function detailListBerita($id)
    {
        $detail_berita = Berita::where('id', $id)->get();

        return view('warga.v_berita_list_detail', ['detail_berita' => $detail_berita]);
    }

    public function detailBeritaHome($id)
    {
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        $detail_berita = Berita::where('id', $id)->get();

        return view('warga.v_berita_detail', ['detail_berita' => $detail_berita, 'nama' => $nama]);
    }
    public function detailListBeritaBeranda($id)
    {
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        $detail_berita = Berita::where('id', $id)->get();

        return view('warga.v_berita_list_detail', ['detail_berita' => $detail_berita, 'nama' => $nama]);
    }

    public function listBerita()
    {
        $list_berita = Berita::orderBy('id', 'desc')->get();

        return view('warga.v_berita_list', ['list_berita' => $list_berita]);
    }

    public function listBeritaBeranda()
    {
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        $list_berita = Berita::orderBy('id', 'desc')->get();

        return view('warga.v_berita_list', ['list_berita' => $list_berita, 'nama' => $nama]);
    }

    public function surat()
    {
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        return view('warga.v_surat', ['nama' => $nama]);
    }

    public function suratPost(Request $request)
    {
        $cek = Surat::select('no_surat')->orderBy('id', 'desc')->limit(1)->value('no_surat');
        // $cek = DB::select(DB::raw("SELECT no_surat FROM surat ORDER BY id DESC LIMIT 1"));
        $ex = explode('/', $cek[0] ?? 0);
        // dd($ex);

        if (date('d') == '01') {
            $no = 1;
        } else {
            $no = (int)$ex[0] + 1;
        }

        $bulan = array('', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $rt = Warga::where('warga.nik', "=", Auth::guard('user_warga')->user()->nik)->value('rt');
        $rw = '007';
        $tahun = date('Y');
        $no_surat = $no . '/' . $rt . '/' . $rw . '/' . $bulan[date('n')] . '/' . $tahun;

        $request->validate([
            'id_warga' => 'required',
            'keperluan' => 'required',
            'keterangan' => 'required',
            'fileKTP' => 'image',
            'fileKK' => 'image'
        ]);

        Surat::create([
            'id_user_warga' => $request->id_warga,
            'id_status_surat' => '1',
            'no_surat' => $no_surat,
            'keperluan' => $request->keperluan,
            'keterangan' => $request->keterangan,
            'lainnya' => $request->keperluan_lainnya
        ]);

        $cekId[] = Surat::select('id')->orderBy('id', 'desc')->limit(1)->value('id');
        if ($cekId[0] == 1) {
            $id_surat = 1;
        } else {
            $id_surat = $cekId[0];
        }

        // dd($cekId);

        SuratAttachment::create([
            'id_surat' => $id_surat,
            'id_user_warga' => $request->id_warga,
            'fileKTP' => $request->file('fileKTP')->store('file-surat'),
            'fileKK' => $request->file('fileKK')->store('file-surat')
        ]);

        return redirect("/surat")->with('success', 'Pengajuan Surat Berhasil Dikirim');
    }

    public function suratHistory()
    {

        DB::statement("SET SQL_MODE=''");



        // $sSurat = Surat::where('id_user_warga', Auth::guard('user_warga')->user()->id)->where(function ($query) {
        //     $query->where('id_status_surat', '2')
        //         ->orWhere('id_status_surat', '3');
        // })->get();

        // dd($sSurat);

        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        $datas = SuratAttachment::where('surat.id_user_warga', Auth::guard('user_warga')->user()->id)
            ->join('surat', 'surat.id', '=', 'surat_attachment.id_surat')
            ->groupBy('surat.id')
            ->get();
        // dd($datas);
        return view('warga.v_surat_history', ['nama' => $nama, 'datas' => $datas]);
    }

    public function ktpRevisi(Request $request, $id)
    {
        if ($request->file('ktpEdit')) {
            if ($request->oldImageKTP != $request->ktpEdit) {
                Storage::delete($request->oldImageKTP);
            }
            $rules['ktpEdit'] = 'image';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('ktpEdit')) {
            $dataUpdate['fileKTP'] = $validatedData['ktpEdit']->store('file-surat');
        };

        SuratAttachment::where('id_surat', $id)->update($dataUpdate);
        $status_surat = Surat::where([
            ['id', $request->id_surat],
            ['id_user_warga', $id]
        ])->first();

        // dd($status_surat->id_status_surat);
        if ($status_surat->id_status_surat == '4' || $status_surat->id_status_surat == '5')
            Surat::where([
                ['id', $request->id_surat],
                ['id_user_warga', $id]
            ])
                ->update(['id_status_surat' => '1']);


        return redirect('/surat/history')->with('success', 'Foto KTP Anda berhasil di perbaharui');
    }
    public function kkRevisi(Request $request, $id)
    {
        if ($request->file('kkEdit')) {
            if ($request->oldImageKK) {
                Storage::delete($request->oldImageKK);
            }
            $rules['kkEdit'] = 'image';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('kkEdit')) {
            $dataUpdate['fileKK'] = $validatedData['kkEdit']->store('file-surat');
        };

        SuratAttachment::where('id_surat', $id)->update($dataUpdate);

        $status_surat = Surat::where([
            ['id', $request->id_surat],
            ['id_user_warga', $id]
        ])->first();

        // dd($status_surat->id_status_surat);
        if ($status_surat->id_status_surat == '4' || $status_surat->id_status_surat == '5')
            Surat::where([
                ['id', $request->id_surat],
                ['id_user_warga', $id]
            ])
                ->update(['id_status_surat' => '1']);


        return redirect('/surat/history')->with('success', 'Foto KK Anda berhasil di perbaharui');
    }

    public function viewSurat($id)
    {
        // $surat = Surat::where('id', $id)->first();
        $warga = Warga::join('user_warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat', 'user_warga.id', '=', 'surat.id_user_warga')
            ->where('surat.id', $id)->first();

        return view('v_surat_pengantar', ['warga' => $warga]);
    }

    public function OCR()
    {
        $gambar = SuratAttachment::select('file_kk')
            ->where('id', 1)->first();


        echo (new TesseractOCR('text.png'))
            ->run();
    }
}
