<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Calon;
use App\Models\HasilVoting;
use App\Models\Surat;
use App\Models\SuratAttachment;
use App\Models\Voting;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Crypt;

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
            ->paginate(5);
        // dd($datas);
        $srcTanggal = now()->toDateTimeString();


        return view('warga.v_surat_history', ['nama' => $nama, 'datas' => $datas,  'srcTanggal' => $srcTanggal]);
    }

    public function searchKeperluanSurat(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        $search  = $request->get('searchKeperluanSurat');
        $searchTanggal  = $request->get('searchTanggal');
        if (empty($searchTanggal)) {
            $datas = SuratAttachment::where('surat.id_user_warga', Auth::guard('user_warga')->user()->id)
                ->where('surat.keperluan', 'like', '%' . $search . '%')
                ->join('surat', 'surat.id', '=', 'surat_attachment.id_surat')
                ->groupBy('surat.id')
                ->paginate(5);
        }
        $datas = SuratAttachment::where('surat.id_user_warga', Auth::guard('user_warga')->user()->id)
            ->where('surat.keperluan', 'like', '%' . $search . '%')
            ->where('surat.created_at', 'like', '%' . $searchTanggal . '%')
            ->join('surat', 'surat.id', '=', 'surat_attachment.id_surat')
            ->groupBy('surat.id')
            ->paginate(5);

        return view('warga.v_surat_history', ['nama' => $nama, 'datas' => $datas,  'srcTanggal' =>  $searchTanggal]);
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
        $status_surat = Surat::select('id_status_surat')->where('id', $request->id_surat)->first();

        // dd($status_surat->id_status_surat);
        if ($status_surat->id_status_surat == '4' || $status_surat->id_status_surat == '5')
            Surat::where('id', $request->id_surat)
                ->update(['id_status_surat' => '1']);


        return redirect('/surat/history')->with('success', 'Foto KTP Anda berhasil diperbaharui');
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

        $status_surat = Surat::select('id_status_surat')->where('id', $request->id_surat)->first();

        // dd($status_surat->id_status_surat);
        if ($status_surat->id_status_surat == '4' || $status_surat->id_status_surat == '5')
            Surat::where('id', $request->id_surat)
                ->update(['id_status_surat' => '1']);


        return redirect('/surat/history')->with('success', 'Foto KK Anda berhasil diperbaharui');
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

    public function eVoting()
    {
        $rt = Warga::select('rt')->where('nik', Auth::guard('user_warga')->user()->nik)->value('rt');
        $status_voting = Voting::select('status')->where('rt', $rt)->latest()->value('status');


        // dd($status_voting);
        if ($status_voting == '0' || $status_voting == '2') {
            $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
            // $rt = Warga::select('rt')->where('nik', Auth::guard('user_warga')->user()->nik)->value('rt');
            $datas = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->get();

            $judul = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->select('voting.judul')
                ->value('voting.judul');

            $periode = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->select('voting.periode')
                ->value('voting.periode');

            return view('warga.v_e-voting', ['nama' => $nama, 'judul' => $judul, 'periode' => $periode, 'datas' => $datas]);
        } else {
            $id_user = Auth::guard('user_warga')->user()->id;
            $id_warga = HasilVoting::select('id_user_warga', 'id_voting')->get();
            $id_vote = Voting::select('id')->where('rt', $rt)->latest()->value('id');
            // $id_hasil = HasilVoting::select('id_voting')->where('id_user_warga', $id_warga)->first();
            // dd($id_warga);



            // dd($status_voting);
            foreach ($id_warga as $data) {
                if (Crypt::decryptString($data->id_user_warga) == $id_user && $data->id_voting == $id_vote) {
                    return redirect('/evoting/selesai');
                }
            }

            $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
            // $rt = Warga::select('rt')->where('nik', Auth::guard('user_warga')->user()->nik)->value('rt');
            $datas = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->get();

            $judul = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->select('voting.judul')
                ->value('voting.judul');

            $periode = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
                ->where('voting.rt', $rt)
                ->where('voting.status', '1')
                ->select('voting.periode')
                ->value('voting.periode');

            return view('warga.v_e-voting', ['nama' => $nama, 'judul' => $judul, 'periode' => $periode, 'datas' => $datas]);
        }


        // dd($datas);


    }

    public function voteCalon($id, $id_voting)
    {
        HasilVoting::create([
            'id_calon' => $id,
            'id_voting' => $id_voting,
            'id_user_warga' => Crypt::encryptString(Auth::guard('user_warga')->user()->id)
        ]);

        return redirect('/evoting')->withSuccess('Selamat Anda telah berhasil melakukan Voting');
    }

    public function voteSelesai()
    {
        $rt = Warga::select('rt')->where('nik', Auth::guard('user_warga')->user()->nik)->value('rt');
        $nama = Warga::select('nama')->where('nik', Auth::guard('user_warga')->user()->nik)->first();
        // $id_vote = Voting::select('id')->where('rt', $rt)->latest()->value('id');
        // dd($id_vote);

        DB::statement("SET SQL_MODE=''");
        $datas = DB::table('calon')
            ->select(DB::raw('count(hasil_voting.id_calon) as jumlahPemilih,hasil_voting.id_calon , calon.nama, calon.no_urut, calon.thumbnail, voting.id'))
            ->join('voting', 'voting.id', '=', 'calon.id_voting')
            ->leftJoin('hasil_voting', 'calon.id', '=', 'hasil_voting.id_calon')
            ->where('voting.status', '1')
            ->where('voting.rt', $rt)
            ->groupBy('calon.id')
            ->get();
        // dd($datas);
        foreach ($datas as $row) {
            $itemlabel[] = $row->nama;
            $itemdata[] = $row->jumlahPemilih;
        }
        $dataChart['label'] = $itemlabel;
        $dataChart['data'] = $itemdata;

        $dataChart['chart_data'] = json_encode($dataChart);

        // dd($data);

        $judul = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
            ->where('voting.rt', $rt)
            ->where('voting.status', '1')
            ->select('voting.judul')
            ->value('voting.judul');

        $periode = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
            ->where('voting.rt', $rt)
            ->where('voting.status', '1')
            ->select('voting.periode')
            ->value('voting.periode');



        // dd($datas);

        return view('warga.v_e-voting_selesai', ['nama' => $nama, 'datas' => $datas, 'judul' => $judul, 'periode' => $periode, 'dataChart' => $dataChart]);
    }
}
