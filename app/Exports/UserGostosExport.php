<?php

namespace App\Exports;

use App\User;
use App\Categoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserGostosExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($users)
    {
        $this->users = $users;
        $this->categorias = Categoria::whereNotNull('titulo_pt')->get();
    }

    public function collection()
    {
        return $this->users->map(function ($user) {
            return $user;
        });
    }

    public function map($user): array
    {
        $user->load('categorias');

        $categoriasNotasMedias = $this->categorias->map(function ($categoria) use ($user) {

            $categoriaCriada = $user->categorias()->find($categoria->id);
            if (filled($categoriaCriada) && filled($categoriaCriada->pivot)) {
                $notasTotal = $categoriaCriada->pivot->notas_total;
                $notasQuantidade = $categoriaCriada->pivot->notas_quantidade;
                if ($notasTotal && $notasQuantidade) {
                    return number_format($notasTotal / $notasQuantidade, 2);
                }
            }

            return '0';
        })->toArray();

        return array_merge([
            $user->id
        ], $categoriasNotasMedias);
    }

    public function headings(): array
    {
        $titulosCategorias = $this->categorias->map(function ($categoria) {
            return str_slug($categoria->titulo_pt);
        })->toArray();

        return array_merge([
            'id'
        ], $titulosCategorias);
    }
}
