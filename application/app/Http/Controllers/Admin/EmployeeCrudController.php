<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Models\Branch;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    // add Crudpermission trait to controll access to operations
    use \App\Http\Traits\CrudPermissionTrait;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
        $this->setAccessUsingPermissions();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('avatar')->type('image')->prefix('storage/'); //showing image correctly
        CRUD::column('email')->remove();
        CRUD::column('branch')->remove();
        CRUD::column('username')->remove();
        CRUD::column('password')->remove();
        CRUD::column('role')->remove();

        // CRUD::column([
        //     // 1-n relationship
        //     'label'     => 'branch', // Table column heading
        //     'type'      => 'select',
        //     'name'      => 'branches_employee_id', // the column that contains the ID of that connected entity;
        //     'entity'    => 'branches', // the method that defines the relationship in your Model
        //     'attribute' => 'name', // foreign key attribute that is shown to user
        //     'model'     => "App\Models\Branch", // foreign key model
        // ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $branch = new Branch();
        if ($branch::all('id')->isNotEmpty()) {

            CRUD::setValidation(EmployeeRequest::class);
            CRUD::setFromDb(); // set fields from db columns.

            CRUD::field([
                'name' => 'avatar',
                'label' => 'profile avatar:',
                'type' => 'upload',
                'withFiles' => [
                    'path' => 'employee/avatar'
                ]
            ]);

            CRUD::field([
                'label' => "Branch",
                'type' => 'select',
                'name' => 'branch_id',
                'model' => "App\Models\Branch",
                'attribute' => 'name',
            ]);

            CRUD::field([
                'label' => "Role",
                'type' => 'select',
                'name' => 'role_id',
                'model' => "App\Models\Role",
                'attribute' => 'name',
            ])->on('saving', function ($entry) {
                $entry->syncRoles($entry->role_id);
            });
        } else {
            return Alert::error('There is not any branch. first create a branch.');
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupDeleteOperation()
    {
        // CRUD::field('photo')->type('upload')->withFiles();

        // Alternatively, if you are not doing much more than defining fields in your create operation:
        $this->setupCreateOperation();
    }

    // if you just want to show the same columns as inside ListOperation
    protected function setupShowOperation()
    {
        CRUD::column([
            'name' => 'name',
            'tab' => 'general'
        ]);

        CRUD::column('avatar')->type('image')->prefix('storage/')->tab('general'); //showing image correctly

        CRUD::column([
            'name' => 'job_title',
            'tab' => 'general'
        ]);

        CRUD::column([
            'name' => 'username',
            'tab' => 'Account information'
        ]);

        CRUD::column([
            'name' => 'password',
            'type' => 'password',
            'tab' => 'Account information'
        ]);
    }
}
