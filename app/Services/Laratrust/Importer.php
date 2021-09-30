<?php


namespace App\Services\Laratrust;

use App\Role;
use App\Permission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


/**
 * Description of PermissionImporter
 *
 *
 */
class Importer
{


    const CHUNK_SIZE = 5;

    private $csvFilePath = null;
    private $data = [];

    private function __construct($csvFilePath)
    {
        $this->csvFilePath = $csvFilePath;
    }

    public static function getInstance(string $csvFilePath)
    {
        if (!file_exists($csvFilePath))
        {
            throw new Exception($csvFilePath . " not found!");
        }

        return new Importer($csvFilePath);
    }

    /*
     * This function asumes the csv to be in following format
     * where each column is separated by comma and csv should
     * have following headers:
     *
     * permission_name,permission_display_name,permission_description,<role_1>,<role_2>,...,<role_n>
     *
     * Each role should either contain "y" or "n" depending on whether that particular
     * permission should be associated with that role or not
     */

    public function importRoleAndPermissions()
    {
        v_echo("Import - Started");

        $data = $this->loadDataFromCSV();
        $this->clearTables();
        $this->createRoles($data['roles']);
//        dd($data);
//        $rolePermissions = $this->createPermissions($data['permissions']);
//        $this->assignPermissions($rolePermissions);
        info("Import - Completed");
    }

    private function clearTables()
    {
        $tablesToTruncate = [
            "permission_user",
            "permission_role",
            "permissions",
            "role_user",
            "roles"
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tablesToTruncate as $table)
        {
            v_echo("Truncating $table...");
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createPermissions($permissions)
    {
        $rolePermissions = [];

        foreach ($permissions as $permission)
        {
            $perm = Permission::create($this->getFillables(new Permission(), $permission));

            logger(PHP_EOL . "Created new permission: "
                . PHP_EOL . "Name:\t" . $perm->name
                . PHP_EOL . "Disp:\t" . $perm->display_name
                . PHP_EOL . "Desc:\t" . $perm->description);

            foreach ($permission['assignments'] as $roleName)
            {
                if (!isset($rolePermissions[$roleName]))
                {
                    $rolePermissions[$roleName] = [];
                }

                array_push($rolePermissions[$roleName], $perm->id);
            }
        }

        return $rolePermissions;
    }
    private function getFillables($model, $associativeArray)
    {
        return Arr::only($associativeArray, (new $model())->getFillable());
    }
    private function assignPermissions($rolePermissions)
    {
        foreach ($rolePermissions as $roleName => $permissionIds)
        {
            v_echo("Assigning " . count($permissionIds) . " Permissions to Role $roleName");
            Role::where("name", $roleName)->first()->syncPermissions($permissionIds);
        }
    }

    private function readRoles($strRoles)
    {
        $roles = [];

        foreach ($strRoles as $strRole)
        {
            $parts = explode(";", $strRole);
            $roles[] = [
                'name' => $parts[0],
                'display_name' => isset($parts[1]) ? $parts[1] : null,
                'description' => isset($parts[2]) ? $parts[2] : null
            ];
        }

        return $roles;
    }

    private function createRoles($roles)
    {
        foreach ($roles as $role)
        {
            v_echo(PHP_EOL . "Creating new role:"
                . PHP_EOL . "Name:\t" . $role['name']
                . PHP_EOL . "Disp:\t" . $role['display_name']
                . PHP_EOL . "Desc:\t" . $role['description']);

            Role::create($role);
        }
    }

    private function loadDataFromCSV()
    {
        $hFile = fopen($this->csvFilePath, "r");

        $headers = fgetcsv($hFile);
        $strRoles = array_slice($headers, 3);
        $roles = $this->readRoles($strRoles);

        $rolesCount = count($roles);
        $permissions = [];
        while(!feof($hFile))
        {
            $row = fgetcsv($hFile);
            $permissionName = $row[0];
            $assignments = [];
            for ($i = 0; $i < $rolesCount; $i++)
            {
                $roleName = $roles[$i]['name'];
                if ($row[$i + 3] == "y")
                {
                    $assignments[] = $roleName;
                }
            }

            $permissions[$permissionName] = [
                "name" => $permissionName,
                "display_name" => $row[1],
                "description" => $row[2],
                "assignments" => $assignments
            ];
        }

        fclose($hFile);

        $data["roles"] = $roles;
        $data["permissions"] = $permissions;

        return $data;
    }
}
