<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class ApotekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apoteks = Apotek::all();

        if ($apoteks){
            return ApiFormatter::createApi(200, 'success', $apoteks);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createToken()
    {
       return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama' => 'required|min:3',
                'rujukan' => 'required',
                'rumah_sakit' => $request->rujukan == true ? 'required' : "",
                'obat' => 'required', 
                'harga_satuan' => 'required',
                'apoteker' => 'required',
            ]);

            
            $hargaSatuan = explode(',', $request->harga_satuan);
            $harga_total = 0;
            foreach($hargaSatuan as $item=>$value)
            {
            // simpan nilai harga ke variabel $harga_total
            $value  =(int)trim($value, '"');
            $harga_total +=$value;
            }

            $apotek = Apotek::create([
                'nama' => $request->nama,
                'rujukan' => $request->rujukan,
                'rumah_sakit' => $request->rujukan == true ? $request->rumah_sakit : NULL,
                'obat' => $request->obat,
                'harga_satuan' =>$request->harga_satuan,         
                'total_harga' => $harga_total,
                'apoteker' => $request->apoteker,

            ]);

            $savedData = Apotek::where('id', $apotek->id)->first();

            if ($savedData){
                return ApiFormatter::createApi(200, 'Berhasil Menambahkan Data!', $savedData);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Apotek $apotek, $id)
    {
        try {
            $detail = Apotek::where('id', $id)->first();

            if ($detail) {
                return ApiFormatter::createApi(200, 'succes', $detail);
            } else{
                return ApiFormatter::createApi(400, 'failed');

            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apotek $apotek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apotek $apotek, $id)
    {
        try{
            $request->validate([
                'nama' => 'required|min:3',
                'rujukan' => 'required',
                'rumah_sakit' => $request->rujukan == true ? 'required' : "",
                'obat' => 'required', 
                'harga_satuan' => 'required',
                'apoteker' => 'required',
            ]);

            $apotek = Apotek::findOrFail($id);
            
            $hargaSatuan = explode(',', $request->harga_satuan);
            $harga_total = 0;
            foreach($hargaSatuan as $item=>$value)
            {
            // simpan nilai harga ke variabel $harga_total
            $value  =(int)trim($value, '"');
            $harga_total +=$value;
            }  

            $apotek->update([
                'nama' => $request->nama,
                'rujukan' => $request->rujukan,
                'rumah_sakit' => $request->rujukan == true ? $request->rumah_sakit : NULL,
                'obat' => $request->obat,
                'harga_satuan' =>$request->harga_satuan,         
                'total_harga' => $harga_total,
                'apoteker' => $request->apoteker,

            ]);



            $savedData = Apotek::where('id', $apotek->id);

            if ($savedData){
                return ApiFormatter::createApi(200, 'Berhasil Mengedit Data!', $savedData);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apotek $apotek, $id)
    {
        try{
            $apotek = Apotek::findOrFail($id);
            $proses = $apotek->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success', 'Data Terhapus!');
            } else{
                return ApiFormatter::createApi(400, 'failed');

            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
        }

        public function trash()
        {
            try{
                $trashAll = Apotek::onlyTrashed()->get();    
                if ($trashAll) {
                    return ApiFormatter::createApi(200, 'success', $trashAll);
                } else{
                    return ApiFormatter::createApi(400, 'failed');
    
                }
            } catch (Exception $error) {
                return ApiFormatter::createApi(400, 'failed', $error);
            }
         }  

         public function restore($id)
         {
            try{
                $apotek = Apotek::onlyTrashed()->where('id', $id);  
                $apotek->restore();
                
                $dataRestore = Apotek::where('id', $id)->first();
                if ($dataRestore) {
                    return ApiFormatter::createApi(200, 'success', $dataRestore);
                } else{
                    return ApiFormatter::createApi(400, 'failed');
     
                }
            } catch (Exception $error) {
                return ApiFormatter::createApi(400, 'failed', $error);
            }
         }

         public function permanentDelete($id)
         {
            try{
                $apotek = Apotek::onlyTrashed()->where('id', $id);  
                $permanent =$apotek->forceDelete();
                if ($permanent) {
                    return ApiFormatter::createApi(200, 'success', 'Berhasil Menghapus Permanent Data!');
                } else{
                    return ApiFormatter::createApi(400, 'failed');
    
                }
            } catch (Exception $error) {
                return ApiFormatter::createApi(400, 'failed', $error);
            }
         }

         public function search($apoteker)
         {
            try{
                $apoteker = Apotek::where("apoteker", "like", "%". $apoteker."%")->get();

                if ($search){
                    return ApiFormatter::createApi(200, 'success', $search);
                }else {
                    return ApiFormatter::createApi(400, 'failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createApi(400, 'failed', $error);
    
            }

         }
}
