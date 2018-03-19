<?php

namespace App\Models\Traits;

use ReflectionClass;

trait ManageConstants
{
    private function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return collect($oClass->getConstants());
    }

    protected function mapConstants($prefix = null)
    {
        if (!$prefix) return false;

        $prefix = strtoupper($prefix);

        $constants = $this->getConstants()->filter(function ($item, $key) use ($prefix) {
            return starts_with($key, $prefix);
        })->map(function ($item, $key) use ($prefix) {
            return [
                'status' => $item,
                'text' => $this->cleanConstant($key, $prefix)
            ];
        })->reduce(function($carry, $item){
            $carry[$item['status']] = $item['text'];
            return $carry;
        },[]);

        return collect($constants);
    }

    public function getConstantList($prefix) {
        return $this->mapConstants($prefix)->map(function ($item, $key){
            return ['id' => $key, 'name' => $item];
        });
    }

    private function cleanConstant($string, $prefix)
    {
        return strtolower(str_replace('_', ' ', substr($string, strlen($prefix) + 1)));
    }
}