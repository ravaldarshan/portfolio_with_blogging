<?php

namespace Database\Seeders;

use App\Models\admin\Module;
use Illuminate\Database\Seeder;
use App\Models\admin\ModuleAccess;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();
        ModuleAccess::truncate();
        $modules = [
            [
                "identifiers"   => "about",
                "name"          => "About",
                "access"        => [
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ]
                ]
            ],
            [
                "identifiers"   => "banner",
                "name"          => "Banner",
                "access"        => [
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ]
                ]
            ],
            [
                "identifiers"   => "blog",
                "name"          => "Blog",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                ]
            ],
            [
                "identifiers"   => "client",
                "name"          => "Client",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
            [
                "identifiers"   => "contact",
                "name"          => "Contact",
                "access"        => [
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                ]
            ],
            [
                "identifiers"   => "gallery",
                "name"          => "Gallery",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                ]
            ],
            [
                "identifiers"   => "kategori_blog",
                "name"          => "Kategori Blog",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                ]
            ],
            [
                "identifiers"   => "kategori_project",
                "name"          => "Kategori Project",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                ]
            ],
            [
                "identifiers"   => "komentar_blog",
                "name"          => "Komentar Blog",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
            [
                "identifiers"   => "komentar_project",
                "name"          => "Komentar Project",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
            [
                "identifiers"   => "log_system",
                "name"          => "Log System",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ],
                    [
                        "identifiers" => "clear",
                        "name"        => "Clear",
                    ],
                ]
            ],
            [
                "identifiers"   => "profile",
                "name"          => "Profile",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                ]
            ],
            [
                "identifiers"   => "project",
                "name"          => "Project",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                ]
            ],
            [
                "identifiers"   => "service",
                "name"          => "Service",
                "access"        => [
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                ]
            ],
            [
                "identifiers"   => "settings",
                "name"          => "Settings",
                "access"        => [
                    [
                        "identifiers" => "main",
                        "name"        => "Main",
                    ],
                    [
                        "identifiers" => "frontpage",
                        "name"        => "Frontpage",
                    ],
                    [
                        "identifiers" => "admin",
                        "name"        => "Admin",
                    ],
                    [
                        "identifiers" => "admin_general",
                        "name"        => "Admin_general",
                    ],
                    [
                        "identifiers" => "frontpage_general",
                        "name"        => "Frontpage_general",
                    ],
                    [
                        "identifiers" => "frontpage_footer",
                        "name"        => "Frontpage_footer",
                    ],
                    [
                        "identifiers" => "frontpage_homepage",
                        "name"        => "Frontpage_homepage",
                    ],
                ]
            ],
            [
                "identifiers"   => "user",
                "name"          => "User",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                    [
                        "identifiers" => "status",
                        "name"        => "Status",
                    ],
                ]
            ],
            [
                "identifiers"   => "user_group",
                "name"          => "User Group",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "status",
                        "name"        => "Status",
                    ],
                ]
            ],
            [
                "identifiers"   => "module_management",
                "name"          => "Module Management",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
        ];


        foreach ($modules as $data) {
            $data_access = $data['access'];
            $data_module = [
                "identifiers"   => $data["identifiers"],
                "name"          => $data["name"]
            ];
            $module = Module::create($data_module);
            foreach ($data_access as $row) {
                $module->access()->create([
                    "identifiers" => $row["identifiers"],
                    "name"        => $row["name"]
                ]);
            }
        }
    }
}
