<?php

namespace App\Services;

use App\Models\BaremeModel;

class FraisService
{
    protected $baremeModel;

    public function __construct()
    {
        $this->baremeModel = new BaremeModel();
    }
    public function getFrais($type, $montant)
    {
        $bareme = $this->baremeModel
            ->where('type_operation', $type)
            ->where('montant_min <=', $montant)
            ->where('montant_max >=', $montant)
            ->first();

        if ($bareme) {
            return (float) $bareme['frais'];
        }

        return 0;
    }
}