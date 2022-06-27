<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RwController extends Controller
{
    public function dashboardRW()
    {
        return view('rw.v_dashboard');
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
