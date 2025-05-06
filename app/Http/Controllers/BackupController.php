<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\vehicle;
use App\Models\transactions;
use App\Models\task;
use App\Models\supply;
use App\Models\stock;
use App\Models\settings;
use App\Models\serviceOrder;
use App\Models\Sale;
use App\Models\psfu;
use App\Models\personnel;
use App\Models\payment;
use App\Models\partsorder;
use App\Models\part;
use App\Models\jobs;
use App\Models\expenditure;
use App\Models\diagnosis;
use App\Models\delivery;
use App\Models\controls;

class BackupController extends Controller
{
    /**
     * This controller will be use to manage all the Backups on Auto Serve System.
     * 
     *  - View Backups
     *  - Manage backups
     * 
     */
    public function index(Request $request)
    {
        $settingId = $request->user()->setting_id;

        // Fetch available backup files related to the user's setting_id
        $backupFiles = collect(\Storage::files('backups'))
            ->filter(function ($file) use ($settingId) {
                return str_contains($file, "backup_users_{$settingId}_");
            });

        // Fetch all backup files for all records
        $allBackups = collect(Storage::files('backups'))
            ->filter(function ($file) {
                return str_contains($file, 'backup_all_records_');
            });

        // Pass both user-specific and all-records backups to the view
        return view('backup', [
            'backups' => $backupFiles,
            'allBackups' => $allBackups
        ]);
    }

    public function backupAllRecords(Request $request)
    {
        $settingId = $request->user()->setting_id;

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

        // Convert backup data to JSON
        $backupJson = json_encode($backupData);

        // Define backup file name
        $fileName = 'backup_all_records_' . now()->format('Y_m_d_H_i_s') . '.json';

        // Store the backup file in storage/app/backups
        Storage::storeAs('backups/' . $fileName, $backupJson, 'public');

        return redirect()->route('backup')->with('message', 'Backup of all records created successfully.'. ' file '. $fileName);
    }

    public function downloadBackup($file)
    {
        $filePath = storage_path('app/backups/' . $file);

        // Log the file name and path for debugging
        \Log::info('Download request for file: ' . $file);
        \Log::info('Constructed file path: ' . $filePath);

        if (!file_exists($filePath)) {
            \Log::error('File not found: ' . $filePath);
            return redirect()->route('backup')->with('error', 'File not found. Please ensure the backup file exists.');
        }

        //return response()->download($filePath);
        return response()->file(public_path($filePath));
    }
}
