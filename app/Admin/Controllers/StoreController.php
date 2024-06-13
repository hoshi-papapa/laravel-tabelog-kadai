<?php

namespace App\Admin\Controllers;

use App\Models\Store;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StoreController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Store';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Store());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));

        $grid->categories()->display(function ($categories) {
            $categories = array_map(function ($category) {
                return $category['name'];
                // return "<span class='label label-success'>{$category['name']}  </span>";
            }, $categories);

            return join(', ', $categories);
        });

        $grid->column('image', __('Image'))->image();
        $grid->column('address', __('Address'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('email', __('Email'));
        $grid->column('business_hours', __('Business hours'));
        $grid->column('description', __('Description'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', '店舗名');
            $filter->between('created_at', '登録日')->datetime();

            //カテゴリー名での絞り込み？
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Store::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));

        $show->categories('categories')->as(function ($categories) {
            return collect($categories)->pluck('name')->implode(', ');
        });

        $show->column('image', __('Image'))->image();
        $show->column('address', __('Address'));
        $show->field('phone_number', __('Phone number'));
        $show->field('email', __('Email'));
        $show->field('business_hours', __('Business hours'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Store());

        $form->text('name', __('Name'));
        $form->multipleSelect('categories', 'カテゴリ')->options(Category::all()->pluck('name', 'id'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->email('email', __('Email'));
        $form->text('business_hours', __('Business hours'));
        $form->textarea('description', __('Description'));
        $form->image('image', __('Image'));

        return $form;
    }
}