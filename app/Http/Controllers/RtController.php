<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\HasilVoting;
use App\Models\Surat;
use App\Models\Warga;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
// use DataTables;
use Yajra\DataTables\DataTables;
use PDF;

class RtController extends Controller
{
    public function dashboardRT()
    {
        // DB::statement("SET SQL_MODE=''");
        // $rt = \Str::substr(Auth::user()->name, 2);
        // $datas = Warga::select(DB::raw("SUBSTR(ttl, -10)"))
        //     ->where('rt', $rt)->get();
        // $data  = DB::select(DB::raw("SELECT nama, DATE_FORMAT(FROM_DAYS(DATEDIFF(DATE(NOW()), '2000-30-05')), '%Y') * 1 AS age FROM warga"));
        // // dd($datas);
        // foreach ($datas as $data) {
        //     $explode = explode(":", $data);
        //     $date = Str::substr(implode($explode), -12, 10);
        //     $years = Carbon::parse($date)->age;
        // }
        // $old = $years;
        $rt = \Str::substr(Auth::user()->name, 2);

        // dd($tWarga);

        //Chart Jenis Kelamin
        $data_jk = Warga::select(DB::raw('count(jenis_kelamin) as jumlah, jenis_kelamin '))->groupBy('jenis_kelamin')->where('rt', $rt)->get();

        $itemlabel = [];
        $itemdata = [];
        foreach ($data_jk as $row) {
            $itemlabel[] = $row->jenis_kelamin;
            $itemdata[] = number_format((float) $row->jumlah / 2 * 100);
        }
        $dataChart['label'] = $itemlabel;
        $dataChart['data'] = $itemdata;

        $dataChart['chart_data'] = json_encode($dataChart);

        //Chart Pekerjaan
        $totalP = Warga::select('pekerjaan')->where('rt', $rt)->count();
        $dataP = Warga::select(DB::raw('count(pekerjaan) as jp, pekerjaan'))->groupBy('pekerjaan')->where('rt', $rt)->get();

        $itemlabelP = [];
        $itemdataP = [];
        foreach ($dataP as $row) {
            $itemlabelP[] = $row->pekerjaan;
            $itemdataP[] = number_format((float) $row->jp / $totalP * 100);
        }
        $dataChartP['label'] = $itemlabelP;
        $dataChartP['data'] = $itemdataP;

        $dataChartP['chart_dataP'] = json_encode($dataChartP);

        //Chart Agama
        $totalA = Warga::select('agama')->where('rt', $rt)->count();
        $dataA = Warga::select(DB::raw('count(agama) as ja, agama'))->groupBy('agama')->where('rt', $rt)->get();

        $itemlabelA = [];
        $itemdataA = [];
        foreach ($dataA as $row) {
            $itemlabelA[] = $row->agama;
            $itemdataA[] = number_format((float) $row->ja / $totalA * 100);
        }
        $dataChartA['label'] = $itemlabelA;
        $dataChartA['data'] = $itemdataA;

        $dataChartA['chart_dataA'] = json_encode($dataChartA);

        //Chart Status Kawin
        $totalSK = Warga::select('status_perkawinan')->where('rt', $rt)->count();
        $dataSK = Warga::select(DB::raw('count(status_perkawinan) as jsk, status_perkawinan'))->groupBy('status_perkawinan')->where('rt', $rt)->get();

        $itemlabelSK = [];
        $itemdataSK = [];
        foreach ($dataSK as $row) {
            $itemlabelSK[] = $row->status_perkawinan;
            $itemdataSK[] = number_format((float) $row->jsk / $totalSK * 100);
        }
        $dataChartSK['label'] = $itemlabelSK;
        $dataChartSK['data'] = $itemdataSK;

        $dataChartSK['chart_dataSK'] = json_encode($dataChartSK);
        // dd($dataChartSK);

        return view('rt.v_dashboard', ['dataChart' => $dataChart, 'dataChartP' => $dataChartP, 'dataChartA' => $dataChartA, 'dataChartSK' => $dataChartSK]);
    }

    public function dataWarga()
    {
        $rt = \Str::substr(Auth::user()->name, 2);

        $tKK = Warga::select('no_kk')->distinct()->where('rt', $rt)->count();
        $tWarga = Warga::select('nik')->where('rt', $rt)->count();

        return view('rt.v_data_warga', ['tKK' => $tKK, 'tWarga' => $tWarga]);
    }

    public function getDataDashboard(Request $request)
    {
        $rt = \Str::substr(Auth::user()->name, 2);

        ini_set('memory_limit', '-1');
        if ($request->filter == 'semua') {
            $data = Warga::where('rt', $rt)->get();
            return DataTables::of($data)->toJson();
        } else if ($request->filter == 'jenis_kelamin') {
            if ($request->subfilter == 'LAKI-LAKI') {
                $data = Warga::where('rt', $rt)->where('jenis_kelamin', 'LAKI-LAKI')->get();
                // return DataTables::of($data)->toJson();
            } else if ($request->subfilter == 'PEREMPUAN') {
                $data = Warga::where('rt', $rt)->where('jenis_kelamin', 'PEREMPUAN')->get();
                // return DataTables::of($data)->toJson();
            }
            return DataTables::of($data)->toJson();
        } elseif ($request->filter == 'pekerjaan') {
            if ($request->subfilter == 'PELAJAR/MAHASISWA') {
                $data = Warga::where('rt', $rt)->where('pekerjaan', 'PELAJAR/MAHASISWA')->get();
            } else if ($request->subfilter == 'KARYAWAN SWASTA') {
                $data  = Warga::where('rt', $rt)->where('pekerjaan', 'KARYAWAN SWASTA')->get();
            } else if ($request->subfilter == 'WIRASWASTA') {
                $data  = Warga::where('rt', $rt)->where('pekerjaan', 'WIRASWASTA')->get();
            } else if ($request->subfilter == 'BELUM/TIDAK BEKERJA') {
                $data  = Warga::where('rt', $rt)->where('pekerjaan', 'BELUM/TIDAK BEKERJA')->get();
            } elseif ($request->subfilter == 'BURUH HARIAN LEPAS') {
                $data  = Warga::where('rt', $rt)->where('pekerjaan', 'BURUH HARIAN LEPAS')->get();
            }
            return DataTables::of($data)->toJson();
        } elseif ($request->filter == 'agama') {
            if ($request->subfilter == 'ISLAM') {
                $data = Warga::where('rt', $rt)->where('agama', 'ISLAM')->get();
            } else if ($request->subfilter == 'KRISTEN') {
                $data = Warga::where('rt', $rt)->where('agama', 'KRISTEN')->get();
            } else if ($request->subfilter == 'KATOLIK') {
                $data = Warga::where('rt', $rt)->where('agama', 'KATOLIK')->get();
            } else if ($request->subfilter == 'HINDU') {
                $data = Warga::where('rt', $rt)->where('agama', 'HINDU')->get();
            } else if ($request->subfilter == 'BUDDHA') {
                $data = Warga::where('rt', $rt)->where('agama', 'BUDDHA')->get();
            } else if ($request->subfilter == 'KHONGHUCU') {
                $data = Warga::where('rt', $rt)->where('agama', 'KHONGHUCU')->get();
            }
            return DataTables::of($data)->toJson();
        } elseif ($request->filter == 'status_kawin') {
            if ($request->subfilter == 'BELUM KAWIN') {
                $data = Warga::where('rt', $rt)->where('status_perkawinan', 'BELUM KAWIN')->get();
            } elseif ($request->subfilter == 'KAWIN') {
                $data = Warga::where('rt', $rt)->where('status_perkawinan', 'KAWIN')->get();
            } elseif ($request->subfilter == 'CERAI HIDUP') {
                $data = Warga::where('rt', $rt)->where('status_perkawinan', 'CERAI HIDUP')->get();
            } elseif ($request->subfilter == 'CERAI MATI') {
                $data = Warga::where('rt', $rt)->where('status_perkawinan', 'CERAI MATI')->get();
            }
            return DataTables::of($data)->toJson();
        }
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

    public function voting()
    {
        $rt = \Str::substr(Auth::user()->name, 2);
        $datas = Voting::where('rt', $rt)->get();
        return view('rt.v_voting', ['datas' => $datas]);
    }

    public function addVoting(Request $request)
    {
        $rt = \Str::substr(Auth::user()->name, 2);
        $request->validate([
            'judul' => 'required',
            'periode' => 'required'

        ]);

        Voting::create([
            'judul' => $request->judul,
            'periode' => $request->periode,
            'rt' => $rt,
            'status' => '0'
        ]);

        return redirect('/rt/voting')->withSuccess('E-Voting berhasil ditambahkan');
    }

    public function deleteVoting($id)
    {
        $data = Voting::find($id);
        $data->delete();

        return redirect('/rt/voting')->withSuccess('E-Voting berhasil dithapus');
    }

    public function editVoting(Request $request, $id)
    {
        $request->validate([
            'judulEdit' => 'required',
            'periodeEdit' => 'required'
        ]);

        $dataUpdate = [
            'judul' => $request->judulEdit,
            'periode' => $request->periodeEdit
        ];

        Voting::where('id', $id)->update($dataUpdate);
        return redirect('/rt/voting')->withSuccess('E-Voting berhasil diupdate');
    }

    public function calon()
    {
        $rt = \Str::substr(Auth::user()->name, 2);
        $voting = Voting::where('status', '1')->where('rt', $rt)->get();

        $datas = Voting::join('calon', 'calon.id_voting', '=', 'voting.id')
            ->where('voting.rt', $rt)
            ->where('voting.status', '1')
            ->get();
        // dd($voting);
        return view('rt.v_data_calon', ['voting' => $voting, 'datas' => $datas]);
    }

    public function periodeCalon($id)
    {
        $rt = \Str::substr(Auth::user()->name, 2);
        // $voting = Voting::where('status', '1')->where('rt', $rt)->get();
        // dd($id);

        $datas = Calon::join('voting', 'voting.id', '=', 'calon.id_voting')
            ->where('voting.id', $id)
            ->where('voting.rt', $rt)
            ->where('voting.status', '1')
            ->get();
        return response()->json(compact('datas'));
        // ($datas);

        // return view('rt.v_data_calon', ['datas' => $datas]);
    }

    public function showVoting($id)
    {
        Voting::where('id', $id)
            ->update(['status' => '1']);

        return redirect('/rt/voting');
    }
    public function closeVoting($id)
    {
        Voting::where('id', $id)
            ->update(['status' => '2']);

        return redirect('/rt/voting');
    }

    public function addCalon(Request $request)
    {
        $rt = \Str::substr(Auth::user()->name, 2);
        $votingId = Voting::select('id')->orderBy('id', 'desc')->where('rt', $rt)->where('status', '1')->limit(1)->value('id');
        // dd($votingId);
        $request->validate([
            'nama' => 'required',
            'no_urut' => 'required',
            'visi' => 'required',
            'thumbnail' => 'image',
            'periode' => 'required'
        ]);

        Calon::create([
            'nama' => $request->nama,
            'no_urut' => $request->no_urut,
            'visi' => $request->visi,
            'thumbnail' => $request->file('thumbnail')->store('file-data-calon'),
            'periode' => $request->periode,
            'id_voting' => $votingId
        ]);

        return redirect('/rt/voting/calon')->withSuccess('Data Calon Berhasil ditambahkan');
    }

    public function deleteCalon($id)
    {
        $data = Calon::find($id);
        $data->delete();
        return redirect('/rt/voting/calon')->withSuccess('Data Calon Berhasil dihapus');
    }

    public function editCalon(Request $request, $id)
    {
        $rules = [
            'namaEdit' => 'required',
            'no_urutEdit' => 'required',
            'visiEdit' => 'required',
            'periodeEdit' => 'required'
        ];

        if ($request->file('thumbnailEdit')) {
            if ($request->oldImage != $request->thumbnailEdit) {
                Storage::delete($request->oldImage);
            }
            $rules['thumbnailEdit'] = 'image';
            // dd($rules['judulEdit']);
        }

        $validatedData = $request->validate($rules);

        $dataUpdate = [
            'nama' => $validatedData['namaEdit'],
            'no_urut' => $validatedData['no_urutEdit'],
            'visi' => $validatedData['visiEdit'],
            'periode' => $validatedData['periodeEdit'],
        ];

        if ($request->file('thumbnailEdit')) {
            $dataUpdate['thumbnail'] = $validatedData['thumbnailEdit']->store('file-data-calon');
        };

        Calon::where('id', $id)->update($dataUpdate);

        return redirect('/rt/voting/calon')->withSuccess('Data Calon Berhasil diedit');
    }

    public function hasilVoting()
    {
        $rt = \Str::substr(Auth::user()->name, 2);

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

        if ($datas->isNotEmpty()) {
            $totalPemilih = Warga::where('rt', $rt)->get()->count();
            $totalSuara = HasilVoting::join('voting', 'voting.id', '=', 'hasil_voting.id_voting')
                ->where('voting.rt', $rt)->where('voting.status', '1')->get()->count();

            $totalGolput = $totalPemilih - $totalSuara;
            foreach ($datas as $row) {
                $itemlabel[] = $row->nama;
                $itemdata[] = $row->jumlahPemilih;
            }
            $dataChart['label'] = $itemlabel;
            $dataChart['data'] = $itemdata;

            $dataChart['chart_data'] = json_encode($dataChart);
            return view('rt.v_hasil_voting', ['datas' => $datas, 'totalPemilih' => $totalPemilih, 'totalSuara' => $totalSuara, 'totalGolput' => $totalGolput, 'dataChart' => $dataChart]);
        } else {
            return view('rt.v_hasil_voting', ['datas' => $datas]);
        }
    }

    public function printVoting($id)
    {
        $rt = \Str::substr(Auth::user()->name, 2);

        DB::statement("SET SQL_MODE=''");
        $datas = DB::table('calon')
            ->select(DB::raw('count(hasil_voting.id_calon) as jumlahPemilih,hasil_voting.id_calon , calon.nama, calon.no_urut, voting.id'))
            ->join('voting', 'voting.id', '=', 'calon.id_voting')
            ->leftJoin('hasil_voting', 'calon.id', '=', 'hasil_voting.id_calon')
            ->where('voting.id', $id)
            ->where('voting.rt', $rt)
            ->groupBy('calon.id')
            ->get();
        // dd($datas);

        $judul = Voting::select('judul')->where('id', $id)->value('judul');
        $periode = Voting::select('periode')->where('id', $id)->value('periode');

        $totalPemilih = Warga::where('rt', $rt)->get()->count();
        $totalSuara = HasilVoting::join('voting', 'voting.id', '=', 'hasil_voting.id_voting')
            ->where('voting.rt', $rt)->where('voting.id', $id)->get()->count();
        $totalGolput = $totalPemilih - $totalSuara;

        $pdf = PDF::loadview('rt.v_hasil_voting_pdf', ['datas' => $datas, 'tPemilih' => $totalPemilih, 'tSuara' => $totalSuara, 'tGolput' => $totalGolput, 'judul' => $judul, 'periode' => $periode]);
        return $pdf->stream();

        // return view('rt.v_hasil_voting_pdf', ['datas' => $datas]);
    }
}
