<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ImportedData;
use Illuminate\Support\Facades\Storage;
use App\Imports\ImportFile;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ImportData;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ImportExportController extends Controller
{
    public function show(){
        return view('import_export');
    }

    public function getData(){
        $data = ImportData::select('unique_number', 'date_of_installation', 'seal_name', 'client'); 
        return DataTables::of($data)
            ->addColumn('action', function($row){
                return '<a href="'.route('get_each_row_data', $row->unique_number).'" class="btn btn-primary">View Details</a>';
            })
            ->make(true);
    }

    public function uploadFile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'excel_file' => 'required|mimes:xlsx',
        ]);
        $file = $request->file('excel_file');
        $filePath = $file->storeAs('dataupload', $file->getClientOriginalName(), 'local'); // Store in 'storage/app/dataupload'
        // dd($filePath);
        Excel::import(new ImportFile, $filePath);

        return response()->json(['success' => true, 'message' => 'Data Store successfully','status' => 200]);
    }

    public function getEachRowData($unique_id){


        $data = ImportData::where('unique_number', $unique_id)->first();

        return view('row_detail',compact('data'));
    }

    public function downloadZip()
    {
        $zip = new ZipArchive;
        $fileName = 'dataupload.zip';
        $filePath = storage_path($fileName); // The ZIP file will be created in the storage directory

        // Directory path containing files to be zipped
        $directoryPath = storage_path('app/dataupload'); // Ensure this is the correct directory

        // Check if the directory exists, if not, create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // Open or create the ZIP file
        if ($zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
        {
            // Get all files from the directory
            $files = File::files($directoryPath);

            // Add each file to the ZIP archive
            foreach ($files as $file)
            {
                $zip->addFile($file->getRealPath(), $file->getFilename());
            }

            // Close the ZIP file
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create ZIP file'], 500);
        }

        // Return the ZIP file as a download response and delete it after sending
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
