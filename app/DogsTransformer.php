<?php

namespace App;

class DogsTransformer
{
    protected $dog;
    protected $embeds;

    public function __construct($dog, $embeds = [])
    {
        $this->dog = $dog;
        $this->embeds = $embeds;
    }

    public function toArray()
    {
        $append = [];

        if (in_array('toys', $this->embeds)) {
            $append['toys'] = $this->dog->toys->map(function($toy) {
                return (new ToyTransformer($toy))->toArray();
            });
        }
        return array_merge([
            'id' => $this->dog->id,
            'nome' => strtoupper($this->dog->name),
            'datas' => sprintf(
                "%s - %s",
                $this->dog->created_at->format('d/m/Y H:i:s'),
                $this->dog->updated_at->format('d/m/Y H:i:s')
            )
        ], $append);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
