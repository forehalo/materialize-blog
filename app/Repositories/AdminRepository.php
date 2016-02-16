<?php namespace App\Repositories;
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
}