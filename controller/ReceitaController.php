<?php
namespace Controller;

use Model\Receita;

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new Receita();
    }

    public function index(): void {
        $receitas = $this->model->listarTodas();
        $this->render('lista_receitas', ['receitas' => $receitas]);
    }

    public function buscar(string $termo): void {
        $receitas = $this->model->buscarPorTermo($termo);
        $this->render('lista_receitas', ['receitas' => $receitas, 'termo' => $termo]);
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require_once __DIR__ . "/../View/{$view}.php";
    }
}