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
    protected $items;

    public function __construct()
    {
        $this->items = setting()->all();
    }

    public function blogConfig()
    {
        return $this->items;
    }

    public function update($inputs)
    {
        foreach ($inputs as $key => $value) {
            setting()->set($key, $value);
        }

        setting()->update();
    }
}