<?php namespace App\Repositories;

use App\Models\Admin;
use App\Models\Link;

/**
 * Class AdminRepository.php
 * @package     App\Repositories
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class AdminRepository
{

    /**
     * Blog setting items.
     *
     * @var array
     */
    protected $items;

    /**
     * Admin Model
     */
    protected $model;

    /**
     * AdminRepository constructor.
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->items = setting()->all();
        $this->model = $admin;
    }

    /**
     * Get all setting items.
     *
     * @return array
     */
    public function blogConfig()
    {
        return $this->items;
    }

    /**
     * Update setting items.
     *
     * @param $inputs
     */
    public function update($inputs)
    {
        foreach ($inputs as $key => $value) {
            setting()->set($key, $value);
        }

        setting()->update();
    }

    /**
     * Update friend link, new when don't exists.
     *
     * @param $inputs
     */
    public function updateFriend($inputs)
    {
        if (isset($inputs['id'])) {
            $friend = Link::find($inputs['id']);
        } else {
            $friend = new Link();
        }

        $friend->name = $inputs['name'];
        $friend->link = $inputs['link'];

        $friend->save();
    }

    public function authReset($inputs, $auth)
    {
        $admin = $this->model->first();

        $admin->name = $inputs['name'];
        $admin->email = $inputs['email'];

        if (!is_null($inputs['password']) && $inputs['password'] != '') {
            $admin->password = bcrypt($inputs['password']);

            $auth->login($admin, true);

            session([
                'user_name' => $inputs['name'],
                'user_email' => $inputs['email']
            ]);

        }

        $admin->update();
    }
}