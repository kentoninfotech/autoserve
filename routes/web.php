<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Auto Serve System AccountsController Route
Route::get('/accounts', [App\Http\Controllers\AccountsController::class, 'index'])->name('accounts.index')->middleware('role:AutoServe');
Route::get('/accounts/{id}', [App\Http\Controllers\AccountsController::class, 'show'])->name('accounts.show')->middleware('role:AutoServe');
Route::get('/accounts/edit/{id}', [App\Http\Controllers\AccountsController::class, 'edit'])->name('accounts.edit')->middleware('role:AutoServe');
Route::put('/accounts/update/{id}', [App\Http\Controllers\AccountsController::class, 'update'])->name('accounts.update')->middleware('role:AutoServe');

// Send Feedback/Equiry E-mail
Route::post('/enquiry', [App\Http\Controllers\SettingsController::class, 'webEnquiry'])->name('web.enquiry');

// Company Account Register
Route::post('/', [App\Http\Controllers\SettingsController::class, 'companyRegister'])->name('company.register');


//  Landing Page
// Route::get('/', function () {
//     return view('index');
// });


// Account Backup
Route::get('/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup')->middleware('role:Super,Admin');
// Backup all records
Route::post('/backup-all', [App\Http\Controllers\BackupController::class, 'backupAllRecords'])->name('backup.all')->middleware('role:Super,Admin');
// Route to download backup files
Route::get('/download-backup/{file}', [App\Http\Controllers\BackupController::class, 'downloadBackup'])->name('download.backup')->middleware('role:Super,Admin');
// Route to delete backup files
Route::delete('/delete-backup/{file}', [App\Http\Controllers\BackupController::class, 'deleteBackup'])->name('delete.backup')->middleware('role:Super,Admin');


Auth::routes();
// ->middleware('role:editor,approver');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

Route::get('/my_profile/{id}/', [App\Http\Controllers\HomeController::class, 'myProfile'])->name('my_profile')->middleware('role:Front-Desk,Front-Desk,Admin,Finance,Care,Super');
Route::get('/delete-member/{id}', [App\Http\Controllers\HomeController::class, 'deleteMember'])->name('delete-member')->middleware('role:Admin,Super');
Route::post('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings')->middleware('role:Super,Admin');
Route::post('/searchjobs', [App\Http\Controllers\JobsController::class, 'jobSearch'])->name('searchjobs');
Route::post('/namecheck', [App\Http\Controllers\JobsController::class, 'nameCheck'])->name('namecheck');

Route::get('/new-payment/{invoiceno}', [App\Http\Controllers\PaymentsController::class, 'newPayment'])->name('new-payment')->middleware('role:Admin,Finance,Super,Front-Desk');

Route::post('/makepayment', [App\Http\Controllers\PaymentsController::class, 'store'])->name('makepayment')->middleware('role:Admin,Finance,Super,Front-Desk');

// TASKS / TO DOs
Route::post('/newtask', [App\Http\Controllers\TasksController::class, 'store'])->name('newtask');
// Route::post('/newFinance', [App\Http\Controllers\TasksController::class, 'newFinance'])->name('newFinance')->middleware('role:Front-Desk,Admin,Finance,Care,Super');
Route::get('/tasks', [App\Http\Controllers\TasksController::class, 'index'])->name('tasks');
Route::get('/completetask/{id}', [App\Http\Controllers\TasksController::class, 'completetask'])->name('completetask');
Route::get('/inprogresstask/{id}', [App\Http\Controllers\TasksController::class, 'inprogresstask'])->name('inprogresstask');
Route::get('/delete-task/{id}', [App\Http\Controllers\TasksController::class, 'destroy'])->name('destroy')->middleware('role:Super,Admin');

// COMMUNICATION
Route::get('/reminders', [App\Http\Controllers\HomeController::class, 'reminders'])->name('reminders')->middleware('role:Admin,Super,Front-Desk');
Route::get('/communications', [App\Http\Controllers\HomeController::class, 'communications'])->name('communications')->middleware('role:Admin,Super,Front-Desk');
Route::post('/sendsms', [App\Http\Controllers\HomeController::class, 'sendSMS'])->name('sendsms')->middleware('role:Admin,Super,Front-Desk');
Route::get('/sentmessages', [App\Http\Controllers\HomeController::class, 'sentSMS'])->name('sentmessages')->middleware('role:Admin,Super,Front-Desk');
// TRANSACTIONS
Route::get('/transactions', [App\Http\Controllers\TransactionsController::class, 'index'])->name('transactions')->middleware('role:Finance,Admin,Super');
Route::post('/addtransaction', [App\Http\Controllers\TransactionsController::class, 'store'])->name('addtransaction')->middleware('role:Finance,Admin,Super');
Route::get('/delete-trans/{id}', [App\Http\Controllers\TransactionsController::class, 'destroy'])->name('delete-trans')->middleware('role:Finance,Super');

// ACCOUNT HEADS
Route::get('/account-heads', [App\Http\Controllers\AccountheadsController::class, 'index'])->name('account-heads')->middleware('role:Finance,Admin,Super');
Route::post('/addaccounthead', [App\Http\Controllers\AccountheadsController::class, 'store'])->name('addaccounthead')->middleware('role:Finance,Admin,Super');
Route::get('/delete-acch/{id}', [App\Http\Controllers\AccountheadsController::class, 'destroy'])->name('delete-acch')->middleware('role:Super');

// HELP AND SECURITY
Route::get('/help', [App\Http\Controllers\HomeController::class, 'help'])->name('help');
Route::get('/security', [App\Http\Controllers\HomeController::class, 'security'])->name('security');

// NEW KOJO LINKS
Route::get('/personnels', [App\Http\Controllers\PersonnelController::class, 'index'])->name('personnels')->middleware('role:Admin,Super');
Route::get('/users', [App\Http\Controllers\PersonnelController::class, 'Users'])->name('users')->middleware('role:Admin,Super');

Route::get('/edit-personnel/{id}', [App\Http\Controllers\PersonnelController::class, 'edit'])->name('edit-personnel')->middleware('role:Admin,Super');
Route::get('/add-personnel', [App\Http\Controllers\PersonnelController::class, 'create'])->name('add-personnel')->middleware('role:Admin,Super');
Route::post('/newpersonnel', [App\Http\Controllers\PersonnelController::class, 'store'])->name('newpersonnel')->middleware('role:Admin,Super');
Route::post('/psfuform', [App\Http\Controllers\HomeController::class, 'psfuForm'])->name('psfuform')->middleware('role:Admin,Super,Front-Desk');
Route::get('/psfu', [App\Http\Controllers\HomeController::class, 'psfu'])->name('psfu')->middleware('role:Admin,Super,Front-Desk');
Route::get('/jobpsfu/{jobno}', [App\Http\Controllers\HomeController::class, 'jobPSFU'])->name('jobpsfu')->middleware('role:Admin,Super,Front-Desk');
Route::get('/allpsfus', [App\Http\Controllers\HomeController::class, 'allPSFUs'])->name('allpsfus')->middleware('role:Admin,Super,Front-Desk');

// PARTS
Route::get('/parts', [App\Http\Controllers\PartsController::class, 'index'])->name('parts');
Route::get('/add-part', [App\Http\Controllers\PartsController::class, 'create'])->name('add-part');
Route::post('save-part', [App\Http\Controllers\PartsController::class, 'store'])->name('save-part');
Route::get('/edit-part/{partid}', [App\Http\Controllers\PartsController::class, 'edit'])->name('edit-part');
Route::post('/update-part', [App\Http\Controllers\PartsController::class, 'update'])->name('update-part');
Route::get('/delete-part/{part}', [App\Http\Controllers\PartsController::class, 'destroy'])->name('delete-part');

// SUPPLIES
Route::get('/supplies', [App\Http\Controllers\PartsController::class, 'partSupplies'])->name('supplies');
Route::get('/add-supply', [App\Http\Controllers\PartsController::class, 'addSupply'])->name('add-supply');
Route::post('save-supply', [App\Http\Controllers\PartsController::class, 'saveSupply'])->name('save-supply');
Route::get('/delete-supply/{sid}', [App\Http\Controllers\PartsController::class, 'deleteSupply'])->name('delete-supply');


// PART/PRODUCT SALES
Route::get('/sales', [App\Http\Controllers\PartsorderController::class, 'index'])->name('sales');
Route::get('/new-sales', [App\Http\Controllers\JobsController::class, 'newSales'])->name('new-sales')->middleware('role:Front-Desk,Admin,Super');
Route::post('/add-sales', [App\Http\Controllers\JobsController::class, 'addSales'])->name('add-sales')->middleware('role:Front-Desk,Admin,Super');


// CONTACTS AND JOBS
Route::get('/customers', [App\Http\Controllers\ContactsController::class, 'index'])->name('customers')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');
Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');
Route::get('/edit-customer/{customerid}', [App\Http\Controllers\ContactsController::class, 'edit'])->name('edit-customer')->middleware('role:Front-Desk,Admin,Super');
Route::get('/edit-vehicle/{id}', [App\Http\Controllers\VehicleController::class, 'edit'])->name('edit-vehicle')->middleware('role:Front-Desk,Admin,Super');


Route::post('/editcustomer', [App\Http\Controllers\ContactsController::class, 'update'])->name('editcustomer')->middleware('role:Admin,Super,Front-Desk');
Route::post('/editvehicle', [App\Http\Controllers\VehicleController::class, 'update'])->name('editvehicle')->middleware('role:Admin,Super,Front-Desk');

// MERGE CONTACTS
Route::post('/mergecontacts', [App\Http\Controllers\ContactsController::class, 'mergeContacts'])->name('mergecontacts')->middleware('role:Admin,Super,Front-Desk');

Route::get('/jobs', [App\Http\Controllers\JobsController::class, 'index'])->name('jobs')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');
Route::get('/completedjobs', [App\Http\Controllers\JobsController::class, 'completedJobs'])->name('completedjobs')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');

Route::get('/customer-jobs/{customerid}', [App\Http\Controllers\JobsController::class, 'customerJobs'])->name('customer-jobs')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');
Route::get('/vehicle-jobs/{vregno}', [App\Http\Controllers\JobsController::class, 'vehicleJobs'])->name('vehicle-jobs')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');

Route::get('/customer-vehicles/{customerid}', [App\Http\Controllers\VehicleController::class, 'customerVehicles'])->name('customer-vehicles')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');

Route::get('/newjob', [App\Http\Controllers\JobsController::class, 'create'])->name('newjob')->middleware('role:Front-Desk,Admin,Super');
Route::get('/newcjob/{customerid}', [App\Http\Controllers\JobsController::class, 'newCustomerJob'])->name('newcjob')->middleware('role:Front-Desk,Admin,Super');
Route::get('/newvjob/{customerid}/{vreg}', [App\Http\Controllers\JobsController::class, 'newVehicleJob'])->name('newvjob')->middleware('role:Front-Desk,Admin,Super');
Route::get('/edit-job/{jobno}', [App\Http\Controllers\JobsController::class, 'editJob'])->name('edit-job')->middleware('role:Front-Desk,Admin,Spare-Parts,Super');
Route::post('/addnewcustomer', [App\Http\Controllers\JobsController::class, 'store'])->name('addnewcustomer')->middleware('role:Admin,Super,Front-Desk,Spare-Parts');
Route::post('/addjobno', [App\Http\Controllers\JobsController::class, 'addJobno'])->name('addjobno')->middleware('role:Admin,Super,Front-Desk');
Route::get('/invoice/{jobno}/{type}', [App\Http\Controllers\JobsController::class, 'printInvoice'])->name('invoice');
Route::post('/filterjobs', [App\Http\Controllers\JobsController::class, 'filterJobs'])->name('filterjobs')->middleware('role:Admin,Super,Front-Desk,Spare-Parts');
Route::post('/filterTransactions', [App\Http\Controllers\TransactionsController::class, 'filterTransactions'])->name('filterTransactions')->middleware('role:Admin,Super,Finance');
// Create link to download diagnosis->diagnosis file
Route::get('/diagnosis-file/{jobno}', [App\Http\Controllers\JobsController::class, 'diagnosisFile'])->name('diagnosis-file')->middleware('role:Front-Desk,Admin,Finance,Super,Spare-Parts');
// Job Images Gallery
Route::get('/job-gallery/{jobno}', [App\Http\Controllers\JobsController::class, 'showGallery'])->name('vehicle.gallery');


// JOB CONTROLS
Route::get('/job-controls', [App\Http\Controllers\ControlsController::class, 'index'])->name('job-controls')->middleware('role:Admin,Super,Front-Desk');
Route::post('/assignedToTechnician', [App\Http\Controllers\ControlsController::class, 'store'])->name('assignedToTechnician')->middleware('role:Admin,Super,Front-Desk');
Route::get('/delete-control/{id}', [App\Http\Controllers\ControlsController::class, 'destroy'])->name('delete-control')->middleware('role:Admin,Super,Front-Desk');
// print controls
Route::get('/print-controls', [App\Http\Controllers\ControlsController::class, 'printControls'])->name('print-controls')->middleware('role:Admin,Super,Front-Desk');
// DELIVERIES
Route::resource('deliveries', App\Http\Controllers\DeliveryController::class);
Route::post('actualDelivery',[App\Http\Controllers\DeliveryController::class,'actualDelivery'])->name('actualDelivery');
Route::get('/delivery_note/{did}',[App\Http\Controllers\DeliveryController::class,'deliveryNote'])->name('delivery-note');

Route::post('/changedate', [App\Http\Controllers\JobsController::class, 'changedate'])->name('changedate')->middleware('role:Admin,Super,Front-Desk');

// PAYMENTS
Route::get('/payments', [App\Http\Controllers\PaymentsController::class, 'index'])->name('payments')->middleware('role:Admin,Finance,Super,Front-Desk');
Route::get('/debtors', [App\Http\Controllers\PaymentsController::class, 'debtors'])->name('debtors')->middleware('role:Admin,Finance,Super,Front-Desk');

// ATTENDANCE MANAGEMENT
Route::get('/attendance', [App\Http\Controllers\AttendancesController::class, 'index'])->name('attendances')->middleware('role:Admin,Super,Front-Desk');
Route::post('/present/{pid}', [App\Http\Controllers\AttendancesController::class, 'store'])->name('present')->middleware('role:Admin,Super,Front-Desk');
Route::get('/attendances', [App\Http\Controllers\AttendancesController::class, 'Attendances'])->name('attendances')->middleware('role:Admin,Super,Front-Desk');

Route::get('/delete/{id}/{table}', [App\Http\Controllers\JobsController::class, 'genericDelete'])->name('delete')->middleware('role:Admin,Super');
// ARTISAN COMMANDS
Route::get('/artisan1/{command}', [App\Http\Controllers\TasksController::class, 'Artisan1']);
Route::get('/artisan2/{command}/{param}', [App\Http\Controllers\TasksController::class, 'Artisan2']);
