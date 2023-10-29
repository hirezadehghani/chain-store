<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Category;
use Backpack\CRUD\app\Library\Widget;
use Prologue\Alerts\Facades\Alert;

use function React\Promise\all;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
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

        CRUD::column('image')->type('image')->prefix('storage/'); //showing image correctly
        CRUD::column([
            'label'     => 'category', // Table column heading
            'type'      => 'select',
            'name'      => 'category_id', // the column that contains the ID of that connected entity;
            'entity'    => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => "App\Models\Category", // foreign key model
        ]);

        CRUD::setFromDb(); // set columns from db columns.

        /**
         * show article like sketch at doc folder
         * bug: can not access to column data.
         */
        // Widget::add(
        //     [
        //         'type'       => 'card',
        //         // 'wrapper' => ['class' => 'col-sm-6 col-md-4'], // optional
        //         // 'class'   => 'card bg-dark text-white', // optional
        //         'content'    => [
        //             'header' => 'r', // optional
        //             'body'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
        //         ]
        //     ]
        // );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $category = new Category();
        if ($category::all('id')->isNotEmpty()) {
            CRUD::setValidation(ArticleRequest::class);
            CRUD::setFromDb(); // set fields from db columns.
            CRUD::field([
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id',
                'model' => "App\Models\Category",
                'attribute' => 'title',
            ]);
            CRUD::field([
                'name' => 'image',
                'label' => 'Image:',
                'type' => 'upload',
                'withFiles' => [
                    'path' => 'article/thumbnails'
                ]
            ]);
        } else {
            return Alert::error('There is not any category. first create a category.');
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

    protected function setupShowOperation()
    {

        CRUD::column('image')->type('image')->prefix('storage/'); //showing image correctly
        CRUD::setFromDb(); // set columns from db columns.
    }
}
