<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Surat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Response;

class RwController extends Controller
{
    public function dashboardRW()
    {

        //Chart Jenis Kelamin
        $totalJK = Warga::select('jenis_kelamin')->count();
        $data_jk = Warga::select(DB::raw('count(jenis_kelamin) as jumlah, jenis_kelamin '))->groupBy('jenis_kelamin')->get();

        $itemlabel = [];
        $itemdata = [];
        foreach ($data_jk as $row) {
            $itemlabel[] = $row->jenis_kelamin;
            $itemdata[] = number_format((float) $row->jumlah / $totalJK * 100);
        }
        $dataChart['label'] = $itemlabel;
        $dataChart['data'] = $itemdata;

        $dataChart['chart_data'] = json_encode($dataChart);

        //Chart Pekerjaan
        $totalP = Warga::select('pekerjaan')->count();
        $dataP = Warga::select(DB::raw('count(pekerjaan) as jp, pekerjaan'))->groupBy('pekerjaan')->get();

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
        $totalA = Warga::select('agama')->count();
        $dataA = Warga::select(DB::raw('count(agama) as ja, agama'))->groupBy('agama')->get();

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
        $totalSK = Warga::select('status_perkawinan')->count();
        $dataSK = Warga::select(DB::raw('count(status_perkawinan) as jsk, status_perkawinan'))->groupBy('status_perkawinan')->get();

        $itemlabelSK = [];
        $itemdataSK = [];
        foreach ($dataSK as $row) {
            $itemlabelSK[] = $row->status_perkawinan;
            $itemdataSK[] = number_format((float) $row->jsk / $totalSK * 100);
        }
        $dataChartSK['label'] = $itemlabelSK;
        $dataChartSK['data'] = $itemdataSK;

        $dataChartSK['chart_dataSK'] = json_encode($dataChartSK);

        $rt = User::select('name', 'rt')->where('role', 'rt')->get();

        return view('rw.v_dashboard', ['dataChart' => $dataChart, 'dataChartP' => $dataChartP, 'dataChartA' => $dataChartA, 'dataChartSK' => $dataChartSK, 'rt' => $rt]);
    }

    public function dataWarga()
    {
        $tRt = User::where('role', 'rt')->count();
        $tKK = Warga::select('no_kk')->distinct()->count();
        $tWarga = Warga::select('nik')->count();
        $rt = User::select('name', 'rt')->where('role', 'rt')->get();
        // dd($rt);

        return view('rw.v_data_warga', ['tKK' => $tKK, 'tWarga' => $tWarga, 'rt' => $rt, 'tRt' => $tRt]);
    }

    public function getDataWarga(Request $request)
    {

        ini_set('memory_limit', '-1');
        if ($request->filter != 'semua') {
            $data = Warga::where('rt', $request->filter)->get();
            // return DataTables::of($data)->toJson();
        } elseif ($request->filter == 'semua') {
            $data = Warga::get();
        }
        return DataTables::of($data)->toJson();
    }

    public function dashboardChart($id)
    {
        if ($id != '007') {
            //Chart Jenis Kelamin
            $data_jk = Warga::select(DB::raw('count(jenis_kelamin) as jumlah, jenis_kelamin '))->where('rt', $id)->groupBy('jenis_kelamin')->get();

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
            $totalP = Warga::select('pekerjaan')->where('rt', $id)->count();
            $dataP = Warga::select(DB::raw('count(pekerjaan) as jp, pekerjaan'))->where('rt', $id)->groupBy('pekerjaan')->get();

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
            $totalA = Warga::select('agama')->where('rt', $id)->count();
            $dataA = Warga::select(DB::raw('count(agama) as ja, agama'))->where('rt', $id)->groupBy('agama')->get();

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
            $totalSK = Warga::select('status_perkawinan')->where('rt', $id)->count();
            $dataSK = Warga::select(DB::raw('count(status_perkawinan) as jsk, status_perkawinan'))->where('rt', $id)->groupBy('status_perkawinan')->get();

            $itemlabelSK = [];
            $itemdataSK = [];
            foreach ($dataSK as $row) {
                $itemlabelSK[] = $row->status_perkawinan;
                $itemdataSK[] = number_format((float) $row->jsk / $totalSK * 100);
            }
            $dataChartSK['label'] = $itemlabelSK;
            $dataChartSK['data'] = $itemdataSK;

            $dataChartSK['chart_dataSK'] = json_encode($dataChartSK);

            $rt = User::select('name', 'rt')->where('role', 'rt')->get();
            return Response::json(['dataChart' => $dataChart, 'dataChartP' => $dataChartP, 'dataChartA' => $dataChartA, 'dataChartSK' => $dataChartSK, 'rt' => $rt]);
        } elseif ($id == '007') {
            //Chart Jenis Kelamin
            $data_jk = Warga::select(DB::raw('count(jenis_kelamin) as jumlah, jenis_kelamin '))->groupBy('jenis_kelamin')->get();

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
            $totalP = Warga::select('pekerjaan')->count();
            $dataP = Warga::select(DB::raw('count(pekerjaan) as jp, pekerjaan'))->groupBy('pekerjaan')->get();

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
            $totalA = Warga::select('agama')->count();
            $dataA = Warga::select(DB::raw('count(agama) as ja, agama'))->groupBy('agama')->get();

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
            $totalSK = Warga::select('status_perkawinan')->count();
            $dataSK = Warga::select(DB::raw('count(status_perkawinan) as jsk, status_perkawinan'))->groupBy('status_perkawinan')->get();

            $itemlabelSK = [];
            $itemdataSK = [];
            foreach ($dataSK as $row) {
                $itemlabelSK[] = $row->status_perkawinan;
                $itemdataSK[] = number_format((float) $row->jsk / $totalSK * 100);
            }
            $dataChartSK['label'] = $itemlabelSK;
            $dataChartSK['data'] = $itemdataSK;

            $dataChartSK['chart_dataSK'] = json_encode($dataChartSK);

            $rt = User::select('name', 'rt')->where('role', 'rt')->get();
            return Response::json(['dataChart' => $dataChart, 'dataChartP' => $dataChartP, 'dataChartA' => $dataChartA, 'dataChartSK' => $dataChartSK, 'rt' => $rt]);
        }


        // return  [$dataChart, $dataChartP,  $dataChartA,  $dataChartSK, $rt];
    }


    public function akunRT()
    {
        $datas = User::where('role', 'rt')->get();
        $rt = User::where('role', 'rt')->count();

        return view('rw.v_akun_rt', ['datas' => $datas, 'rt' => $rt]);
    }

    public function addAkun(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rt' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'rt' => $request->rt,
            'password' => Hash::make($request->password),
            'role' => 'rt'
        ]);

        return redirect('/rw/akun/rt')->withSuccess('Akun RT berhasil ditambahkan');
    }

    public function editAkun(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'rt' => 'required',
        //     'password' => 'required'
        // ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->rt = $request->input('rt');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect('/rw/akun/rt')->withSuccess('Akun RT berhasil diperbaharui');
    }

    public function deleteAkun($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/rw/akun/rt');
    }

    public function berita()
    {
        $jml = Berita::all()->count();
        $datas = Berita::all();

        return view('rw.v_post_berita', ['datas' => $datas, 'jml' => $jml]);
    }

    public function beritaUpload(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'thumbnail' => 'image',
            'gambar1' => 'image',
            'gambar2' => 'image',
            'content' => 'required',
            'file' => 'required|mimes:csv,xlx,xls,pdf|max:5048'
        ]);

        Berita::create([
            'judul' => $request->judul,
            'thumbnail' => $request->file('thumbnail')->store('image-berita'),
            'gambar1' => $request->file('gambar1')->store('image-berita'),
            'gambar2' => $request->file('gambar2')->store('image-berita'),
            'content' => $request->content,
            'attachment' => $request->file('file')->store('file-berita')
        ]);

        return redirect("/berita")->withSuccess('Post berita berhasil ditambahkan');
    }

    public function beritaDelete($id)
    {
        $data = Berita::find($id);
        $data->delete();

        return redirect("/berita")->withSuccess('Berita berhasil dihapus');
    }

    public function beritaEdit(Request $request, $id)
    {
        // dd($request);
        $rules = [
            'judulEdit' => 'required',
            'contentEdit' => 'required'
        ];

        if ($request->file('thumbnailEdit')) {
            if ($request->oldImage != $request->thumbnailEdit) {
                Storage::delete($request->oldImage);
            }
            $rules['thumbnailEdit'] = 'image';
            // dd($rules['judulEdit']);
        }
        if ($request->file('thumbnailEdit1')) {
            if ($request->oldImage1 != $request->thumbnailEdit1) {
                Storage::delete($request->oldImage1);
            }
            $rules['thumbnailEdit1'] = 'image';
            // dd($rules['judulEdit']);
        }
        if ($request->file('thumbnailEdit2')) {
            if ($request->oldImage2 != $request->thumbnailEdit2) {
                Storage::delete($request->oldImage2);
            }
            $rules['thumbnailEdit2'] = 'image';
            // dd($rules['judulEdit']);
        }
        if ($request->file('fileEdit')) {
            if ($request->oldFile != $request->fileEdit) {
                Storage::delete($request->oldFile);
            }
            $rules['fileEdit'] = 'required|mimes:csv,xlx,xls,pdf|max:5048';
            // dd($rules['judulEdit']);
        }

        $validatedData = $request->validate($rules);

        $dataUpdate = [
            'judul' => $validatedData['judulEdit'],
            'content' => $validatedData['contentEdit']
        ];

        if ($request->file('thumbnailEdit')) {
            $dataUpdate['thumbnail'] = $validatedData['thumbnailEdit']->store('image-berita');
        };
        if ($request->file('thumbnailEdit1')) {
            $dataUpdate['gambar1'] = $validatedData['thumbnailEdit1']->store('image-berita');
        };
        if ($request->file('thumbnailEdit')) {
            $dataUpdate['gambar2'] = $validatedData['thumbnailEdit2']->store('image-berita');
        };
        if ($request->file('fileEdit')) {
            $dataUpdate['attachment'] = $validatedData['fileEdit']->store('file-berita');
        };
        // dd($dataUpdate);

        Berita::where('id', $id)->update($dataUpdate);

        return redirect("/berita")->withSuccess('Post berita berhasil diubah');
    }

    public function suratMasuk()
    {
        $jml = Surat::where('id_status_surat', '2')->count();

        DB::statement("SET SQL_MODE=''");
        $datas = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where('id_status_surat', '2')
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga')
            ->get();

        return view('rw.v_surat_masuk', ['datas' => $datas, 'jml' => $jml]);
    }

    public function suratDisetujui()
    {

        $rt = \Str::substr(Auth::user()->name, 2);

        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where('id_status_surat', '3')
            ->count();

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where('id_status_surat', '3')
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.id_status_surat')
            ->get();

        // dd($datas);

        return view('rw.v_surat_disetujui', ['datas' => $datas, 'jml' => $jml]);
    }

    public function suratDitolak()
    {


        $jml = DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->where('id_status_surat', '5')
            ->count();

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where('id_status_surat', '5')
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.catatan')
            ->get();

        // dd($datas);

        return view('rw.v_surat_ditolak', ['datas' => $datas, 'jml' => $jml]);
    }



    public function acceptSurat($id)
    {
        Surat::where('id', $id)
            ->update(['id_status_surat' => '3']);
        return redirect('rw/surat/disetujui')->with('success', "Surat Berhasil disetujui");
    }

    public function rejectSurat($id)
    {
        Surat::where('id', $id)
            ->update(['id_status_surat' => '5']);
        return redirect('rw/surat/ditolak')->with('warning', "Surat Berhasil ditolak, harap memberi catatan");
    }

    public function noteSurat(Request $request, $id)
    {
        $request->validate([
            'note' => 'required'
        ]);

        Surat::find($id)
            ->update(['catatan' => $request->note]);
        return redirect('rw/surat/ditolak')->with('success', "Catatan sudah ditambahkan");
    }

    public function viewSuratRw($id)
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
            ->where('id_status_surat', '3')
            ->count();

        $fdate = $request->input('fdate');
        $tdate = $request->input('tdate');

        DB::statement("SET SQL_MODE=''");
        $datas =  DB::table('surat')
            ->join('user_warga', 'surat.id_user_warga', '=', 'user_warga.id')
            ->join('warga', 'warga.nik', '=', 'user_warga.nik')
            ->join('surat_attachment', 'surat_attachment.id_surat', '=', 'surat.id')
            ->where('id_status_surat', '3')
            ->where('surat.updated_at', '>=', $fdate . ' 00:00:00')
            ->where('surat.updated_at', '<=', $tdate . ' 23:59:59')
            ->groupBy('surat.id')
            ->select('surat.no_surat', 'surat.keterangan', 'surat.keperluan', 'warga.nama', 'surat.id', 'surat_attachment.fileKTP', 'surat_attachment.fileKK', 'surat.id_user_warga', 'surat.id_status_surat')
            ->get();

        // dd($datas);
        return view('rw.v_surat_disetujui', ['datas' => $datas, 'jml' => $jml]);
    }
}
