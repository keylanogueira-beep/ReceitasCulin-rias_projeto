<?php

namespace Controller;

use Model\Recipe;

class RecipeController
{
    private $recipeModel;

    public function __construct()
    {
        $this->recipeModel = new Recipe();
    }

    public function validateData(string $title, string $ingredients, string $instructions): array|null
    {
        if (empty($title) or empty($ingredients) or empty($instructions)) {
            return [
                "message" => "Preencha todos os campos obrigatórios."
            ];
        }

        return null;
    }

    public function saveRecipe(string $title, string $category, int $prep_time, string $ingredients, string $instructions, int $id_user): bool
    {
        return $this->recipeModel->createRecipe($title, $category, $prep_time, $ingredients, $instructions, $id_user);
    }

    public function deleteRecipe(int $id): bool
    {
        return $this->recipeModel->deleteRecipe($id);
    }

    public function getRecipes(int $id_user): array|bool
    {
        return $this->recipeModel->getRecipes($id_user);
    }
}
