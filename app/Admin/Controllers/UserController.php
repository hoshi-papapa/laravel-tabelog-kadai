<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('nickname', __('Nickname'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('occupation', __('Occupation'));
        $grid->column('age', __('Age'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_ad', __('Updated at'))->sortable();
        $grid->column('deleted_at', __('Deleted at'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', 'ユーザー名');
            $filter->like('email', 'メールアドレス');
            $filter->like('address', '住所');
            $filter->like('phone_number', '電話番号');
            $filter->between('created_at', '登録日')->datetime();
            $filter->scope('trashed', 'Soft deleted data')->onlyTrashed();
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('nickname', __('Nickname'));
        $show->field('phone_number', __('Phone number'));
        $show->field('occupation', __('Occupation'));
        $show->field('age', __('Age'));;
        $show->field('created_at', __('Created at'));
        $show->field('updated_ad', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('nickname', __('Nickname'));
        $form->text('phone_number', __('Phone number'));
        $form->text('occupation', __('Occupation'));
        $form->number('age', __('Age'));
        $form->datetime('deleted_at', __('Deleted at'))->default(NULL);

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        return $form;
    }
}