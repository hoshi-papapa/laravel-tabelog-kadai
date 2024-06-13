<?php

namespace App\Admin\Controllers;

use App\Models\Review;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReviewController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Review';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Review());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('user_id', __('User id'))->sortable();
        $grid->column('store_id', __('Store id'))->sortable();
        $grid->column('rating', __('Rating'))->sortable();
        $grid->column('comment', __('Comment'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('user_id', __('User id'));
            $filter->like('store_id', __('Store id'));
            $filter->between('created_at', '登録日')->datetime();
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
        $show = new Show(Review::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('store_id', __('Store id'));
        $show->field('rating', __('Rating'));
        $show->field('comment', __('Comment'));
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
        $form = new Form(new Review());

        $form->number('user_id', __('User id'));
        $form->number('store_id', __('Store id'));
        $form->decimal('rating', __('Rating'));
        $form->textarea('comment', __('Comment'));

        return $form;
    }
}