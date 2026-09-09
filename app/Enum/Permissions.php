<?php

namespace App\Enum;

enum Permissions: string
{
    case VIEW_ALL_CUSTOMER = 'view_all_customer';
    case VIEW_CUSTOMER = 'view_customer';
    case CREATE_CUSTOMER = 'create_customer';
    case UPDATE_CUSTOMER = 'update_customer';
    case DELETE_CUSTOMER = 'delete_customer';

    public function label(): string
    {
        return match ($this) {
            self::VIEW_ALL_CUSTOMER => 'Visualizza tutti i clienti',
            self::VIEW_CUSTOMER => 'Visualizza cliente',
            self::CREATE_CUSTOMER => 'Crea cliente',
            self::UPDATE_CUSTOMER => 'Modifica cliente',
            self::DELETE_CUSTOMER => 'Elimina cliente',
        };
    }
}
