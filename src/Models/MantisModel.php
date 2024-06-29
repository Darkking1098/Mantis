<?php

namespace Mantis\Models;

use Illuminate\Database\Eloquent\Model;
use Mantis\Helpers\Traits\MantisModelTrait;

class MantisModel extends Model
{
    use MantisModelTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        foreach (static::$m_a_f as $key => $value) {
            $key == 'function' ?:
                $this->$key = array_merge($this->$key ?? [], $value);
        }
        foreach (static::$m_r_f as $key => $value) {
            $this->$key = array_diff($this->$key ?? [], $value);
        }
        foreach (static::$m_a_e as $event => $listeners) {
            foreach ($listeners as $listener) static::{$event}($listener);
        }
    }

    public function __call($m, $p)
    {
        return array_key_exists($m, static::$m_a_f['function'] ?? []) ? static::$m_a_f['function'][$m]($this) : parent::__call($m, $p);
    }
}
