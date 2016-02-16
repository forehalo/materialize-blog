<?php namespace App\Services\Setting;

use Illuminate\Support\Facades\DB;

/**
 * Class Setting.php
 * @package     App\Services\Setting
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class Setting
{
    /**
     * Blog config array.
     *
     * @var array
     */
    protected $items;

    /**
     * The configs changed at runtime.
     *
     * @var array
     */
    protected $changed = [];

    /**
     * Setting constructor.
     */
    public function __construct()
    {
        $settings = DB::table('settings')->get();

        foreach ($settings as $item) {
            $this->items[$item->key] = $item->value;
        }

    }

    /**
     * Get setting item.
     *
     * @param string $key
     * @param string $default
     * @return array|null
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->items;
        }

        return array_key_exists($key, $this->changed) ? $this->changed[$key] : (
        array_key_exists($key, $this->items) ? $this->items[$key] : $default
        );
    }

    /**
     * Get all setting item.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Set setting item.
     * IMPORTANT! : This function just change item at runtime. Saving change may call update function.
     *
     * @param string $key
     * @param string $value
     */
    public function set($key = null, $value = null)
    {
        if (is_null($key)) {
            return;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                self::set($k, $v);
            }
        } else {
            if (array_key_exists($key, $this->items) && $this->items[$key] !== $value) {
                $this->changed[$key] = $value;
            }
        }
    }

    /**
     * Update setting items, and store in driver.
     */
    public function update()
    {
        foreach ($this->changed as $key => $value) {
            DB::table('settings')->where('key', $key)->update(['value' => $value]);
        }

        array_replace($this->items, $this->changed);
    }

    /**
     * Rollback runtime change.
     */
    public function rollback()
    {
        $this->changed = [];
    }
}