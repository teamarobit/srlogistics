<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




/* ── DEV: patch IP logos — remove after use ──────────────────────── */
Route::get('/dev/patch-ip-logos', function () {
    $logos = ['INS-001'=>'logo_new_india.svg','INS-002'=>'logo_united_india.svg','INS-003'=>'logo_icici_lombard.svg','INS-004'=>'logo_bajaj_allianz.svg','INS-005'=>'logo_hdfc_ergo.svg'];
    $n = 0;
    foreach ($logos as $code => $logo) { $n += \DB::table('contacts')->where('contact_code',$code)->update(['contact_image'=>$logo]); }
    return response()->json(['patched'=>$n,'logos'=>$logos]);
});
Route::get('/', function () {
    return redirect('/login');
});



Auth::routes();

// \URL::forceScheme('https');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request'); 
Route::post('/update-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'updatePassword'])->name('password.change');



Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/admin-console', [App\Http\Controllers\AdminController::class, 'index'])->name('adminconsole.index');

    /******************************** Warehouse Module ******************************************/

    Route::prefix('warehouse')->name('warehouse.')->group(function () {
        Route::get   ('/master',                    [App\Http\Controllers\WarehouseController::class, 'index'])->name('master.index');
        Route::get   ('/master/create',             [App\Http\Controllers\WarehouseController::class, 'create'])->name('master.create');
        Route::post  ('/master',                    [App\Http\Controllers\WarehouseController::class, 'store'])->name('master.store');
        Route::get   ('/master/{warehouse}/edit',   [App\Http\Controllers\WarehouseController::class, 'edit'])->name('master.edit');
        Route::put   ('/master/{warehouse}',        [App\Http\Controllers\WarehouseController::class, 'update'])->name('master.update');
        Route::delete('/master/{warehouse}',        [App\Http\Controllers\WarehouseController::class, 'destroy'])->name('master.destroy');
    });

    // Cities by state_id (used by warehouse + other forms)
    Route::get('/get-cities-by-state/{stateId}', [App\Http\Controllers\WarehouseController::class, 'getCitiesByState'])->name('warehouse.cities.by-state');

    Route::get('/get-cities/{state}', [App\Http\Controllers\CustomController::class, 'getCities'])->name('getcities'); 
    
    Route::get('/get-rto-charges/{id}', [App\Http\Controllers\GeneralController::class, 'getRtoCharges'])->name('rto.charges');
    Route::get('/get-toll-charges/{id}', [App\Http\Controllers\GeneralController::class, 'getTollCharges'])->name('toll.charges');
    
    
    // Contacts group
    Route::prefix('contacts')
        ->name('contact.')
        ->group(function () {

            Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('index');
            Route::post('/delete', [App\Http\Controllers\ContactController::class, 'destroy'])->name('delete');
            Route::post('/save-activity-note', [App\Http\Controllers\ContactController::class, 'storeActivityNotes'])->name('activitynotes.save');
            
            Route::post('/attachment/{id}/delete', [App\Http\Controllers\ContactController::class, 'deleteAttachment'])->name('deleteattachment');
            Route::post('/attachment-warapper', [App\Http\Controllers\ContactController::class, 'attachmentWrapper'])->name('attachmentwrapper');
            Route::post('/upload/images', function () {
                return response()->json(['success' => true]);
            })->name('upload.images');
            
            Route::post('/update-attachment', [App\Http\Controllers\ContactController::class, 'updateAttachment'])->name('updateattachment');
            
            
            Route::post('/delete-selected',[App\Http\Controllers\ContactController::class,'deleteSelected'])->name('delete.selected');
            Route::post('/delete-all',[App\Http\Controllers\ContactController::class,'deleteAll'])->name('delete.all');
            
            
            
            
            
            // customer 
            Route::get('/customers', [App\Http\Controllers\ContactController::class, 'customerList'])->name('customer.index');
            Route::get('/customer/create', [App\Http\Controllers\ContactController::class, 'createCustomer'])->name('customer.create');
            Route::post('/customer/save', [App\Http\Controllers\ContactController::class, 'storeCustomer'])->name('customer.save');
            Route::get('/customer/{id}/edit', [App\Http\Controllers\ContactController::class, 'editCustomer'])->name('customer.edit');
            Route::post('/customer/{id}/update', [App\Http\Controllers\ContactController::class, 'updateCustomer'])->name('customer.update');
            Route::post('/customer-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'customer_contactPersonWrapper'])->name('customer.contactpersonwrapper');
            
            // customer location
            Route::get('/customer/{id}/locations', [App\Http\Controllers\ContactController::class, 'filterCustomerLocations'])->name('customer.filter.locations');
            Route::post('/customer/location/save', [App\Http\Controllers\ContactController::class, 'storeCustomerLocation'])->name('customer.location.save');
            Route::post('/customer/location/delete', [App\Http\Controllers\ContactController::class, 'deleteCustomerLocation'])->name('customer.location.delete');
            Route::post('/customer/location/midpoints', [App\Http\Controllers\ContactController::class, 'getLocationMidpoints'])->name('customer.get.location.midpoints');
            
            // customer contract
            Route::get('/customer/{customerid}/contract', [App\Http\Controllers\ContactController::class, 'showCustomerContractForm'])->name('customer.contract');
            Route::post('/customer/contract/save', [App\Http\Controllers\ContactController::class, 'storeCustomerContract'])->name('customer.contract.save');
            Route::get('/customer/contracts', [App\Http\Controllers\ContactController::class, 'customerContractList'])->name('customer.contract.list');
            Route::post('/customer/contract/delete', [App\Http\Controllers\ContactController::class, 'deleteCustomerContract'])->name('customer.contract.delete');
            
            Route::get('/customer/contract/{id}/edit', [App\Http\Controllers\ContactController::class, 'editCustomerContract'])->name('customer.contract.edit');
            Route::post('/customer/contract/{id}/update', [App\Http\Controllers\ContactController::class, 'updateCustomerContract'])->name('customer.contract.update');
            
            Route::get('/contract/{id}/routes', [App\Http\Controllers\ContactController::class, 'getContractRoutes'])->name('customer.contract.routes');
            
            
            // customer contract pricing
            Route::post('/customer/contract-pricing/save', [App\Http\Controllers\ContactController::class, 'storeCustomerContractPricing'])->name('customer.contract.pricing.save');
            Route::post('/customer/contract-pricing/delete', [App\Http\Controllers\ContactController::class, 'deleteCustomerContractPricing'])->name('customer.contract.pricing.delete');
            Route::get('/customer/contract-pricing/{id}/labour-charges/', [App\Http\Controllers\ContactController::class, 'getLabourCharges'])->name('customer.contract.pricing.labour.charges');
            Route::get('/customer/contract-pricing/{id}/vehicles', [App\Http\Controllers\ContactController::class, 'getVehicleFreight'])->name('customer.contract.pricing.vehicles');
            Route::get('/customer/contract-pricing/{id}/history', [App\Http\Controllers\ContactController::class, 'getPricingHistory'])->name('customer.contract.pricing.history');
            
            
            // customer vehicle allocation
            Route::get('/customer/{id}/vehicles', [App\Http\Controllers\ContactController::class, 'filterCustomerVehicles'])->name('customer.vehicles');
            Route::post('/customer/vehicle/save', [App\Http\Controllers\ContactController::class, 'storeCustomerVehicle'])->name('customer.vehicle.save');
            
            
            
            
            
            
            
            
            
            // Load Vendor (Broker)
            Route::get('/loadvendors', [App\Http\Controllers\ContactController::class, 'loadvendorList'])->name('loadvendor.index');
            Route::get('/loadvendor/create', [App\Http\Controllers\ContactController::class, 'createLoadvendor'])->name('loadvendor.create');
            Route::post('/loadvendor/save', [App\Http\Controllers\ContactController::class, 'storeLoadvendor'])->name('loadvendor.save');
            Route::get('/loadvendor/{id}/edit', [App\Http\Controllers\ContactController::class, 'editLoadvendor'])->name('loadvendor.edit');
            Route::post('/loadvendor/{id}/update', [App\Http\Controllers\ContactController::class, 'updateLoadvendor'])->name('loadvendor.update');
            Route::post('/loadvendor-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'loadvendor_contactPersonWrapper'])->name('loadvendor.contactpersonwrapper');
            
            // load vendor location
            Route::post('/loadvendor/location/save', [App\Http\Controllers\ContactController::class, 'storeLoadvendorLocation'])->name('loadvendor.location.save');
            Route::post('/loadvendor/location/delete', [App\Http\Controllers\ContactController::class, 'deleteLoadvendorLocation'])->name('loadvendor.location.delete');
            Route::post('/loadvendor/location/midpoints', [App\Http\Controllers\ContactController::class, 'getLoadvendorMidpoints'])->name('loadvendor.get.location.midpoints');
            Route::get('/loadvendor/{id}/locations', [App\Http\Controllers\ContactController::class, 'filterLoadvendorLocations'])->name('loadvendor.filter.locations');
            
            
            
            
            
            
            
            // employee 
            Route::get('/employees', [App\Http\Controllers\ContactController::class, 'employeeList'])->name('employee.index');
            Route::get('/employee/create', [App\Http\Controllers\ContactController::class, 'createEmployee'])->name('employee.create');
            Route::post('/employee/save', [App\Http\Controllers\ContactController::class, 'storeEmployee'])->name('employee.save');
            Route::post('/employee-emergency-contact-warapper', [App\Http\Controllers\ContactController::class, 'employee_emergency_contact_wrapper'])->name('employee.emergencycontactwrapper');
            Route::get('/employee/{id}/edit', [App\Http\Controllers\ContactController::class, 'editEmployee'])->name('employee.edit');
            Route::post('/employee/{id}/update', [App\Http\Controllers\ContactController::class, 'updateEmployee'])->name('employee.update');
            
            Route::post('/employee/store-asset', [App\Http\Controllers\ContactController::class, 'storeEmployeeAsset'])->name('employee.asset.store');
            Route::post('/employee/revoke-asset', [App\Http\Controllers\ContactController::class, 'revokeEmployeeAsset'])->name('employee.asset.revoke');
            
            Route::post('/employee/store-work-experience', [App\Http\Controllers\ContactController::class, 'storeEmployeeWorkExperience'])->name('employee.work.experience.store');
            
            Route::post('/employee/store-salary', [App\Http\Controllers\ContactController::class, 'storeEmployeeSalary'])->name('employee.salary.store');
            
            
            Route::get('/employee/{id}/joining-letter', [App\Http\Controllers\ContactController::class, 'getJoiningLetter'])->name('employee.joining.letter');
            Route::post('/employee/update-seen-status', [App\Http\Controllers\ContactController::class, 'updateLetterSeenStatus'])->name('employee.update.letter.seen.status');
            
            
            Route::post('/employee/store-exit-details', [App\Http\Controllers\ContactController::class, 'storeEmployeeExitDetails'])->name('employee.exit.details.store');
            Route::get('/employee/{id}/exit-letter', [App\Http\Controllers\ContactController::class, 'getExitLetter'])->name('employee.exit.letter');
            
            
            
            // driver 
            Route::get('/drivers', [App\Http\Controllers\ContactController::class, 'driverList'])->name('driver.index');
            Route::get('/driver/create', [App\Http\Controllers\ContactController::class, 'createDriver'])->name('driver.create');
            Route::post('/driver/save', [App\Http\Controllers\ContactController::class, 'storeDriver'])->name('driver.save');
            Route::get('/driver/{id}/edit', [App\Http\Controllers\ContactController::class, 'editDriver'])->name('driver.edit');
            Route::post('/driver/{id}/update', [App\Http\Controllers\ContactController::class, 'updateDriver'])->name('driver.update'); 
            Route::post('/driver-emergency-contact-warapper', [App\Http\Controllers\ContactController::class, 'driver_emergency_contact_wrapper'])->name('driver.emergencycontactwrapper');
            
            Route::post('/driver/store-work-experience', [App\Http\Controllers\ContactController::class, 'storeDriverWorkExperience'])->name('driver.work.experience.store');
            
            Route::post('/driver-bank-warapper', [App\Http\Controllers\ContactController::class, 'driver_bankWrapper'])->name('driver.bankwrapper');
            
            Route::get('/driver/{id}/joining-letter', [App\Http\Controllers\ContactController::class, 'getDriverJoiningLetter'])->name('driver.joining.letter');
            Route::post('/driver/update-seen-status', [App\Http\Controllers\ContactController::class, 'updateDriverLetterSeenStatus'])->name('driver.update.letter.seen.status');
            
            Route::post('/driver/store-exit-details', [App\Http\Controllers\ContactController::class, 'storeDriverExitDetails'])->name('driver.exit.details.store');
            Route::get('/driver/{id}/exit-letter', [App\Http\Controllers\ContactController::class, 'getDriverExitLetter'])->name('driver.exit.letter');
            
            
            
            
            // Vehicle Vendor 
            Route::get('/vehiclevendors', [App\Http\Controllers\ContactController::class, 'vehiclevendorList'])->name('vehiclevendor.index');
            Route::get('/vehiclevendor/create', [App\Http\Controllers\ContactController::class, 'createVehiclevendor'])->name('vehiclevendor.create');
            Route::post('/vehiclevendor/save', [App\Http\Controllers\ContactController::class, 'storeVehiclevendor'])->name('vehiclevendor.save');
            Route::get('/vehiclevendor/{id}/edit', [App\Http\Controllers\ContactController::class, 'editVehiclevendor'])->name('vehiclevendor.edit');
            Route::post('/vehiclevendor/{id}/update', [App\Http\Controllers\ContactController::class, 'updateVehiclevendor'])->name('vehiclevendor.update'); 
            Route::post('/vehiclevendor-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'vehiclevendor_contactPersonWrapper'])->name('vehiclevendor.contactpersonwrapper');
            Route::post('/vehiclevendor-bank-warapper', [App\Http\Controllers\ContactController::class, 'vehiclevendor_bankWrapper'])->name('vehiclevendor.bankwrapper');
            
            // Tyre Vendor 
            Route::get('/tyrevendors', [App\Http\Controllers\ContactController::class, 'tyreVendorList'])->name('tyrevendor.index');
            Route::get('/tyrevendor/create', [App\Http\Controllers\ContactController::class, 'createTyreVendor'])->name('tyrevendor.create');
            Route::post('/tyrevendor/save', [App\Http\Controllers\ContactController::class, 'storeTyreVendor'])->name('tyrevendor.save');
            Route::get('/tyrevendor/{id}/edit', [App\Http\Controllers\ContactController::class, 'editTyreVendor'])->name('tyrevendor.edit');
            Route::post('/tyrevendor/{id}/update', [App\Http\Controllers\ContactController::class, 'updateTyreVendor'])->name('tyrevendor.update'); 
            Route::post('/tyrevendor-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'tyrevendor_contactPersonWrapper'])->name('tyrevendor.contactpersonwrapper');
            Route::post('/tyrevendor-bank-warapper', [App\Http\Controllers\ContactController::class, 'tyrevendor_bankWrapper'])->name('tyrevendor.bankwrapper');
            
            
            // Spare Part Vendor
            Route::get('/sparevendors', [App\Http\Controllers\ContactController::class, 'spareVendorList'])->name('sparevendor.index');
            Route::get('/sparevendor/create', [App\Http\Controllers\ContactController::class, 'createSpareVendor'])->name('sparevendor.create');
            Route::post('/sparevendor/save', [App\Http\Controllers\ContactController::class, 'storeSpareVendor'])->name('sparevendor.save');
            Route::get('/sparevendor/{id}/edit', [App\Http\Controllers\ContactController::class, 'editSpareVendor'])->name('sparevendor.edit');
            Route::post('/sparevendor/{id}/update', [App\Http\Controllers\ContactController::class, 'updateSpareVendor'])->name('sparevendor.update');
            Route::post('/sparevendor/{id}/toggle-status', [App\Http\Controllers\ContactController::class, 'toggleSpareVendorStatus'])->name('sparevendor.toggle-status');
            Route::delete('/sparevendor/{id}', [App\Http\Controllers\ContactController::class, 'destroySpareVendor'])->name('sparevendor.destroy');
            Route::post('/sparevendor-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'sparevendor_contactPersonWrapper'])->name('sparevendor.contactpersonwrapper');
            Route::post('/sparevendor-bank-warapper', [App\Http\Controllers\ContactController::class, 'sparevendor_bankWrapper'])->name('sparevendor.bankwrapper');

            // Battery Vendor
            Route::get('/batteryvendors', [App\Http\Controllers\ContactController::class, 'batteryVendorList'])->name('batteryvendor.index');
            Route::get('/batteryvendor/create', [App\Http\Controllers\ContactController::class, 'createBatteryVendor'])->name('batteryvendor.create');
            Route::post('/batteryvendor/save', [App\Http\Controllers\ContactController::class, 'storeBatteryVendor'])->name('batteryvendor.save');
            Route::get('/batteryvendor/{id}/edit', [App\Http\Controllers\ContactController::class, 'editBatteryVendor'])->name('batteryvendor.edit');
            Route::post('/batteryvendor/{id}/update', [App\Http\Controllers\ContactController::class, 'updateBatteryVendor'])->name('batteryvendor.update'); 
            Route::post('/batteryvendor-contactperson-warapper', [App\Http\Controllers\ContactController::class, 'batteryvendor_contactPersonWrapper'])->name('batteryvendor.contactpersonwrapper');
            Route::post('/batteryvendor-bank-warapper', [App\Http\Controllers\ContactController::class, 'batteryvendor_bankWrapper'])->name('batteryvendor.bankwrapper');

            // Insurance Providers (modal-based, no separate create/edit pages)
            Route::get   ('/insurance-providers',            [App\Http\Controllers\ContactController::class, 'insuranceProviderList'])->name('insuranceprovider.index');
            Route::get   ('/insurance-provider/{id}/json',   [App\Http\Controllers\ContactController::class, 'getInsuranceProvider'])->name('insuranceprovider.json');
            Route::post  ('/insurance-provider/save',        [App\Http\Controllers\ContactController::class, 'storeInsuranceProvider'])->name('insuranceprovider.save');
            Route::post  ('/insurance-provider/{id}/update', [App\Http\Controllers\ContactController::class, 'updateInsuranceProvider'])->name('insuranceprovider.update');
            Route::post  ('/insurance-provider/{id}/toggle-status', [App\Http\Controllers\ContactController::class, 'toggleInsuranceProviderStatus'])->name('insuranceprovider.toggle-status');
            Route::delete('/insurance-provider/{id}',        [App\Http\Controllers\ContactController::class, 'destroyInsuranceProvider'])->name('insuranceprovider.destroy');

        });
        
        
        
    
    
    // Location Points
    Route::prefix('locationpoints')
        ->name('locationpoint.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\LocationPointController::class, 'index'])->name('index');
            
        });
        
        
        
        
    
    // Toll stations
    Route::prefix('tollstations')
        ->name('tollstation.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\TollstationController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\TollstationController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\TollstationController::class, 'store'])->name('save');
            Route::get('/{id}/edit', [App\Http\Controllers\TollstationController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\TollstationController::class, 'update'])->name('update');
            Route::post('/delete', [App\Http\Controllers\TollstationController::class, 'destroy'])->name('delete');
        });
        
        
        
    // RTO Checkpoint
    Route::prefix('rtos')
        ->name('rto.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\RtoController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\RtoController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\RtoController::class, 'store'])->name('save');
            Route::get('/{id}/edit', [App\Http\Controllers\RtoController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\RtoController::class, 'update'])->name('update');
            Route::post('/delete', [App\Http\Controllers\RtoController::class, 'destroy'])->name('delete');
        });
        
      
        
    // Routes  
    Route::prefix('transport-routes')
        ->name('route.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\RouteController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\RouteController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\RouteController::class, 'store'])->name('save');
            Route::get('/{id}/edit', [App\Http\Controllers\RouteController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\RouteController::class, 'update'])->name('update');
            Route::post('/delete', [App\Http\Controllers\RouteController::class, 'destroy'])->name('delete');
        });
        
    
    
    // Department
    Route::prefix('departments')->name('department.')->group(function () {
        Route::get('/', [App\Http\Controllers\DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\DepartmentController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\DepartmentController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('delete');
        
    }); 
    
    
    // Designation
    Route::prefix('designations')->name('designation.')->group(function () {
        Route::get('/', [App\Http\Controllers\DesignationController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\DesignationController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\DesignationController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\DesignationController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\DesignationController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\DesignationController::class, 'destroy'])->name('delete');
        Route::get('/get-designations/{department}', [App\Http\Controllers\DesignationController::class, 'getDesignationsByDepartment'])->name('getDepartmentWiseDesignations');
    }); 
    
    
    // Skill Set
    Route::prefix('skillsets')->name('skillset.')->group(function () {
        Route::get('/', [App\Http\Controllers\SkillsetController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\SkillsetController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\SkillsetController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\SkillsetController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\SkillsetController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\SkillsetController::class, 'destroy'])->name('delete');
        
    }); 
    
    
    // Branch
    Route::prefix('branches')->name('branch.')->group(function () {
        Route::get('/', [App\Http\Controllers\BranchController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\BranchController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\BranchController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\BranchController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\BranchController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\BranchController::class, 'destroy'])->name('delete');
        
    }); 
    
    
    // Assets
    Route::prefix('assets')->name('asset.')->group(function () {
        Route::get('/', [App\Http\Controllers\AssetController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AssetController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\AssetController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\AssetController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\AssetController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\AssetController::class, 'destroy'])->name('delete');
        Route::get('/change-status/{id}/{status}', [App\Http\Controllers\AssetController::class, 'changeStatus'])->name('changestatus');
        Route::get('/get-assets-by-type', [App\Http\Controllers\AssetController::class, 'getAssetsByType'])->name('getAssetsByType');
        Route::get('/get-asset-details/{id}', [App\Http\Controllers\AssetController::class, 'getAssetDetails'])->name('getAssetDetails');
    });
    
    
    Route::prefix('jobranks')
        ->name('jobrank.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\JobrankController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\JobrankController::class, 'create'])->name('create');
            Route::post('/save', [App\Http\Controllers\JobrankController::class, 'store'])->name('save');
            Route::get('/{id}/edit', [App\Http\Controllers\JobrankController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\JobrankController::class, 'update'])->name('update');
            Route::post('/delete', [App\Http\Controllers\JobrankController::class, 'destroy'])->name('delete');
        });
    
    // Tyre Master
    Route::prefix('tyres')->name('tyre.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\TyreController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [App\Http\Controllers\TyreController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\TyreController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\TyreController::class, 'store'])->name('save');
        // New redesigned create page (Battery-add style) — does not modify existing /create
        Route::get('/create-new', [App\Http\Controllers\TyreController::class, 'createNew'])->name('createNew');
        Route::post('/save-new', [App\Http\Controllers\TyreController::class, 'storeNew'])->name('saveNew');
        Route::get('/{tyre}/edit', [App\Http\Controllers\TyreController::class, 'edit'])->name('edit');
        Route::post('/{tyre}/update', [App\Http\Controllers\TyreController::class, 'update'])->name('update');
        Route::get('/{tyre}/details', [App\Http\Controllers\TyreController::class, 'show'])->name('show');
        Route::post('/{tyre}/mark-as-discard', [App\Http\Controllers\TyreController::class, 'markAsDiscard'])->name('markasdiscard');
        Route::post('/{tyre}/comment/save', [App\Http\Controllers\TyreController::class, 'storeComment'])->name('comment.store');
        Route::post('/{tyre}/document/save', [App\Http\Controllers\TyreController::class, 'storeDocument'])->name('document.store');
        Route::post('/{mediadocument}/document/update', [App\Http\Controllers\TyreController::class, 'updateDocument'])->name('document.update');
        Route::post('/{media}/document/delete', [App\Http\Controllers\TyreController::class, 'destroyDocument'])->name('document.destroy');
        Route::post('/{tyre}/maintenance/store', [App\Http\Controllers\TyreController::class, 'storeMaintenance'])->name('maintenance.store');
        Route::post('/{tyre}/maintenance/{schedule}/update', [App\Http\Controllers\TyreController::class, 'updateMaintenance'])->name('maintenance.update');
        Route::post('/{tyre}/maintenance/{schedule}/delete', [App\Http\Controllers\TyreController::class, 'destroyMaintenance'])->name('maintenance.destroy');

    });
    
    // Tyre Management
    Route::prefix('tyremanage')->name('tyremanage.')->group(function () {
        Route::get('/vehicle/{vehicle}/tyre/tagging', [App\Http\Controllers\TyreManagementController::class, 'vehicleTyreTagging'])->name('vehicle.tyre.tagging');
        Route::get('/vehicle/{vehicle}/get-tyres', [App\Http\Controllers\TyreManagementController::class, 'tagTyreToVehicle'])->name('vehicle.get.available.tyres');
        Route::get('/vehicle/{vehicle}/tyre/fitment', [App\Http\Controllers\TyreManagementController::class, 'tyreFitment'])->name('vehicle.tyre.fitment');
        // AJAX: fetch warehouse tyres filtered by condition + type (returns serial + health %)
        Route::get('/get-tyre-list', [App\Http\Controllers\TyreManagementController::class, 'getTyreList'])->name('get.tyre.list');
        // POST: tag a tyre to a specific mapping position
        Route::post('/vehicle/{vehicle}/mapping/{mapping}/add-tyre', [App\Http\Controllers\TyreManagementController::class, 'addTyreToPosition'])->name('vehicle.mapping.add.tyre');
        // POST: add a spare tyre (new mapping INSERT, auto-assigns next free S-position)
        Route::post('/vehicle/{vehicle}/add-spare', [App\Http\Controllers\TyreManagementController::class, 'addSpareTyre'])->name('vehicle.add.spare');
    });
    
    /******************************** Vehicle Master **********************************************************/
    
    
    // Vehicle Management
    Route::prefix('vehicle-management')->name('vehiclemanagement.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehiclemanagementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehiclemanagementController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehiclemanagementController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehiclemanagementController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehiclemanagementController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\VehiclemanagementController::class, 'destroy'])->name('delete');
        
        Route::post('/fetch-info', [App\Http\Controllers\VehiclemanagementController::class, 'fetchVehicleInfo'])->name('fetchInfo');
    }); 
    
    
    
    // Vehicle-Type  
    Route::prefix('vehicle-type')->name('vehicletype.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehicletypeController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehicletypeController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehicletypeController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehicletypeController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehicletypeController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\VehicletypeController::class, 'destroy'])->name('delete');
        
        Route::get('/{id}/sizes', [App\Http\Controllers\VehicletypeController::class, 'getSizes'])->name('sizes');
    }); 
    
    
    // Vehicle-Group
    Route::prefix('vehicle-group')->name('vehiclegroup.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehiclegroupController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehiclegroupController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehiclegroupController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehiclegroupController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehiclegroupController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\VehiclegroupController::class, 'destroy'])->name('delete');
    }); 
    
    
    // Vehicle-Status 
    Route::prefix('vehicle-status')->name('vehiclestatus.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehiclestatusController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehiclestatusController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehiclestatusController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehiclestatusController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehiclestatusController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [App\Http\Controllers\VehiclestatusController::class, 'destroy'])->name('delete');
    });
    
    
    // Vehicle-Ownership
    Route::prefix('vehicle-ownership')->name('vehicleownership.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehicleownershipController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehicleownershipController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehicleownershipController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehicleownershipController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehicleownershipController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [App\Http\Controllers\VehicleownershipController::class, 'destroy'])->name('delete');
    });
    
    
    // Vehicle-Group-Tracking
    Route::prefix('vehicle-group-tracking')->name('vehicletracking.')->group(function () {
        Route::get('/', [App\Http\Controllers\VehicleGroupTrackingController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\VehicleGroupTrackingController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\VehicleGroupTrackingController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\VehicleGroupTrackingController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\VehicleGroupTrackingController::class, 'update'])->name('update');
        
    });
    
    
    
    /******************************** Expense Master **********************************************************/
    
    // Expense Master
    Route::prefix('expense-master')->name('expense.')->group(function () {
        Route::get('/', [App\Http\Controllers\ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\ExpenseController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\ExpenseController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('delete');
    });
    
    
    
    /******************************** Provider Master *********************************************************/
    
    // GPS
    Route::prefix('gps-provider-master')->name('gpsprovider.')->group(function () {
        Route::get('/', [App\Http\Controllers\GpsProviderController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\GpsProviderController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\GpsProviderController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\GpsProviderController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\GpsProviderController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\GpsProviderController::class, 'destroy'])->name('delete');
    });
    
    // Fasttag
    Route::prefix('fasttag-provider-master')->name('fasttagprovider.')->group(function () {
        Route::get('/', [App\Http\Controllers\FasttagProviderController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\FasttagProviderController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\FasttagProviderController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\FasttagProviderController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\FasttagProviderController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\FasttagProviderController::class, 'destroy'])->name('delete');
    });
    
    // Digital Lock
    Route::prefix('digilock-provider-master')->name('digilockprovider.')->group(function () {
        Route::get('/', [App\Http\Controllers\DigitalLockProviderController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\DigitalLockProviderController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\DigitalLockProviderController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\DigitalLockProviderController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\DigitalLockProviderController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\DigitalLockProviderController::class, 'destroy'])->name('delete');
    });
    
    
    /******************************** Fleet Dashboard **********************************************************/
    
    // Fleet Dashboard
    Route::prefix('fleet-dashboard')->name('fleetdashboard.')->group(function () {
        
        Route::get('/', [App\Http\Controllers\FleetDashboardController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\FleetDashboardController::class, 'create'])->name('create');
        Route::post('/save', [App\Http\Controllers\FleetDashboardController::class, 'store'])->name('save');
        Route::get('/{id}/edit', [App\Http\Controllers\FleetDashboardController::class, 'edit'])->name('edit');
        Route::post('/update', [App\Http\Controllers\FleetDashboardController::class, 'update'])->name('update');
        Route::post('/delete', [App\Http\Controllers\FleetDashboardController::class, 'destroy'])->name('delete');
        
        
        // vehicle-details
        Route::get('/vehicle/{id}/details', [App\Http\Controllers\FleetDashboardController::class, 'getVehicleDetails'])->name('getVehicleDetails');
        Route::get('/vehicle/{id}/details/v2', [App\Http\Controllers\FleetDashboardController::class, 'getVehicleDetailsV2'])->name('getVehicleDetailsV2');
        Route::get('/vehicle/{id}/driver-data', [App\Http\Controllers\FleetDashboardController::class, 'getDriverData'])->name('getDriverData');
        Route::post('/vehicle/update-driver', [App\Http\Controllers\FleetDashboardController::class, 'updateVehicleDriver'])->name('updateDriver');
        
        // vehicle-GPS-detail
        Route::post('/vehicle/{id}/gps-details/save', [App\Http\Controllers\FleetDashboardController::class, 'storeGpsDetails'])->name('saveGpsDetails');
        Route::get('/vehicle/{id}/gps-details/edit', [App\Http\Controllers\FleetDashboardController::class, 'editGpsDetail'])->name('editGpsDetail');
        Route::post('/vehicle/{id}/gps-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateGpsDetail'])->name('updateGpsDetail');
        
        
        // vehicle-Fasttag-detail
        Route::post('/vehicle/{id}/fasttag-details/save', [App\Http\Controllers\FleetDashboardController::class, 'storeFasttagDetails'])->name('saveFasttagDetails');
        Route::get('/vehicle/{id}/fasttag-details/edit', [App\Http\Controllers\FleetDashboardController::class, 'editFasttagDetail'])->name('editFasttagDetail');
        Route::post('/vehicle/{id}/fasttag-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateFasttagDetail'])->name('updateFasttagDetail');
        
        
        // vehicle-Tyre-detail
        // AJAX: full tyre history logs by tyre_id (eye-icon timeline modal)
        Route::get('/tyre/{tyre}/mapping-logs', [App\Http\Controllers\FleetDashboardController::class, 'getTyreMappingLogs'])->name('getTyreMappingLogs');

        Route::get('/vehicle/{vehicle}/tyre-details/create', [App\Http\Controllers\FleetDashboardController::class, 'manageTyreDetails'])->name('createTyreDetails');
        Route::post('/vehicle/{vehicle}/tyre-details/save', [App\Http\Controllers\FleetDashboardController::class, 'storeTyreDetails'])->name('saveTyreDetails');
        Route::post('/vehicle/{vehicle}/tyre-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateTyreDetails'])->name('updateTyreDetails');
        
        Route::get('/vehicle/{id}/tyre-details/edit', [App\Http\Controllers\FleetDashboardController::class, 'editTyreDetail'])->name('editTyreDetail');
        Route::post('/vehicle/{id}/tyre-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateTyreDetail'])->name('updateTyreDetail');
        
        Route::post('/delete-tyre', [App\Http\Controllers\FleetDashboardController::class, 'destroyTyre'])->name('deleteTyre');
        
        
        // vehicle-Battery-detail
        Route::post('/vehicle/{id}/battery-details/save', [App\Http\Controllers\FleetDashboardController::class, 'storeBatteryDetails'])->name('saveBatteryDetails');
        Route::get('/vehicle/{id}/battery-details/edit', [App\Http\Controllers\FleetDashboardController::class, 'editBatteryDetail'])->name('editBatteryDetail');
        Route::post('/vehicle/{id}/battery-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateBatteryDetail'])->name('updateBatteryDetail');
        Route::post('/delete-battery', [App\Http\Controllers\FleetDashboardController::class, 'destroyBattery'])->name('deleteBattery');
        
        
        
        // vehicle-Digital-Lock-detail
        Route::post('/vehicle/{id}/digilock-details/save', [App\Http\Controllers\FleetDashboardController::class, 'storeDigiLockDetails'])->name('saveDigiLockDetails');
        Route::get('/vehicle/{id}/digilock-details/edit', [App\Http\Controllers\FleetDashboardController::class, 'editDigiLockDetail'])->name('editDigiLockDetail');
        Route::post('/vehicle/{id}/digilock-details/update', [App\Http\Controllers\FleetDashboardController::class, 'updateDigiLockDetail'])->name('updateDigiLockDetail');
        Route::post('/delete-digilock', [App\Http\Controllers\FleetDashboardController::class, 'destroyDigiLock'])->name('deleteDigiLock');
        
        
        // document
        Route::post('/{vehicle}/document/save', [App\Http\Controllers\FleetDashboardController::class, 'storeDocument'])->name('document.store');
        Route::post('/{mediadocument}/document/update', [App\Http\Controllers\FleetDashboardController::class, 'updateDocument'])->name('document.update');
        Route::post('/{media}/document/delete', [App\Http\Controllers\FleetDashboardController::class, 'destroyDocument'])->name('document.destroy');
        
        // document
        Route::post('/{vehicle}/document/save', [App\Http\Controllers\FleetDashboardController::class, 'storeDocument'])->name('document.store');
        Route::post('/{mediadocument}/document/update', [App\Http\Controllers\FleetDashboardController::class, 'updateDocument'])->name('document.update');
        Route::post('/{media}/document/delete', [App\Http\Controllers\FleetDashboardController::class, 'destroyDocument'])->name('document.destroy');
        
        // comment
        Route::post('/{vehicle}/comment/save', [App\Http\Controllers\FleetDashboardController::class, 'storeComment'])->name('vehicle.comment.store');

        // ── Driver module ──────────────────────────────────────────────────────
        Route::get('/drivers',               [App\Http\Controllers\FleetDashboardController::class, 'driverDashboard'])->name('drivers');
        Route::get('/driver/{id}/details',   [App\Http\Controllers\FleetDashboardController::class, 'getDriverDetails'])->name('getDriverDetails');

    });
    
    
    // Fleet — Insurance Claims
    Route::prefix('fleet/insurance-claims')->name('fleet.insurance.')->group(function () {
        Route::get('/',        [App\Http\Controllers\FleetDashboardController::class, 'insurance'])->name('index');
        Route::get('/{id}',    [App\Http\Controllers\FleetDashboardController::class, 'insuranceDetail'])->name('detail');
        Route::post('/save',   [App\Http\Controllers\FleetDashboardController::class, 'insuranceStore'])->name('store');
        Route::post('/{id}/update-status', [App\Http\Controllers\FleetDashboardController::class, 'insuranceUpdateStatus'])->name('updateStatus');
        Route::post('/{id}/log-followup',  [App\Http\Controllers\FleetDashboardController::class, 'insuranceLogFollowup'])->name('logFollowup');
        Route::post('/{id}/settlement',    [App\Http\Controllers\FleetDashboardController::class, 'insuranceSettlement'])->name('settlement');
    });
    // Legacy redirect — keep old URL working
    Route::redirect('/fleet/insurance', '/fleet/insurance-claims', 301);
    Route::redirect('/fleet/insurance/{id}', '/fleet/insurance-claims/{id}', 301);

    // Fleet — Vehicle Insurance Policies
    Route::prefix('fleet/vehicle-insurance')->name('fleet.vehicle-insurance.')->group(function () {
        Route::get('/',            [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicies'])->name('index');
        Route::post('/',           [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicyStore'])->name('store');
        Route::put('/{id}',        [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicyUpdate'])->name('update');
        Route::delete('/{id}',     [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicyDestroy'])->name('destroy');
        Route::patch('/{id}/status',    [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicyToggleStatus'])->name('toggle-status');
        Route::delete('/{id}/document', [App\Http\Controllers\FleetDashboardController::class, 'vehicleInsurancePolicyDocumentDelete'])->name('document-delete');
    });

    // Fleet — Compliance & Insurance (Policy Renewal / Document Expiry / Permit & Fitness)
    Route::prefix('fleet/compliance')->name('fleet.compliance.')->group(function () {
        Route::get('/policy-renewal',  [App\Http\Controllers\FleetDashboardController::class, 'policyRenewal'])->name('policy-renewal');
        Route::get('/document-expiry', [App\Http\Controllers\FleetDashboardController::class, 'documentExpiry'])->name('document-expiry');
        Route::get('/permit-fitness',  [App\Http\Controllers\FleetDashboardController::class, 'permitFitness'])->name('permit-fitness');
    });

    // Vehicle-EMI
    Route::prefix('vehicle-emi')->name('vehicleemi.')->group(function () {
        Route::post('/vehicle/{id}/emi/save', [App\Http\Controllers\VehicleEmiController::class, 'storeEmi'])->name('save');
        Route::get('/vehicle/emi/{id}/edit', [App\Http\Controllers\VehicleEmiController::class, 'editEmi'])->name('edit');
        Route::post('/vehicle/{id}/emi/update', [App\Http\Controllers\VehicleEmiController::class, 'updateEmi'])->name('update');
        
        Route::post('/vehicle/{id}/finance-note/save', [App\Http\Controllers\VehicleEmiController::class, 'saveFinanceNotes'])->name('finance.note.save');
        Route::get('/vehicle/{id}/view-finance-note', [App\Http\Controllers\VehicleEmiController::class, 'getFinanceNotes'])->name('finance.note.show');
        
    });
    
    
    
    Route::post('/vehicle-file-import', [App\Http\Controllers\ImportController::class, 'uploadFile'])->name('import.file');


    /******************************** Workshop Module ******************************************/

    Route::prefix('workshop')->name('ws.')->group(function () {

        // Service Requests
        Route::get('/dashboard',        [App\Http\Controllers\WorkshopController::class, 'dashboard'])->name('dashboard');
        Route::get('/service-request',  [App\Http\Controllers\WorkshopController::class, 'serviceRequest'])->name('service-request.index');
        Route::get('/appointment',      [App\Http\Controllers\WorkshopController::class, 'appointment'])->name('appointment.index');
        Route::get('/in-token',         [App\Http\Controllers\WorkshopController::class, 'inToken'])->name('in-token.index');

        // Workshop
        Route::get('/workshop/job-cards',       [App\Http\Controllers\WorkshopController::class, 'jobCardList'])->name('workshop.job-list');
        Route::get('/workshop/job-cards/{id}',  [App\Http\Controllers\WorkshopController::class, 'jobCardDetails'])->name('workshop.job-details');
        // HIDDEN (not in use yet): Route::get('/workshop/technicians', [App\Http\Controllers\WorkshopController::class, 'technicianDashboard'])->name('workshop.tech-dashboard');
        Route::get('/workshop/billing',         [App\Http\Controllers\WorkshopController::class, 'billing'])->name('workshop.billing');
        Route::get('/workshop/delivery',        [App\Http\Controllers\WorkshopController::class, 'delivery'])->name('workshop.delivery');
        Route::get('/workshop/onroad',          [App\Http\Controllers\WorkshopController::class, 'onroadService'])->name('workshop.onroad');

        // Alerts & Reports
        Route::get('/alerts',  [App\Http\Controllers\WorkshopController::class, 'alerts'])->name('alerts');
        Route::get('/reports', [App\Http\Controllers\WorkshopController::class, 'reports'])->name('reports');

        // External Service Centre
        Route::get('/external/dispatch', [App\Http\Controllers\WorkshopController::class, 'externalDispatch'])->name('external.dispatch');
        Route::get('/external/tracker',  [App\Http\Controllers\WorkshopController::class, 'externalTracker'])->name('external.tracker');
        Route::get('/external/billing',  [App\Http\Controllers\WorkshopController::class, 'externalBilling'])->name('external.billing');
        Route::get('/external/return',   [App\Http\Controllers\WorkshopController::class, 'externalReturn'])->name('external.return');

        // Maintenance
        Route::get('/maintenance/pm-calendar', [App\Http\Controllers\WorkshopController::class, 'pmCalendar'])->name('maintenance.pm-calendar');
        Route::get('/maintenance/insurance',            [App\Http\Controllers\WorkshopController::class, 'insurance'])->name('maintenance.insurance');
        Route::get('/maintenance/insurance/{id}',       [App\Http\Controllers\WorkshopController::class, 'insuranceDetail'])->name('maintenance.insurance.detail');
        Route::post('/maintenance/insurance/vehicle/{vehicleId}/note', [App\Http\Controllers\WorkshopController::class, 'insuranceAddNote'])->name('maintenance.insurance.add-note');

        // Master Data — Workshops (unified Own + External; BA CIAA approved April 2026)
        Route::get('/master/workshops/cities',     [App\Http\Controllers\WorkshopController::class, 'masterWorkshopCities'])->name('master.workshops.cities');
        Route::get('/master/workshops',            [App\Http\Controllers\WorkshopController::class, 'masterWorkshops'])->name('master.workshops');
        Route::post('/master/workshops',           [App\Http\Controllers\WorkshopController::class, 'masterWorkshopStore'])->name('master.workshops.store');
        Route::put('/master/workshops/{id}',       [App\Http\Controllers\WorkshopController::class, 'masterWorkshopUpdate'])->name('master.workshops.update');
        Route::post('/master/workshops/{id}/change-status',    [App\Http\Controllers\WorkshopController::class, 'masterWorkshopChangeStatus'])->name('master.workshops.changestatus');
        // Legacy redirects so any bookmarked URLs don't hard-404
        Route::redirect('/master/service-centers', '/workshop/master/workshops', 301);
        Route::redirect('/master/external-sc',     '/workshop/master/workshops', 301);
        Route::get('/master/services',             [App\Http\Controllers\WorkshopController::class, 'masterServices'])->name('master.services');
        Route::get('/master/service-key-points',   [App\Http\Controllers\WorkshopController::class, 'masterServiceKeyPoints'])->name('master.service-key-points');
        // Spare Parts CRUD
        Route::get   ('/master/spare-parts',             [App\Http\Controllers\WorkshopController::class, 'masterSpareParts'])->name('master.spare-parts');
        Route::post  ('/master/spare-parts',             [App\Http\Controllers\WorkshopController::class, 'masterSparePartStore'])->name('master.spare-parts.store');
        Route::put   ('/master/spare-parts/{id}',        [App\Http\Controllers\WorkshopController::class, 'masterSparePartUpdate'])->name('master.spare-parts.update');
        Route::delete('/master/spare-parts/{id}',        [App\Http\Controllers\WorkshopController::class, 'masterSparePartDestroy'])->name('master.spare-parts.destroy');
        Route::patch ('/master/spare-parts/{id}/status', [App\Http\Controllers\WorkshopController::class, 'masterSparePartToggleStatus'])->name('master.spare-parts.toggle-status');

        Route::get   ('/master/spare-part-categories',             [App\Http\Controllers\WorkshopController::class, 'masterSparePartCategories'])->name('master.spare-part-categories');
        Route::post  ('/master/spare-part-categories',             [App\Http\Controllers\WorkshopController::class, 'masterSparePartCategoryStore'])->name('master.spare-part-categories.store');
        Route::put   ('/master/spare-part-categories/{id}',        [App\Http\Controllers\WorkshopController::class, 'masterSparePartCategoryUpdate'])->name('master.spare-part-categories.update');
        Route::delete('/master/spare-part-categories/{id}',        [App\Http\Controllers\WorkshopController::class, 'masterSparePartCategoryDestroy'])->name('master.spare-part-categories.destroy');
        Route::patch ('/master/spare-part-categories/{id}/status', [App\Http\Controllers\WorkshopController::class, 'masterSparePartCategoryToggleStatus'])->name('master.spare-part-categories.toggle-status');

        Route::get('/master/maintenance-items',    [App\Http\Controllers\WorkshopController::class, 'masterMaintenanceItems'])->name('master.maintenance-items');
        Route::get('/master/fault-codes',          [App\Http\Controllers\WorkshopController::class, 'masterFaultCodes'])->name('master.fault-codes');

    });

    /******************************** Inventory Module ******************************************/

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/dashboard',        [App\Http\Controllers\WorkshopController::class, 'inventoryDashboard'])->name('dashboard');
        Route::get('/spare-parts',      [App\Http\Controllers\WorkshopController::class, 'spareParts'])->name('spare-parts');
        Route::get('/tyres',            [App\Http\Controllers\WorkshopController::class, 'tyreInventory'])->name('tyres');
        Route::get('/batteries',        [App\Http\Controllers\WorkshopController::class, 'batteryInventory'])->name('batteries');
        Route::get('/battery-dashboard',[App\Http\Controllers\WorkshopController::class, 'batteryDashboard'])->name('battery-dashboard');
        Route::get('/battery/add',          [App\Http\Controllers\WorkshopController::class, 'createBattery'])->name('battery.add');
        Route::get('/battery/action',       [App\Http\Controllers\WorkshopController::class, 'batteryAction'])->name('battery.action');
        Route::get('/battery/{id}',         [App\Http\Controllers\WorkshopController::class, 'batteryDetails'])->name('battery.details');
        Route::get('/battery/{id}/fit',     [App\Http\Controllers\WorkshopController::class, 'batteryFit'])->name('battery.fit');
        Route::get('/battery/{id}/replace', [App\Http\Controllers\WorkshopController::class, 'batteryReplace'])->name('battery.replace');
        Route::get('/purchase-orders',      [App\Http\Controllers\WorkshopController::class, 'poList'])->name('purchase-orders');
        Route::get('/purchase-orders/{id}', [App\Http\Controllers\WorkshopController::class, 'poDetail'])->name('po-detail');
        Route::get('/goods-receipt',        [App\Http\Controllers\WorkshopController::class, 'grn'])->name('goods-receipt');
        Route::get('/goods-receipt/{id}',   [App\Http\Controllers\WorkshopController::class, 'grnDetail'])->name('grn-detail');
        Route::get('/stock-transfer',       [App\Http\Controllers\WorkshopController::class, 'stockTransfer'])->name('stock-transfer');
    });


}); 
    