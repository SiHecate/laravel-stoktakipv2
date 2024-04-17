<?php

namespace App\Http\Controllers;

use App\Service\RoleService;


class RoleController {

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function attachAdminRole() {

    }

    public function attachModRole() {

    }

    public function attachUserRole() {

    }

    public function listRoles() {

    }

    public function listUsersByRole() {

    }

    public function listRolesByUser() {

    }

}
