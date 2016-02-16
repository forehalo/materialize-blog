<?php namespace App\Repositories;

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
     * AdminRepository constructor.
     */
    public function __construct()
    {
        $this->items = setting()->all();
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
}