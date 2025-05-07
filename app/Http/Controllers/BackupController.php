<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class BackupController extends Controller
{
    /**
     * This controller will be use to manage all the Backups on Auto Serve System.
     * 
     *  - View, Download Backups
     *  - Manage backups
     * 
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the backup files.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $settingId = $request->user()->setting_id;

        // Fetch all backup files for the user's setting_id
        $allBackups = collect(Storage::files('backups'))
            ->filter(function ($file) use ($settingId) {
                return str_contains($file, "backup_all_records_{$settingId}_");
            })
            ->map(function ($file) {
                return basename($file); // Extract only the file name
            });

        // Pass the filtered backups to the view
        return view('backup', [
            'allBackups' => $allBackups
        ]);
    }

    /**
     * Create a backup of all records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function backupAllRecords(Request $request)
    {
        $settingId = $request->user()->setting_id;
        $format = $request->input('format', 'json'); // Default to JSON if no format is specified

        // List of models to back up
        $models = [
            'AccountHead' => \App\Models\accountheads::class,
            'Vehicle' => \App\Models\vehicle::class,
            'User' => \App\Models\User::class,
            'Transaction' => \App\Models\transactions::class,
            'Task' => \App\Models\tasks::class,
            'Supply' => \App\Models\supplies::class,
            'Stock' => \App\Models\stock::class,
            'Setting' => \App\Models\settings::class,
            'ServiceOrder' => \App\Models\serviceOrder::class,
            'Sale' => \App\Models\sale::class,
            'Personnel' => \App\Models\personnel::class,
            'Payment' => \App\Models\payments::class,
            'PartsOrder' => \App\Models\partsorder::class,
            'Part' => \App\Models\parts::class,
            'Psfu' => \App\Models\psfu::class,
            'Job' => \App\Models\jobs::class,
            'Expenditure' => \App\Models\expenditure::class,
            'Diagnosis' => \App\Models\diagnosis::class,
            'Delivery' => \App\Models\delivery::class,
            'Control' => \App\Models\controls::class,
        ];

        $backupData = [];

        foreach ($models as $modelName => $modelClass) {
            $records = collect(); // Initialize $records as an empty collection

            if ($modelName === 'Setting') {
                $records = $modelClass::where('id', $settingId)->get();
            } else {
                $records = $modelClass::where('setting_id', $settingId)->get();
            }

            $backupData[$modelName] = $records->isEmpty() ? [] : $records;
        }

        if ($format === 'sql') {
            $sqlDump = "";
            foreach ($backupData as $tableName => $records) {
                $sqlDump .= "-- Dumping data for table: $tableName\n";
                foreach ($records as $record) {
                    $columns = implode(',', array_keys($record->toArray()));
                    $values = implode(',', array_map(fn($value) => "'" . addslashes($value) . "'", array_values($record->toArray())));
                    $sqlDump .= "INSERT INTO $tableName ($columns) VALUES ($values);\n";
                }
            }

            $fileName = 'backup_all_records_' . $settingId . '_' . now()->format('Y_m_d_H_i_s') . '.sql';
            Storage::put('backups/' . $fileName, $sqlDump);
        } elseif ($format === 'zipped-sql') {
            $sqlDump = "";
            foreach ($backupData as $tableName => $records) {
                $sqlDump .= "-- Dumping data for table: $tableName\n";
                foreach ($records as $record) {
                    $columns = implode(',', array_keys($record->toArray()));
                    $values = implode(',', array_map(fn($value) => "'" . addslashes($value) . "'", array_values($record->toArray())));
                    $sqlDump .= "INSERT INTO $tableName ($columns) VALUES ($values);\n";
                }
            }

            $fileName = 'backup_all_records_' . $settingId . '_' . now()->format('Y_m_d_H_i_s') . '.sql';
            $tempFilePath = storage_path('app/backups/' . $fileName);
            file_put_contents($tempFilePath, $sqlDump);

            $zipFileName = 'backup_all_records_' . $settingId . '_' . now()->format('Y_m_d_H_i_s') . '.zip';
            $zip = new \ZipArchive();
            $zip->open(storage_path('app/backups/' . $zipFileName), \ZipArchive::CREATE);
            $zip->addFile($tempFilePath, $fileName);
            $zip->close();

            unlink($tempFilePath); // Remove the temporary SQL file
        } else {
            $backupJson = json_encode($backupData);
            $fileName = 'backup_all_records_' . $settingId . '_' . now()->format('Y_m_d_H_i_s') . '.json';
            Storage::put('backups/' . $fileName, $backupJson);
        }

        return redirect()->route('backup')->with('message', 'Backup of all records created successfully. - File: ' . $fileName);
    }

    /**
     * Download a backup file.
     *
     * @param  string  $file
     * @return \Illuminate\Http\Response
     */

    public function downloadBackup($file, Request $request)
    {
        $settingId = $request->user()->setting_id;

        // Ensure the file belongs to the user's setting_id
        if (!str_contains($file, "backup_all_records_{$settingId}_")) {
            return redirect()->route('backup')->with('error', 'Unauthorized access to the backup file.');
        }

        $filePath = 'backups/' . $file; 

        if (!Storage::exists($filePath)) {
            \Log::error('File not found: ' . $filePath);
            return redirect()->route('backup')->with('error', 'File not found. Please ensure the backup file exists.');
        }

        return Storage::download($filePath);
    }

    /**
     * Delete a backup file.
     *
     * @param  string  $file
     * @return \Illuminate\Http\Response
     */

    public function deleteBackup($file, Request $request)
    {
        $settingId = $request->user()->setting_id;

        // Ensure the file belongs to the user's setting_id
        if (!str_contains($file, "backup_all_records_{$settingId}_")) {
            return redirect()->route('backup')->with('error', 'Unauthorized access to delete the backup file.');
        }

        $filePath = 'backups/' . $file; // Relative path for Laravel Storage

        if (!Storage::exists($filePath)) {
            \Log::error('File not found for deletion: ' . $filePath);
            return redirect()->route('backup')->with('error', 'File not found. Please ensure the backup file exists.');
        }

        Storage::delete($filePath);

        return redirect()->route('backup')->with('message', 'Backup file deleted successfully.');
    }
}
