<?php

namespace App\Services;

use App\Models\PromotionModel;

class PromotionService
{
    protected $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }
    public function getAll()
    {
        return $this->promotionModel->findAll();
    }
    public function ajouterPromotion($promotion)
    {
        $promotion = trim($promotion ?? '');

        if ($promotion === '') {
            return false;
        }

        return $this->promotionModel->save([
            'promotion' => $promotion
        ]);
    }
    public function supprimerPromotion($id)
    {
        return $this->promotionModel->delete($id);
    }
    public function verifierPromotion($numero)
    {
        $promotions = $this->promotionModel->findAll();

        foreach ($promotions as $promotion) {
            if (strpos($numero, $promotion['promotion']) === 0) {
                return true;
            }
        }

        return false;
    }
}